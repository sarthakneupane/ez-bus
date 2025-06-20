@extends('company.layouts.master')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Customer Reviews</h2>
    </div>

    @if($reviews->isEmpty())
        <div class="alert alert-info">
            No reviews found for your company.
        </div>
    @else
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Rating</th>
                                <th>Review</th>
                                <th>Vehicle</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reviews as $review)
                            <tr>
                                <td>
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->stars)
                                            <i class="fas fa-star text-warning"></i>
                                        @else
                                            <i class="far fa-star text-secondary"></i>
                                        @endif
                                    @endfor
                                </td>
                                
                                <td>{{ Str::limit($review->message, 50) }}</td>
                                <td>{{ $review->booking->schedule->vehicleHasRoutes->vehicle->vehicle_no }}</td>
                                <td>{{ optional($review->created_at)->format('M d, Y') }}</td>

                                <td>
                                    <a href="{{ route('company.reviews.show', $review->id) }}" 
                                       class="btn btn-sm btn-primary">
                                        <i class="las la-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-3">
            {{ $reviews->links() }}
        </div>
    @endif
</div>
@endsection