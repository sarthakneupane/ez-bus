@extends('admin.layouts.master')

@section('title', 'Location Page')

@section('content')
    <div class="container-fluid">

        {{-- Bread Crumb --}}
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Locations</li>
                    </ol>
                </nav>
            </div>
        </div>

        

        {{-- Display Locations Table --}}
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title">Locations</div>
                {{-- Button to Add Location --}}
                <div class="mb-3">
                    <a href="{{ route('admin.location.add') }}" class="btn btn-primary">Add New Location</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($locations as $location)
                                <tr>
                                    <td>{{ $location->id }}</td>
                                    <td>{{ $location->name }}</td>
                                    <td>
                                        <a href="{{ route('admin.location.edit', $location->id) }}"
                                            class="btn btn-warning btn-sm">Update</a>
                                        <form action="{{ route('admin.location.delete', $location->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="alert-danger alert">No Locations Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
