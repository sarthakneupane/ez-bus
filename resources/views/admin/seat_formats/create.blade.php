@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h2>Add Seat Format</h2>

    <form action="{{ route('admin.seat_formats.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Left Columns</label>
            <input type="number" name="column_left" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Right Columns</label>
            <input type="number" name="column_right" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Rows</label>
            <input type="number" name="rows" class="form-control" required>
        </div>
        <button class="btn btn-success">Create</button>
        <a href="{{ route('admin.seat_formats.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
