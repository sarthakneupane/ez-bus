@extends('admin.layouts.master')

@section('title', 'Edit Vehicle Type')

@section('content')
    <div class="container-fluid">

        {{-- Bread Crumb --}}
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.vehicle_type.index') }}">Vehicle Types</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Vehicle Type</li>
                    </ol>
                </nav>
            </div>
        </div>



        {{-- Edit Location Form --}}
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title">Add Vehicle Type</div>
                <div class="mb-3">
                    <a href="{{ route('admin.vehicle_type.index') }}" class="btn btn-primary">View Vehicle Types</a>
                    
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.vehicle_type.update', $vehicle_type->id) }}" method="POST" class="w-100 d-flex">


                    @csrf
                    @method('PUT')
                    <input type="text" name="name" class="form-control input-square" id="vehicleTypeName" value="{{ $vehicle_type->name }}" required style="flex: 1;">
                    <button type="submit" class="btn btn-success ml-2" style="width: auto;">Update</button>
                </form>
            </div>
        </div>

    </div>
@endsection
