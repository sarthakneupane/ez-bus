<!-- resources/views/company/add.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Add New Company</h3>

    @if(session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif

    <form action="{{ route('company.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Company Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">No. of Buses</label>
            <input type="number" class="form-control" id="address" name="no_of_bus" value="{{ old('address') }}" required>
            @error('address')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Add Company</button>
    </form>
</div>
@endsection
