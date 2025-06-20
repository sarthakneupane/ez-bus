@extends('admin.layouts.master')

@section('title', 'Add Vehicle Class')

@section('content')
    <div class="container-fluid py-4">

        {{-- Bread Crumb --}}
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.vehicle_class') }}">Vehicle Classes</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Vehicle Class</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card shadow-lg">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title">Add Vehicle Class</div>
                <div class="mb-3">
                    <a href="{{ route('admin.vehicle_class') }}" class="btn btn-primary">
                        <i class="fas fa-list"></i> View Vehicle Classes
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.vehicle_class.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="vehicleClassName" class="form-label">Vehicle Class Name</label>
                        <input type="text" name="name" class="form-control" id="vehicleClassName" placeholder="Enter vehicle class name" required>
                    </div>
                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-plus-circle"></i> Add Vehicle Class
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
