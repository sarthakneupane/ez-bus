@extends('company.layouts.master')
@section('title','Edit Vehicle Routes')

@section('content')
<div class="container-fluid">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Edit Routes for {{ $vehicle->vehicle_no }}</h3>
    </div>
    <div class="card-body">
      @if($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
      @endif

      <form action="{{ route('company.routes.update', $vehicle->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
          <label class="form-label">Vehicle</label>
          <input type="text" class="form-control" value="{{ $vehicle->vehicle_no }}" readonly>
        </div>

        <div class="mb-3">
          <label for="route_ids" class="form-label">Select Routes</label>
          <select name="route_ids[]" id="route_ids" class="form-control" multiple required>
            @foreach($routes as $route)
              <option value="{{ $route->id }}"
                {{ in_array($route->id, $assigned) ? 'selected' : '' }}>
                {{ $route->fromLocation->name }} &rarr; {{ $route->toLocation->name }}
              </option>
            @endforeach
          </select>
          <small class="form-text text-muted">
            Hold Ctrl (Windows) or ⌘ (Mac) to select multiple.
          </small>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('company.routes.index') }}" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </div>
</div>
@endsection
