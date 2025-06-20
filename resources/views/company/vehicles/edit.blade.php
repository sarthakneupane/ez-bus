@extends('company.layouts.master')

@section('title', 'Edit Vehicle')

@section('content')
    <div class="container-fluid">
        {{-- Error and success message --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Vehicle form --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Vehicle</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('company.vehicles.update', $vehicle->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="vehicle_no" class="form-label">Vehicle Number</label>
                                <input type="text" name="vehicle_no" id="vehicle_no" class="form-control" 
                                       value="{{ old('vehicle_no', $vehicle->vehicle_no) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="vehicle_type_id" class="form-label">Vehicle Type</label>
                                <select name="vehicle_type_id" id="vehicle_type_id" class="form-control" required>
                                    <option value="">Select Vehicle Type</option>
                                    @foreach($vehicleTypes as $type)
                                        <option value="{{ $type->id }}" 
                                            {{ old('vehicle_type_id', $vehicle->vehicle_type_id) == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="vehicle_class_id" class="form-label">Vehicle Class</label>
                                <select name="vehicle_class_id" id="vehicle_class_id" class="form-control" required>
                                    <option value="">Select Vehicle Class</option>
                                    @foreach($vehicleClasses as $class)
                                        <option value="{{ $class->id }}" 
                                            {{ old('vehicle_class_id', $vehicle->vehicle_class_id) == $class->id ? 'selected' : '' }}>
                                            {{ $class->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="seat_formats_id" class="form-label">Seats Format</label>
                                <select name="seat_formats_id" id="seat_formats_id" class="form-control" required>
                                    <option value="">Select Seats Format</option>
                                    @foreach($seatFormats as $format)
                                        <option value="{{ $format->id }}" 
                                            {{ old('seat_formats_id', $vehicle->seat_formats_id) == $format->id ? 'selected' : '' }}>
                                            {{ $format->column_left }} x {{ $format->column_right }} x {{ $format->rows }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="amenities" class="form-label">Amenities</label>
                                <input type="text" name="amenities" id="amenities" class="form-control" 
                                       value="{{ old('amenities', $vehicle->amenities) }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            {{-- Current Image Preview --}}
                            <div class="mb-3">
                                <label class="form-label">Current Vehicle Image</label>
                                @if($vehicle->image)
                                    <div>
                                        <img src="{{ asset('storage/' . $vehicle->image) }}" alt="Current Vehicle Image" 
                                             class="img-thumbnail mb-2" style="max-height: 200px;">
                                    </div>
                                @else
                                    <p class="text-muted">No image uploaded</p>
                                @endif
                                <label for="image" class="form-label">Update Vehicle Image</label>
                                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                <small class="text-muted">Leave blank to keep current image</small>
                            </div>

                            {{-- Current PDF Preview --}}
                            <div class="mb-3">
                                <label class="form-label">Current Registration Document</label>
                                @if($vehicle->registration_pdf)
                                    <div>
                                        <a href="{{ asset('storage/' . $vehicle->registration_pdf) }}" target="_blank" 
                                           class="btn btn-sm btn-outline-primary mb-2">
                                            View Current PDF
                                        </a>
                                    </div>
                                @else
                                    <p class="text-muted">No document uploaded</p>
                                @endif
                                <label for="registration_pdf" class="form-label">Update Registration Document</label>
                                <input type="file" name="registration_pdf" id="registration_pdf" class="form-control" accept=".pdf">
                                <small class="text-muted">Leave blank to keep current document</small>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Update Vehicle</button>
                        <a href="{{ route('company.vehicles') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection