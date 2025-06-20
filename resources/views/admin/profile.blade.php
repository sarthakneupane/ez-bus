@extends('admin.layouts.master')

@section('content')
<div class="container mt-5 d-flex justify-content-center">
    <div class="card shadow-lg w-100" style="max-width: 600px;">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">👤 Admin Profile</h4>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">👤 Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $user->name) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">📧 Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $user->email) }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="user_phone" class="form-label">📞 Phone</label>
                    <input type="text" name="user_phone" class="form-control @error('user_phone') is-invalid @enderror"
                        value="{{ old('user_phone', $user->phone) }}" required>
                    @error('user_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <hr class="my-4">

                <h6 class="text-muted">🔒 Change Password</h6>

                <div class="mb-3 mt-2">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                        placeholder="Leave blank to keep current">
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-success">✅ Update Profile</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
