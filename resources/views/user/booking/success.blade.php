{{-- success blade --}}

@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    Booking Confirmed!
                </div>

                <div class="card-body text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="#28a745" class="bi bi-check-circle-fill mb-4" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                    </svg>
                    
                    <h3 class="mb-3">Your booking was successful!</h3>
                    
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <p class="mb-4">Please download your ticket from My Tickets page.</p>
                    
                    <div class="d-grid gap-2 col-md-6 mx-auto">
                        <a href="{{ route('my.tickets') }}" class="btn btn-primary">
                            View My Tickets
                        </a>
                        <a href="{{ route('welcome') }}" class="btn btn-outline-secondary">
                            Back to Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection