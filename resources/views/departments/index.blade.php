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
                <h3>Departments</h3>
                <p class="text-subtitle text-muted">Handle departments data</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/" class="text-danger">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Departments</li>
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
                    <a href="{{ route('departments.create') }}" class="btn btn-primary mb-3 ms-auto">New Department</a>
                </div>

                @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($departments as $department)

                        <tr>
                            <td>{{ $department->name }}</td>
                            <td>{{ $department->description }}</td>
                            <td>{{ $department->status }}</td>

                            <td>
                                <a href="{{ route('departments.edit', $department->id) }}"
                                    class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('departments.destroy', $department->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this department?')">Delete
                                    </button>
                                </form>
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
