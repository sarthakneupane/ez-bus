@extends('admin.layouts.master')

@section('title', 'Edit Vehicle Class')

@section('content')
    <div class="container-fluid py-4">

        {{-- Bread Crumb --}}
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.vehicle_class') }}">Vehicle Classes</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Vehicle Class</li>
                    </ol>
                </nav>
            </div>
        </div>

        {{-- Edit Vehicle Class Form --}}
        <div class="card shadow-lg">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title">Edit Vehicle Class</div>
                <div class="mb-3">
                    <a href="{{ route('admin.vehicle_class') }}" class="btn btn-primary">
                        <i class="fas fa-list"></i> View Vehicle Classes
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.vehicle_class.update', $vehicle_class->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="vehicleClassName" class="form-label">Vehicle Class Name</label>
                        <input type="text" name="name" class="form-control" id="vehicleClassName" value="{{ $vehicle_class->name }}" required>
                    </div>
                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-edit"></i> Update Vehicle Class
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
