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
        position: relative;
        z-index: 1;
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
        background: #062a40;
        border: none;
        width: 100%;
    }

    .btn-login:hover {
        background: #f6b407;
        color: #062a40
    }

    .form-check-label {
        color: #333;
    }

    .form-row {
        display: flex;
        gap: 1rem;
    }

    .form-row .form-group {
        flex: 1;
    }

    /* Fix for the main container */
    .main-container {
        min-height: calc(100vh - 120px); /* Adjust based on your header height */
        padding-top: 2rem;
        padding-bottom: 2rem;
        display: flex;
        justify-content: center;
        align-items: flex-start; /* Changed from center to flex-start */
    }

    /* Ensure company fields transition smoothly */
    #companyFields {
        transition: all 0.3s ease-in-out;
        overflow: hidden;
    }

    @media (max-width: 768px) {
        .form-row {
            flex-direction: column;
        }
        
        .main-container {
            min-height: calc(100vh - 100px);
            padding-top: 1rem;
            align-items: flex-start;
        }
    }
</style>

<div class="container main-container">
    <div class="col-md-8">
        <div class="card login-card">
            <div class="login-header">
                <i class="bi bi-person-plus-fill me-2"></i>Register for EZ-Bus
            </div>

            <div class="card-body p-4">
                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- Role --}}
                    
                    <div class="mb-3">
                        <label class="form-label d-block mb-1">Register As:</label>
                        <div class="d-flex gap-4">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="passenger" name="role" value="2" required checked>
                                <label class="form-check-label" for="passenger">Passenger</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="bus_company" name="role" value="1" required>
                                <label class="form-check-label" for="bus_company">Bus Company</label>
                            </div>
                        </div>
                        @error('role')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Name & Phone --}}
                    <div class="form-row mb-3">
                        <div class="form-group">
                            <label for="name" class="form-label">Full Name</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                   name="name" value="{{ old('name') }}" required autofocus>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror"
                                   name="phone" value="{{ old('phone') }}" required>
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Bus Company Fields --}}
                    <div id="companyFields" style="display: none;">
                        <div class="form-row mb-3">
                            <div class="form-group">
                                <label for="bc_name" class="form-label">Bus Company Name</label>
                                <input id="bc_name" type="text" class="form-control @error('bc_name') is-invalid @enderror"
                                       name="bc_name" value="{{ old('bc_name') }}">
                                @error('bc_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                    
                            <div class="form-group">
                                <label for="no_of_buses" class="form-label">Number of Buses</label>
                                <input id="no_of_buses" type="number" class="form-control @error('no_of_buses') is-invalid @enderror"
                                       name="no_of_buses" value="{{ old('no_of_buses') }}">
                                @error('no_of_buses')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- PDF Upload Fields --}}
                    <div class="form-row mb-3">
                        <div class="form-group">
                            <label for="company_registration" class="form-label">Company Registration Proof (PDF)</label>
                            <input id="company_registration" type="file" class="form-control @error('company_registration') is-invalid @enderror"
                                name="company_registration" accept=".pdf" >
                            @error('company_registration')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="cover_letter" class="form-label">Cover Letter (PDF)</label>
                            <input id="cover_letter" type="file" class="form-control @error('cover_letter') is-invalid @enderror"
                                name="cover_letter" accept=".pdf">
                            @error('cover_letter')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    </div>
                    
                    

                    {{-- Passwords --}}
                    <div class="form-row mb-3">
                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                   name="password" required>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="form-label">Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control"
                                   name="password_confirmation" required>
                        </div>
                    </div>

                    {{-- Terms & Conditions --}}
                    <div class="form-check mb-3">
                        <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox" id="terms" name="terms" required>
                        <label class="form-check-label" for="terms">
                            I agree to the <a href="{{ route('terms') }}" target="_blank">Terms & Conditions</a>
                        </label>
                        @error('terms')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    

                    {{-- Submit --}}
                    <div class="mb-3">
                        <button type="submit" class="btn btn-login text-white">
                            Register
                        </button>
                    </div>

                    <div class="text-center">
                        <a class="text-decoration-none" href="{{ route('login') }}">
                            Already have an account?
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const roleRadios = document.querySelectorAll('input[name="role"]');
    roleRadios.forEach(radio => {
        radio.addEventListener('change', () => {
            const companyFields = document.getElementById('companyFields');
            companyFields.style.display = document.getElementById('bus_company').checked ? 'block' : 'none';
        });
    });
</script>
@endsection