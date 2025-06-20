@extends('admin.layouts.master')

@section('title', 'Vehicle Classes')

@section('content')
    <div class="container-fluid">

        {{-- Bread Crumb --}}
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Vehicle Classes</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title">Vehicle Classes</div>
                {{-- Button to Add Vehicle Class --}}
                <div class="mb-3">
                    <a href="{{ route('admin.vehicle_class.add') }}" class="btn btn-primary">Add New Vehicle Class</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vehicle_classes as $vehicle_class)
                                <tr>
                                    <td>{{ $vehicle_class->id }}</td>
                                    <td>{{ $vehicle_class->name }}</td>
                                    <td>
                                        <a href="{{ route('admin.vehicle_class.edit', $vehicle_class->id) }}" class="btn btn-warning btn-sm">Update</a>
                                        <form action="{{ route('admin.vehicle_class.delete', $vehicle_class->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
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
