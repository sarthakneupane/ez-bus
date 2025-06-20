@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2>Review for {{ $review->booking->schedule->vehicleHasRoutes->vehicle->busCompany->bc_name }}</h2>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Company:</strong> {{ $review->booking->schedule->vehicleHasRoutes->vehicle->busCompany->bc_name }}</p>
            <p><strong>Vehicle:</strong> {{ $review->booking->schedule->vehicleHasRoutes->vehicle->vehicle_no }}</p>
            <p><strong>Date:</strong> {{ $review->booking->schedule->departure_date_time }}</p>
            <p><strong>Route:</strong> {{ $review->booking->schedule->vehicleHasRoutes->route->fromLocation->name }} →
               {{ $review->booking->schedule->vehicleHasRoutes->route->toLocation->name }}</p>
        </div>
    </div>

    <div class="star-rating-container mb-4">
        <h5 class="mb-0 mr-3">Rating:</h5>
        <div class="star-rating">
            @for ($i = 5; $i >= 1; $i--)
                <label style="color: {{ $review->stars >= $i ? 'gold' : 'lightgray' }}; font-size: 2rem;">★</label>
            @endfor
        </div>
    </div>

    <div class="form-group">
        <label><strong>Review Message:</strong></label>
        <div class="border p-3 rounded bg-light">
            {{ $review->message }}
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('my.tickets') }}" class="btn btn-secondary">
            <i class="las la-arrow-left"></i> Back
        </a>
    </div>
</div>
@endsection
