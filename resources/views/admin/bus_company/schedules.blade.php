@extends('admin.layouts.master')

@section('title', $company->bc_name . ' Schedules')

@section('content')
<div class="container-fluid">
    {{-- Bread Crumb --}}
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.bus_company') }}">Bus Companies</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.company.details', $company->id)}}">{{ $company->bc_name }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Schedules</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="card-title">{{ $company->bc_name }} Schedules</div>
            <div>
                <a href="{{ route('admin.company.details', $company->id) }}" class="btn btn-secondary btn-sm me-2">
                    <i class="fas fa-arrow-left"></i> Back to Company
                </a>
                {{-- <a href="{{ route('admin.schedules.create', ['company_id' => $company->id]) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Add Schedule
                </a> --}}
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Route</th>
                            <th>Vehicle</th>
                            <th>Departure</th>
                            <th>Arrival</th>
                            <th>Booked Seats</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($schedules as $schedule)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $schedule->vehicleHasRoute->route->fromLocation->name }} &rarr; {{ $schedule->vehicleHasRoute->route->toLocation->name }}</td>
                            <td>{{ $schedule->vehicleHasRoute->vehicle->vehicle_no }}</td>
                            <td>{{ \Carbon\Carbon::parse($schedule->departure_date_time)->format('Y-m-d H:i') }}</td>
                            <td>{{ \Carbon\Carbon::parse($schedule->arrival_date_time)->format('Y-m-d H:i') }}</td>
                            {{-- <td>
                                <span class="badge bg-{{ $schedule->status ? 'success' : 'danger' }}">
                                    {{ $schedule->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td> --}}
                            <td>{{ $schedule->bookedSeats->count() }}</td>
                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection