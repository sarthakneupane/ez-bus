@extends('company.layouts.master')

@section('title', 'Vehicles Page')

@section('content')
    <div class="container-fluid">
        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Validation Error Messages --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


        {{-- Button to Add Vehicle --}}
        <div class="mb-3">
            <a href="{{ route('company.vehicles.add') }}" class="btn btn-primary">Add New Vehicle</a>
        </div>

        {{-- Display Vehicles Table --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">Vehicles</div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Image</th>
                                <th scope="col">Vehicle No</th>
                                <th scope="col">Type</th>
                                <th scope="col">Class</th>
                                <th scope="col">Seats</th>
                                <th scope="col">Amenities</th>
                                <th scope="col">Documents</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vehicles as $vehicle)
                                <tr>
                                    <td>{{ $vehicle->id }}</td>
                                    <td>
                                        @if($vehicle->image)
                                            <img src="{{ asset('storage/' . $vehicle->image) }}" alt="Vehicle Image" class="img-thumbnail" style="max-width: 100px;">
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </td>
                                    <td>{{ $vehicle->vehicle_no }}</td>
                                    <td>{{ $vehicle->vehicleType->name }}</td>
                                    <td>{{ $vehicle->vehicleClass->name }}</td>
                                    <td>
                                        @if ($vehicle->seatFormat)
                                            {{ ($vehicle->seatFormat->column_left * $vehicle->seatFormat->rows) + ($vehicle->seatFormat->column_right * $vehicle->seatFormat->rows) }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if($vehicle->amenities)
                                            <span class="badge bg-info">{{ $vehicle->amenities }}</span>
                                        @else
                                            <span class="text-muted">None</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($vehicle->registration_pdf)
                                            <a href="{{ asset('storage/' . $vehicle->registration_pdf) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                View Registration
                                            </a>
                                        @else
                                            <span class="text-muted">No Document</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('company.vehicles.edit', $vehicle) }}" class="btn btn-warning btn-sm" >
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('company.vehicles.destroy', $vehicle) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this vehicle?')">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection