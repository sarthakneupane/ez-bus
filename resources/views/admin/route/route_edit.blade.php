@extends('admin.layouts.master')

@section('title', 'Edit Route')

@section('content')
    <div class="container-fluid">
        <div class="mb-3">
            <a href="{{ route('admin.route') }}" class="btn btn-primary">View Routes</a>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-title">Edit Route</div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.route.update', $route->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="from">Origin:</label>
                        <select name="from" id="from" class="form-control" required>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" {{ $route->from == $location->id ? 'selected' : '' }}>
                                    {{ $location->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="to">Destination:</label>
                        <select name="to" id="to" class="form-control" required>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" {{ $route->to == $location->id ? 'selected' : '' }}>
                                    {{ $location->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="fare" class="form-label">Fare</label>
                        <input type="number" name="fare" id="fare" class="form-control" required min="0" step="0.01" value="{{ $route->fare }}">
                    </div>
                    

                    <button type="submit" class="btn btn-success mt-3 ml-2">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
