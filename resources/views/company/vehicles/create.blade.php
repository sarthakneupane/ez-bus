@extends('company.layouts.master')

@section('title', 'Add New Vehicle')

@section('content')
    <div class="container-fluid">
        {{-- Error and success message --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        {{-- Validation Error Messages --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {{-- Vehicle form --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add New Vehicle</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('company.vehicles.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="vehicle_no" class="form-label">Vehicle Number</label>
                        <input type="text" name="vehicle_no" id="vehicle_no" class="form-control" required>
                    </div>

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
                        <label for="seat_formats_id" class="form-label">Seats Format</label>
                        <select name="seat_formats_id" id="seat_formats_id" class="form-control" required>
                            <option value="">Select Seats Format</option>
                            @foreach($seatFormats as $format)
                                <option value="{{ $format->id }}">
                                    {{ $format->column_left }} x {{ $format->column_right }} x {{ $format->rows }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="amenities" class="form-label">Amenities</label>
                        <input type="text" name="amenities" id="amenities" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="registration_pdf" class="form-label">Vehicle Registration (PDF)</label>
                        <input type="file" name="registration_pdf" id="registration_pdf" class="form-control" accept=".pdf">
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Vehicle Image</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Vehicle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
