@extends('company.layouts.master')

@section('content')
<div class="container mt-4">
    <h2>Company & User Profile</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('company.profile.update') }}" method="POST">
        @csrf

        <h4>User Information</h4>

        <div class="form-group">
            <label for="name">Your Name</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $user->name) }}" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group mt-3">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email', $user->email) }}" required>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group mt-3">
            <label for="user_phone">Phone Number</label>
            <input type="text" name="user_phone" class="form-control @error('user_phone') is-invalid @enderror"
                   value="{{ old('user_phone', $user->phone) }}" required>
            @error('user_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <hr class="my-4">

        <h4>Company Information</h4>

        <div class="form-group">
            <label for="bc_name">Company Name</label>
            <input type="text" name="bc_name" class="form-control @error('bc_name') is-invalid @enderror"
                   value="{{ old('bc_name', $company->bc_name) }}" required>
            @error('bc_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group mt-3">
            <label for="no_of_buses">Number of Buses</label>
            <input type="number" name="no_of_buses" class="form-control @error('no_of_buses') is-invalid @enderror"
                   value="{{ old('no_of_buses', $company->no_of_bus) }}" required min="0">
            @error('no_of_buses')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn btn-primary mt-4">Update Profile</button>
    </form>
</div>
@endsection
