@extends('admin.layouts.master')

@section('title', 'Routes')

@section('content')
    <div class="container-fluid">

        {{-- Bread Crumb --}}
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Routes</li>
                    </ol>
                </nav>
            </div>
        </div>

        

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title">Locations</div>
                {{-- Button to Add Routes --}}
                <div class="mb-3">
                    <a href="{{ route('admin.route.add') }}" class="btn btn-primary">Add New Route</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Fare</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($routes as $route)
                                <tr>
                                    <td>{{ $route->id }}</td>
                                    <td>{{ $route->fromLocation->name }}</td>
                                    <td>{{ $route->toLocation->name }}</td>
                                    <th>{{ $route->fare }}</th>
                                    <td>
                                        <a href="{{ route('admin.route.edit', $route->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('admin.route.delete', $route->id) }}" method="POST" style="display:inline;">
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
