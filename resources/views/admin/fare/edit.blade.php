@extends('admin.layouts.master')

@section('title', 'Edit Fare')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Edit Fare</div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.fare.update', $fare->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Vehicle Type - Class</label>
                        <select name="vehicle_type_class_id" class="form-control" required>
                            @foreach ($vehicleTypeClasses as $vtc)
                                <option value="{{ $vtc->id }}" {{ $fare->vehicle_type_class_id == $vtc->id ? 'selected' : '' }}>
                                    {{ $vtc->vehicleType->name }} - {{ $vtc->vehicleClass->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Route</label>
                        <select name="route_id" class="form-control" required>
                            @foreach ($routes as $route)
                                <option value="{{ $route->id }}" {{ $fare->route_id == $route->id ? 'selected' : '' }}>
                                    {{ $route->from }} - {{ $route->to }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Fare Amount</label>
                        <input type="number" name="amount" class="form-control" value="{{ $fare->amount }}" required>
                    </div>

                    <button type="submit" class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
