@extends('layouts.dashboard')

@section('content')

<header class="mb-3">
    <a href="#" class="burger-btn d-block d-xl-none">
        <i class="bi bi-justify fs-3"></i>
    </a>
</header>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Presences</h3>
                <p class="text-subtitle text-muted">Handle presences data</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/" class="text-danger">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Presence</li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    Create.
                </h5>
            </div>
            <div class="card-body">

                @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('presences.update', $presence->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="" class="form-label">Employee</label>
                        <select name="employee_id" class="form-control" @error('employee_id') is-invalid @enderror>
                            <option value="">Select an Employee</option>
                            @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}"
                                {{ ($employee->id == $presence->employee_id) ? 'selected' : '' }}>
                                {{ $employee->fullname }}</option>
                            @endforeach

                        </select>
                        @error('employee_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Check In</label>
                        <input type="text" class="form-control datetime @error('check_in') is-invalid @enderror"
                            value="{{ @old('check_in', $presence->check_in) }}" name="check_in" required>
                        @error('check_in')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Check Out</label>
                        <input type="datetime-local"
                            class="form-control datetime @error('check_out') is-invalid @enderror"
                            value="{{ @old('check_out', $presence->check_out) }}" name="check_out" required>
                        @error('check_out')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Date</label>
                        <input type="datetime-local" class="form-control date @error('date') is-invalid @enderror"
                            value="{{ @old('date', \Carbon\Carbon::parse($presence->date)->format('Y-m-d\TH:i')) }}"
                            name="date" required>
                        @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Status</label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="present" {{ ($presence->status == 'present') ? 'selected' : '' }}>Present
                            </option>
                            <option value="absent" {{ ($presence->status == 'absent') ? 'selected' : '' }}>Absent
                            </option>
                            <option value="leave" {{ ($presence->status == 'leave') ? 'selected' : '' }}>Leave</option>
                        </select>
                        @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update Task</button>
                    <a href="{{ route('presences.index') }}" class="btn btn-secondary">Back to List</a>

                </form>
            </div>
        </div>

    </section>
</div>

@endsection
