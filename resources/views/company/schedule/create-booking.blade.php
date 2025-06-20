@extends('company.layouts.master')
@section('title', 'Add Booking')

@section('content')
<div class="container-fluid">

        {{-- Breadcrumb --}}
<div class="row mb-3">
    <div class="col-12">
        <nav aria-label="breadcrumb" class="d-flex justify-content-between align-items-center">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('company.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('company.schedules') }}">Schedules</a></li>
                <li class="breadcrumb-item"><a href="{{ route('company.schedules') }}">Bookings</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Bookings</li>
            </ol>
        </nav>
    </div>
</div>

    <h4 class="mb-4">Add New Booking</h4>

    <form action="{{ route('company.schedules.bookings.store') }}" method="POST">
        @csrf

        <input type="hidden" name="schedule_id" value="{{ $schedule_id }}">

        <div class="mb-3">
            <label for="seat_no" class="form-label">Seat No</label>
            <input type="text" class="form-control" id="seat_no" name="seat_no" required>
        </div>
        <div class="mb-3">
            <label for="boarding_point" class="form-label">Passenger Name</label>
            <input type="text" class="form-control" id="passenger_name" name="passenger_name" required>
        </div>
        <div class="mb-3">
            <label for="boarding_point" class="form-label">Passenger Phone</label>
            <input type="text" class="form-control" id="passenger_phone" name="passenger_phone" required>
        </div>
        <div class="mb-3">
            <label for="boarding_point" class="form-label">Boarding Point</label>
            <input type="text" class="form-control" id="boarding_point" name="boarding_point" required>
        </div>

        <button type="submit" class="btn btn-success">Add Booking</button>
        <a href="{{ route('company.schedules.bookings', $schedule_id) }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
