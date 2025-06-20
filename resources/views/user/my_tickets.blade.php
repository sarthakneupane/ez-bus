@extends('layouts.app')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    :root {
        --primary-dark: #062a40;
        --primary-accent: #0b486b;
        --secondary-accent: #f6b407;
        --success-color: #28a745;
        --info-color: #17a2b8;
        --warning-color: #ffc107;
        --danger-color: #dc3545;
    }

    .ticket-card {
        border: 1px solid #e9ecef;
        border-radius: 12px;
        transition: all 0.3s ease;
        background: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .ticket-card:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        transform: translateY(-2px);
    }

    .route-section {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-accent) 100%);
        color: white;
        border-radius: 8px 8px 0 0;
        padding: 1.25rem;
        margin-bottom: 0;
        opacity: .9;
    }

    .route-arrow {
        font-size: 1.5rem;
        color: var(--secondary-accent);
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .info-item {
        background: #f8f9fa;
        padding: 0.75rem;
        border-radius: 8px;
        border-left: 4px solid var(--primary-accent);
        transition: all 0.2s ease;
    }

    .info-item:hover {
        background: #e9ecef;
        transform: translateX(2px);
    }

    .info-item i {
        color: var(--primary-accent);
        margin-right: 0.5rem;
    }

    /* Status badges */
    .status-upcoming { background-color: var(--success-color) !important; }
    .status-journey { background-color: var(--secondary-accent) !important; color: var(--primary-dark) !important; }
    .status-completed { background-color: var(--primary-accent) !important; }
    .status-cancelled { background-color: var(--danger-color) !important; }

    .action-buttons {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        position: relative;
    }

    .btn-download {
        background: linear-gradient(45deg, #28a745, #3dd28d);
        border: none;
        color: white;
    }

    .btn-cancel {
        background: linear-gradient(45deg, #dc3545, #ff6b6b);
        border: none;
        color: white;
        position: relative;
    }

    .btn-review {
        background: linear-gradient(45deg, #ffc107, #ffab00);
        border: none;
        color: var(--primary-dark);
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        background: #f8f9fa;
        border-radius: 12px;
        border: 2px dashed #dee2e6;
        margin-top: 2rem;
    }

    .text-primary {
        color: var(--primary-accent) !important;
    }

    /* Cancellation policy tooltip */
    .cancel-tooltip {
        position: absolute;
        bottom: 100%;
        left: 0;
        background: #333;
        color: white;
        padding: 0.5rem;
        border-radius: 4px;
        font-size: 0.8rem;
        width: 200px;
        z-index: 10;
        display: none;
        margin-bottom: 5px;
    }

    .cancel-btn-wrapper:hover .cancel-tooltip {
        display: block;
    }

    @media (max-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
            width: 100%;
        }

        .action-buttons .btn {
            width: 100%;
        }

        .route-section {
            text-align: center;
        }
        
        .cancel-tooltip {
            left: 50%;
            transform: translateX(-50%);
            width: 180px;
        }
    }

    /* New additions for better visual hierarchy */
    .ticket-content {
        padding: 1.5rem;
    }

    .bus-company-name {
        color: var(--primary-accent);
        font-weight: 600;
    }

    .time-remaining {
        background-color: #fff8e1;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        color: #ff8f00;
        font-weight: 500;
    }

    .badge {
        font-weight: 500;
        padding: 0.5rem 0.75rem;
    }

    .tickets-container {
        margin-top: 2rem;
    }
</style>

@section('content')
<div class="container tickets-container">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="las la-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($bookings->isEmpty())
        <div class="empty-state">
            <i class="las la-bus" style="font-size: 4rem; color: #adb5bd; margin-bottom: 1rem;"></i>
            <h3 class="text-muted mb-3">No bookings found</h3>
            <p class="text-muted mb-4">You haven't made any bus bookings yet.</p>
            <a href="/" class="btn btn-primary">
                <i class="las la-plus me-2"></i>Book Your First Trip
            </a>
        </div>
    @else
        <div class="row">
            @foreach($bookings as $booking)
            <div class="col-12">
                <div class="ticket-card">
                    <!-- Route Header -->
                    <div class="route-section">
                        <div class="row align-items-center">
                            <div class="col-md-4 text-center text-md-start">
                                <h5 class="mb-1"><i class="las la-map-marker-alt me-2"></i>{{ $booking->from }}</h5>
                                <small class="opacity-85">Departure</small>
                            </div>
                            <div class="col-md-4 text-center">
                                <span class="route-arrow"><i class="las la-arrow-right"></i></span>
                                <div class="mt-2">
                                    <small class="opacity-85">{{ \Carbon\Carbon::parse($booking->departure_date_time)->format('d M Y, h:i A') }}</small>
                                </div>
                            </div>
                            <div class="col-md-4 text-center text-md-end">
                                <h5 class="mb-1"><i class="las la-map-marker-alt me-2"></i>{{ $booking->to }}</h5>
                                <small class="opacity-85">Destination</small>
                            </div>
                        </div>
                    </div>

                    <div class="ticket-content">
                        <!-- Bus Company Info -->
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h4 class="mb-1">
                                    <i class="las la-bus me-2"></i><span class="bus-company-name">{{ $booking->bus_company_name }}</span>
                                </h4>
                                <p class="text-muted mb-0">Vehicle: {{ $booking->vehicle_no }}</p>
                            </div>
                            <div class="text-end">
                                <!-- Status Badge -->
                                @if($booking->status == '1')
                                    <span class="badge status-cancelled fs-6">
                                        <i class="las la-times me-1"></i>Cancelled
                                    </span>
                                @else
                                    @if($booking->schedule_status == '1')
                                        <span class="badge status-upcoming fs-6">
                                            <i class="las la-clock me-1"></i>Upcoming
                                        </span>
                                    @elseif($booking->schedule_status == '2')
                                        <span class="badge status-journey fs-6">
                                            <i class="las la-route me-1"></i>On Journey
                                        </span>
                                    @elseif($booking->schedule_status == '0')
                                        <span class="badge status-completed fs-6">
                                            <i class="las la-check-circle me-1"></i>Completed
                                        </span>
                                    @endif
                                @endif
                            </div>
                        </div>

                        <!-- Booking Details Grid -->
                        <div class="info-grid mb-4">
                            <div class="info-item">
                                <i class="las la-users"></i>
                                <strong>Seats:</strong> {{ $booking->seats }}
                            </div>
                            <div class="info-item">
                                <i class="las la-money-bill-wave"></i>
                                <strong>Price per Seat:</strong> Rs.{{ number_format($booking->price) }}
                            </div>
                            <div class="info-item">
                                <i class="las la-calculator"></i>
                                <strong>Total Amount:</strong> Rs.{{ number_format($booking->price * $booking->seats) }}
                            </div>
                            <div class="info-item">
                                <i class="las la-tag"></i>
                                <strong>Booking ID:</strong> #{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="action-buttons">
                                <!-- Download Ticket -->
                                @if($booking->status == 0 && $booking->schedule_status != 0)
                                    <a href="{{ route('my-tickets.download-pdf', $booking->id) }}" class="btn btn-download btn-sm">
                                        <i class="las la-download me-1"></i> Download Ticket
                                    </a>
                                @endif

                                <!-- Cancel Button -->
                                @if($booking->status == 0 && $booking->schedule_status == 1)
                                    @php
                                        $departureTime = \Carbon\Carbon::parse($booking->departure_date_time);
                                        $now = \Carbon\Carbon::now();
                                        $canCancel = $now->diffInHours($departureTime, false) >= 24;
                                    @endphp

                                    @if($canCancel)
                                        <div class="cancel-btn-wrapper position-relative d-inline-block">
                                            <div class="cancel-tooltip">
                                                <i class="las la-info-circle me-1"></i> 80% refund will be processed within 3-5 business days
                                            </div>
                                            <form method="POST" action="{{ route('my-tickets.cancel', $booking->id) }}" class="d-inline" onsubmit="return confirm('Are you sure? 80% will be refunded.');">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-cancel btn-sm">
                                                    <i class="las la-times me-1"></i> Cancel Booking
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <button class="btn btn-cancel btn-sm" disabled title="Cancellation only allowed 24 hours before departure">
                                            <i class="las la-times me-1"></i> Cancel Booking
                                        </button>
                                    @endif
                                @endif

                                <!-- Review Button -->
                                @if($booking->status == 0 && $booking->schedule_status == 0)
                                    @if(property_exists($booking, 'review') && $booking->review)
                                        <a href="{{ route('reviews.show', $booking->review->id) }}" class="btn btn-review btn-sm">
                                            <i class="las la-eye me-1"></i> View Review
                                        </a>
                                    @else
                                        <a href="{{ route('reviews.create', ['booking_id' => $booking->id]) }}" class="btn btn-review btn-sm">
                                            <i class="las la-star me-1"></i> Write Review
                                        </a>
                                    @endif
                                @endif

                            </div>

                            <!-- Quick Info -->
                            <div class="text-end">
                                @if($booking->status == 0 && $booking->schedule_status == 1)
                                    @php
                                        $departureTime = \Carbon\Carbon::parse($booking->departure_date_time);
                                        $now = \Carbon\Carbon::now();
                                        $hoursLeft = $now->diffInHours($departureTime, false);
                                    @endphp
                                    @if($hoursLeft > 0)
                                        <span class="time-remaining">
                                            <i class="las la-clock"></i> {{ round($hoursLeft) }} hours to departure
                                        </span>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection