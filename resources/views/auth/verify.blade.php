@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h3>Verify Your Email</h3>

    @if (session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <p>Before proceeding, please check your email for a verification link.</p>
    <p>If you did not receive the email, click the button below:</p>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn btn-primary">Resend Verification Email</button>
    </form>
</div>
@endsection
