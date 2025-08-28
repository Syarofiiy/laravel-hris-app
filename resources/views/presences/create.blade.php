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
                <h3>Presence</h3>
                <p class="text-subtitle text-muted">Handle presences data</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/" class="text-danger">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Presence</li>
                        <li class="breadcrumb-item active" aria-current="page">New</li>
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

                @if (session('role') == 'HR')

                <form action="{{ route('presences.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="" class="form-label">Employee</label>
                        <select name="employee_id" class="form-control @error('employee_id') is-invalid @enderror">
                            <option value="">Select an Employee</option>
                            @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->fullname }}</option>
                            @endforeach
                        </select>
                        @error('employee_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Check In</label>
                        <input type="datetime-local"
                            class="form-control datetime @error('check_in') is-invalid @enderror"
                            value="{{ old('check_in') }}" name="check_in" required>
                        @error('check_in')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Check Out</label>
                        <input type="datetime-local"
                            class="form-control datetime @error('check_out') is-invalid @enderror"
                            value="{{ old('check_out') }}" name="check_out" required>
                        @error('check_out')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Date</label>
                        <input type="datetime-local" class="form-control date @error('date') is-invalid @enderror"
                            value="{{ old('date') }}" name="date" required>
                        @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Status</label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="Present">Present</option>
                            <option value="Absent">Absent</option>
                            <option value="Leave">Leave</option>
                        </select>
                        @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Create Role</button>
                    <a href="{{ route('presences.index') }}" class="btn btn-secondary">Back to List</a>
                </form>

                @else

                <form action="{{ route('presences.store') }}" method="POST">
                    @csrf

                    <div class="mb-3"><b>Note</b>: Mohon izinkan akses lokasi, supaya presensi diterima</div>

                    <div class="mb-3">
                        <label for="" class="form-label">Latitude</label>
                        <input type="text" class="form-control" name="latitude" id="latitude" required>
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Longitude</label>
                        <input type="text" class="form-control" name="longitude" id="longitude" required>
                    </div>

                    <div class="mb-3">
                        <iframe width="500" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                            id="map" src=""></iframe>
                    </div>

                    <button type="submit" class="btn btn-primary" id="btn-present">Present</button>
                </form>

                @endif
            </div>
        </div>

    </section>
</div>

<script>
const iframe = document.getElementById('map');
const officeLat = -7.740142;
const officeLon = 110.392093;
const threshold = 0.01;

function calculateDistance(lat1, lon1, lat2, lon2) {
    const R = 6371; // Radius bumi (km)
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
        Math.sin(dLon / 2) * Math.sin(dLon / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return R * c; // dalam kilometer
}

navigator.geolocation.getCurrentPosition(function(position) {
    const lat = position.coords.latitude;
    const lon = position.coords.longitude;

    if (iframe) {
        iframe.src = `https://maps.google.com/maps?q=${lat},${lon}&output=embed`;
    }

    document.addEventListener('DOMContentLoaded', function(event) {
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lon;

        const distance = calculateDistance(lat, lon, officeLat, officeLon);

        if (distance <= threshold) {
            alert('Kamu berada di kantor, silakan presensi!');
            document.getElementById('btn-present').removeAttribute('disabled');
        } else {
            alert('Kamu tidak berada di kantor, presensi tidak diterima!');
        }
    });
});
</script>

@endsection