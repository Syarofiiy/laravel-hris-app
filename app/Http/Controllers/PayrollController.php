<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index() {

        if (session('role') == 'HR') {
            $payrolls = Payroll::all();
        } else {
            $payrolls = Payroll::where('employee_id', session('employee_id'))->get();
        }

        return view('payrolls.index', compact('payrolls'));
    }

    public function create() {

        $employees = Employee::all();

        return view('payrolls.create', compact('employees'));
    }

    public function store(Request $request) {

        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'salary' => 'required|numeric',
            'bonuses' => 'nullable|numeric',
            'deductions' => 'nullable|numeric',
            'net_salary' => 'required|numeric',
            'pay_date' => 'required|date',
        ]);

        $netSalary = $validated['salary'] + ($validated['bonuses'] ?? 0) - ($validated['deductions'] ?? 0);

        $validated['net_salary'] = $netSalary;

        Payroll::create($validated);

        return redirect()->route('payrolls.index')->with('success', 'Payroll created successfully.');
    }

    public function edit(Payroll $payroll) {

        $employees = Employee::all();

        return view('payrolls.edit', compact('payroll', 'employees'));
    }

    public function update(Request $request, Payroll $payroll) {

        $validated = $request->validate([
            'employee_id' => 'required',
            'salary' => 'required|numeric',
            'bonuses' => 'nullable|numeric',
            'deductions' => 'nullable|numeric',
            'net_salary' => 'numeric',
            'pay_date' => 'required|date',
        ]);

        $netSalary = $validated['salary'] + ($validated['bonuses'] ?? 0) - ($validated['deductions'] ?? 0);

        $validated['net_salary'] = $netSalary;

        $payroll->update($validated);

        return redirect()->route('payrolls.index')->with('success', 'Payroll updated successfully.');
    }

    public function show(Payroll $payroll) {

        return view('payrolls.show', compact('payroll'));
    }

    public function destroy(Payroll $payroll) {
        $payroll->delete();

        return redirect()->route('payrolls.index')->with('success', 'Payroll deleted successfully.');
    }
}
