<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Payroll;
use App\Models\Presence;
use App\Models\Task;

class DashboardController extends Controller
{
    public function index()
    {
        $employee = Employee::count();
        $department = Department::count();
        $payroll = Payroll::count();
        $presence = Presence::count();
        $tasks = Task::all();

        return view('dashboard.index', compact('employee', 'department', 'payroll', 'presence', 'tasks'));
    }

    public function presence()
{
    $data = Presence::where('status', 'present')
        ->selectRaw('MONTH(date) as month, YEAR(date) as year, COUNT(*) as total_presences')
        ->groupBy('year', 'month')
        ->orderByRaw('year ASC, month ASC')
        ->get();

    $monthlyData = array_fill(0, 12, 0);

    foreach ($data as $item) {
        $monthIndex = $item->month - 1;
        if ($monthIndex >= 0 && $monthIndex < 12) {
            $monthlyData[$monthIndex] = $item->total_presences;
        }
    }

    return response()->json($monthlyData);
}

}
