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
                <h3>Leave Requests</h3>
                <p class="text-subtitle text-muted">Manage leave requests data</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/" class="text-danger">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Leave Request</li>
                        <li class="breadcrumb-item active" aria-current="page">Index</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    Data.
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex">
                    <a href="{{ route('leave-requests.create') }}" class="btn btn-primary mb-3 ms-auto">New Leave
                        Request</a>
                </div>

                @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Leave Type</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            @if (session('role') == 'HR')
                            <th>Option</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leaveRequests as $leaveRequest)

                        <tr>
                            <td>{{ $leaveRequest->employee->fullname }}</td>
                            <td>{{ $leaveRequest->leave_type }}</td>
                            <td>{{ $leaveRequest->start_date }}</td>
                            <td>{{ $leaveRequest->end_date }}</td>
                            <td>
                                @if ($leaveRequest->status == 'confirmed')
                                <span class="text-success">{{ ucfirst($leaveRequest->status) }}</span>
                                @elseif ($leaveRequest->status == 'rejected')
                                <span class="text-danger">{{ ucfirst($leaveRequest->status) }}</span>
                                @else
                                <span class="text-warning">{{ ucfirst($leaveRequest->status) }}</span>
                                @endif
                            </td>
                            <td>
                                @if (session('role') == 'HR')
                                @if ($leaveRequest->status == 'reject' || $leaveRequest->status == 'pending')
                                <a href="{{ route('leave-requests.confirm', $leaveRequest->id) }}"
                                    class="btn btn-success btn-sm">Confirm</a>
                                @else
                                <a href="{{ route('leave-requests.reject', $leaveRequest->id) }}"
                                    class="btn btn-secondary btn-sm">Reject</a>
                                @endif
                                <a href="{{ route('leave-requests.edit', $leaveRequest->id) }}"
                                    class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('leave-requests.destroy', $leaveRequest->id) }}" method="POST"
                                    style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this leaveRequest?')">Delete</button>
                                </form>
                                @endif
                            </td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>

@endsection
