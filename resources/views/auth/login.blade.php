@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(to right, #e0ecff, #fef9f2);
        min-height: 100vh;
    }

    .login-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
    }

    .login-header {
        background-color: #f6b407;
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
        color: #fff;
        font-size: 1.5rem;
        font-weight: bold;
        text-align: center;
        padding: 1rem;
    }

    .btn-login {
        background: linear-gradient(to right, #062a40, #0b486b);
        border: none;
    }

    .btn-login:hover {
        background: linear-gradient(to right, #0b486b, #062a40);
    }

    .form-check-label {
        color: #333;
    }
</style>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 90vh;">
    <div class="col-md-6">
        <div class="card login-card">
            <div class="login-header">
                <i class="bi bi-person-circle me-2"></i>Login to EZ-Bus
            </div>

            <div class="card-body p-4">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Email Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               name="password" required>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" name="remember" id="remember"
                               {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-login text-white px-4">
                            {{ __('Login') }}
                        </button>

                        @if (Route::has('password.request'))
                            <a class="text-decoration-none" href="{{ route('password.request') }}">
                                {{ __('Forgot Password?') }}
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
