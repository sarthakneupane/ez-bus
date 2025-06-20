@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="row">
        <div class="col-12">
            <img src="{{ asset('images/busimage.jpg') }}" class="img-fluid w-100 shadow-sm" alt="Bus Image">
        </div>
    </div>

    <div class="row justify-content-center" style="margin-top: -60px; position: relative; z-index: 10;">

        <div class="col-md-10">
            <div class="card shadow-lg border-0">
                @if(Auth::check() && Auth::user()->role == '1' && Auth::user()->busCompany && Auth::user()->busCompany->status == '0')
                    <div class="alert alert-info">
                        Your company registration request is under review. Thank you for your patience!
                    </div>
                @elseif(Auth::check() && Auth::user()->role == '1' && Auth::user()->busCompany && Auth::user()->busCompany->status == '2')
                    <div class="alert alert-danger">
                            Your company registration request is rejected. Please review your application and re-apply!
                    </div>
                @else
                <div class="card-body">
                    <h4 class="text-center mb-4">Book Your Trip</h4>
                    @include('search-form', ['locations' => $locations])
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="container my-5">
    <div class="text-center mb-4">
        <h2 class="fw-bold">About Us</h2>
        <p class="text-muted">Connecting Passengers & Bus Companies with Technology</p>
    </div>

    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <img src="{{ asset('images/logoo.png') }}" alt="Easy Booking" class="img-fluid rounded shadow-sm">
            
        </div>
        <div class="col-md-6">
            <h4 class="fw-semibold mb-3">Who We Are</h4>
            <p>We are a team of passionate developers and innovators committed to transforming the traditional bus ticket booking experience in Nepal. Our online platform offers a seamless and secure way for passengers to book tickets, while empowering bus companies to manage routes, schedules, and customer interactions more efficiently.</p>
        </div>
    </div>

    <div class="row align-items-center flex-md-row-reverse mb-5">
        <div class="col-md-6">
            <img src="{{ asset('images/busimage.jpg') }}" alt="Bus Reservation" class="img-fluid rounded shadow-sm">
        </div>
        <div class="col-md-6">
            <h4 class="fw-semibold mb-3">What We Offer</h4>
            <ul class="list-unstyled">
                <li><i class="la la-check text-success me-2"></i> Easy online seat reservation</li>
                <li><i class="la la-check text-success me-2"></i> Real-time schedule and route management</li>
                <li><i class="la la-check text-success me-2"></i> User-friendly dashboard for bus companies</li>
                <li><i class="la la-check text-success me-2"></i> Admin verification for added security</li>
                <li><i class="la la-check text-success me-2"></i> Transparent fare system based on route, class & type</li>
            </ul>
        </div>
    </div>

    <div class="text-center mt-5">
        <h4 class="fw-semibold mb-3">Our Mission</h4>
        <p class="w-75 mx-auto text-muted">To simplify public transportation through technology, making ticket booking easy, fast, and accessible for everyone while enhancing transparency and trust between passengers and bus companies.</p>
    </div>
</div>
@endsection
