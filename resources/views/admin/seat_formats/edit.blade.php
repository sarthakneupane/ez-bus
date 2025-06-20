@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h2>Edit Seat Format</h2>

    <form action="{{ route('admin.seat_formats.update', $format->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Left Columns</label>
            <input type="number" name="column_left" class="form-control" value="{{ $format->column_left }}" required>
        </div>
        <div class="mb-3">
            <label>Right Columns</label>
            <input type="number" name="column_right" class="form-control" value="{{ $format->column_right }}" required>
        </div>
        <div class="mb-3">
            <label>Rows</label>
            <input type="number" name="rows" class="form-control" value="{{ $format->rows }}" required>
        </div>
        <button class="btn btn-primary">Update</button>
        <a href="{{ route('admin.seat_formats.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
