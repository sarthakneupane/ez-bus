<style>
    .star-rating-container {
        display: flex;
        /* justify-content: space-between; */
        align-items: center;
        margin-bottom: 20px;
    }
    
    .star-rating {
        display: flex;
        flex-direction: row-reverse;
    }

    .star-rating input[type="radio"] {
        display: none;
    }

    .star-rating label {
        font-size: 2rem;
        color: lightgray;
        cursor: pointer;
        transition: color 0.2s;
        margin-left: 5px;
    }

    .star-rating input:checked ~ label {
        color: gold;
    }

    .star-rating label:hover,
    .star-rating label:hover ~ label {
        color: gold;
    }
</style>

@extends('layouts.app')

@section('content')



<div class="container my-5">
    <h2>Leave a Review for {{ $booking->schedule->vehicleHasRoutes->vehicle->busCompany->company_name }}</h2>


    <p>
        <strong>Company Name:</strong>
        {{  $booking->schedule->vehicleHasRoute->vehicle->busCompany->bc_name }} <br>
        <strong>Vehicle:</strong> 
        {{ $booking->schedule->vehicleHasRoutes->vehicle->vehicle_no }}<br>
        <strong>Date:</strong>
        {{  $booking->schedule->departure_date_time  }} <br>
        <strong>Route:</strong> 
        {{ $booking->schedule->vehicleHasRoutes->route->fromLocation->name }} → 
        {{ $booking->schedule->vehicleHasRoutes->route->toLocation->name }}<br>
    
        
    </p>
    
    

    <form action="{{ route('reviews.store') }}" method="POST">
        @csrf

        <input type="hidden" name="booking_id" value="{{ $booking->id }}">

        <div class="star-rating-container">
            <h5>Rating:</h5>
            <div class="star-rating">
                @for ($i = 5; $i >= 1; $i--)
                    <input type="radio" id="star{{ $i }}" name="stars" value="{{ $i }}" required>
                    <label for="star{{ $i }}">&#9733;</label> {{-- ★ --}}
                @endfor
            </div>
        </div>
        

        <div class="mb-3">
            <label for="message" class="form-label">Your Review</label>
            <textarea name="message" id="message" rows="4" class="form-control" required></textarea>
        </div>

        <button type="submit" class="btn btn-success">Submit Review</button>
    </form>
</div>
@endsection