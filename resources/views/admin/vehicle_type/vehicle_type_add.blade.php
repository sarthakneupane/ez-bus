@extends('admin.layouts.master')

@section('title', 'Add Vehicle Type')

@section('content')
    <div class="container-fluid py-4">

        {{-- Bread Crumb --}}
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.vehicle_type.index') }}">Vehicle Types</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Vehicle Type</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card shadow-lg">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title">Add Vehicle Type</div>
                <div class="mb-3">
                    <a href="{{ route('admin.vehicle_type.index') }}" class="btn btn-primary">
                        <i class="fas fa-list"></i> View Vehicle Types
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.vehicle_type.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="vehicleTypeName" class="form-label">Vehicle Type Name</label>
                        <input type="text" name="name" class="form-control" id="vehicleTypeName" placeholder="Enter vehicle type name" required>
                    </div>
                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-plus-circle"></i> Add Vehicle Type
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
