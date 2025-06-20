@extends('company.layouts.master')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Review Details</h3>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Rating</h5>
                    <div class="star-rating">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $review->stars)
                                <i class="las la-star text-warning" style="font-size: 1.5rem;"></i>
                            @else
                                <i class="las la-star text-secondary" style="font-size: 1.5rem;"></i>
                            @endif
                        @endfor
                        <span class="ml-2">{{ $review->stars }}/5</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <h5>Vehicle</h5>
                    <p>{{ $review->booking->schedule->vehicleHasRoutes->vehicle->vehicle_no }}</p>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Date</h5>
                    <p>{{ optional($review->created_at)->format('M d, Y') }}</p>

                </div>
                <div class="col-md-6">
                    <h5>Trip Date</h5>
                    <p>{{ $review->booking->schedule->departure_date_time}}</p>
                </div>
            </div>

            <div class="mb-4">
                <h5>Review Message</h5>
                <div class="border p-3 rounded bg-light">
                    {{ $review->message }}
                </div>
            </div>

            <div class="text-right">
                <a href="{{ route('company.reviews.index') }}" class="btn btn-secondary">
                    <i class="las la-arrow-left"></i> Back to Reviews
                </a>
            </div>
        </div>
    </div>
</div>
@endsection