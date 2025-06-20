@extends('admin.layouts.master')

@section('title', 'Add New Fare Increment')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Add New Fare Increment</div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.fare.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="vehicle_type_id" class="form-label">Vehicle Type</label>
                        <select name="vehicle_type_id" id="vehicle_type_id" class="form-control" required>
                            <option value="">Select Vehicle Type</option>
                            @foreach($vehicleTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="vehicle_class_id" class="form-label">Vehicle Class</label>
                        <select name="vehicle_class_id" id="vehicle_class_id" class="form-control" required>
                            <option value="">Select Vehicle Class</option>
                            @foreach($vehicleClasses as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="fare_increment" class="form-label">Fare Increment (%)</label>
                        <input type="number" name="fare_increment" id="fare_increment" 
                               class="form-control" step="0.01" min="0" required>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.fare.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection