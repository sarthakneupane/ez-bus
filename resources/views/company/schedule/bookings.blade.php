@extends('company.layouts.master')

@section('title', 'View Bookings')

@section('content')
<div class="container-fluid">

    
    {{-- Breadcrumb --}}
<div class="row mb-3">
    <div class="col-12">
        <nav aria-label="breadcrumb" class="d-flex justify-content-between align-items-center">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('company.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('company.schedules') }}">Schedules</a></li>
                <li class="breadcrumb-item active" aria-current="page">Bookings</li>
            </ol>
            <a href="{{ route('company.schedules.bookings.create', ['schedule_id' => $schedule->id]) }}" class="btn btn-primary">
                Add Booking
            </a>
        </nav>
    </div>
</div>

    


    {{-- Booking Details --}}
    <div class="card">
        <small class="text-muted">
           (<strong>{{$schedule->vehicleHasRoute->vehicle->vehicle_no ?? 'N/A'}}</strong>)
            <strong>
                {{$schedule->vehicleHasRoute->route->fromLocation->name ?? 'N/A' }}
                →
                {{ $schedule->vehicleHasRoute->route->toLocation->name ?? 'N/A' }}
            </strong>
            |
          
            <strong>{{ \Carbon\Carbon::parse($schedule->departure_date_time)->format('F j, Y h:i A') }}</strong>
        </small>
        
        <div class="card-body">
            @if($bookings->count())
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Passenger Name</th>
                            <th>Phone</th>
                            <th>Seat Numbers</th>
                            <th>Ticket Issued by</th>
                            <th>Boarding Point</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $userBookings)
                        <tr>
                            <td>{{ $userBookings->passenger_name ?? 'N/A' }}</td>
                            <td>{{ $userBookings->passenger_phone ?? 'N/A' }}</td>
                            <td>
                                {{ $userBookings->seat_number}}
                            </td>
                            <td>
                                {{ $userBookings->user->name ?? 'N/A' }} 
                                ( {{ $userBookings->user->phone ?? 'N/A' }} )<br>
                                ( {{ $userBookings->user->email ?? 'N/A' }} )
                            </td>
                            {{-- <td>
                                @php
                                    $seats = $userBookings->pluck('seat_number')->filter()->implode(', ');
                                @endphp
                                {{ $seats ?: 'N/A' }}
                            </td> --}}
                            <td>{{ $userBookings->boarding_point ?? 'N/A' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    
                </table>
            </div>
            @else
                <div class="alert alert-warning">No bookings found for this schedule.</div>
            @endif
        </div>
    </div>

</div>
@endsection
