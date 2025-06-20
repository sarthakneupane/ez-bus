@extends('layouts.app')

@section('content')
@php
    $user = Auth::user(); // assuming user is authenticated
@endphp

<div class="booking-form-container">
    <h2>Passenger Details ({{ count($seats) }} Seats)</h2>

    <form action="{{ route('booking.storedetails') }}" method="POST">
        @csrf

        @foreach ($seats as $index => $seat)
            <div class="seat-block">
                <h5>Seat {{ $seat }}</h5>
                <input type="hidden" name="seats[]" value="{{ $seat }}">

                <div class="form-group">
                    <label for="name{{ $index }}">Full Name</label>
                    <input type="text" id="name{{ $index }}" name="details[{{ $index }}][name]"
                           value="{{ $index == 0 && $user ? $user->name : '' }}" required>
                </div>

                <div class="form-group">
                    <label for="phone{{ $index }}">Phone Number</label>
                    <input type="tel" id="phone{{ $index }}" name="details[{{ $index }}][phone]"
                           value="{{ $index == 0 && $user ? $user->phone : '' }}" required>
                </div>

                <div class="form-group">
                    <label for="boarding{{ $index }}">Boarding Point</label>
                    <input type="text" id="boarding{{ $index }}" name="details[{{ $index }}][boarding_point]" required>
                </div>

                <input type="hidden" name="details[{{ $index }}][seat]" value="{{ $seat }}">
            </div>
        @endforeach

        <button type="submit" class="submit-btn">Confirm Booking</button>
    </form>
</div>

<style>
    .booking-form-container {
        max-width: 700px;
        margin: 40px auto;
        padding: 30px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .booking-form-container h2 {
        text-align: center;
        color: #2c3e50;
        margin-bottom: 25px;
        font-weight: 600;
    }

    .seat-block {
        border-bottom: 1px solid #eaeaea;
        padding-bottom: 25px;
        margin-bottom: 25px;
        background: #fafafa;
        padding: 20px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .seat-block:hover {
        background: #f5f5f5;
        transform: translateY(-2px);
    }

    .seat-block:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }

    .seat-block h5 {
        margin-bottom: 15px;
        color: #3498db;
        font-size: 18px;
        font-weight: 500;
        display: flex;
        align-items: center;
    }

    .seat-block h5:before {
        content: "📍";
        margin-right: 8px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-weight: 500;
        margin-bottom: 8px;
        color: #555;
        font-size: 14px;
    }

    .form-group input {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 15px;
        transition: border 0.3s ease;
        background-color: #fff;
    }

    .form-group input:focus {
        border-color: #3498db;
        outline: none;
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
    }

    .submit-btn {
        display: block;
        width: 100%;
        background-color: #3498db;
        color: white;
        padding: 14px;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 20px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .submit-btn:hover {
        background-color: #2980b9;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .submit-btn:active {
        transform: translateY(0);
    }

    @media (max-width: 768px) {
        .booking-form-container {
            margin: 20px auto;
            padding: 20px;
        }

        .seat-block {
            padding: 15px;
        }
    }

    @media (max-width: 480px) {
        .booking-form-container {
            margin: 10px auto;
            padding: 15px;
        }

        .seat-block h5 {
            font-size: 16px;
        }

        .form-group input {
            padding: 10px 12px;
        }

        .submit-btn {
            padding: 12px;
            font-size: 15px;
        }
    }
</style>
@endsection
