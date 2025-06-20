@extends('company.layouts.master')
@section('title','Assign Routes to Vehicle')

@section('content')
<div class="container-fluid">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Assign Routes to Vehicle</h3>
    </div>
    <div class="card-body">
      @if($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
      @endif

      <form action="{{ route('company.routes.store') }}" method="POST">
        @csrf

        <div class="mb-3">
          <label for="vehicle_id" class="form-label">Vehicle</label>
          <select name="vehicle_id" id="vehicle_id" class="form-control" required>
            <option value="">-- Select Vehicle --</option>
            @foreach($vehicles as $veh)
              <option value="{{ $veh->id }}">{{ $veh->vehicle_no }}</option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label for="route_ids" class="form-label">Select Routes</label>
          <select name="route_ids[]" id="route_ids" class="form-control" multiple required>
            @foreach($routes as $route)
  <option value="{{ $route->id }}">
    {{ $route->fromLocation->name }} &rarr; {{ $route->toLocation->name }}
  </option>
@endforeach
          </select>
          <small class="form-text text-muted">
            Hold Ctrl (Windows) or ⌘ (Mac) to select multiple.
          </small>
        </div>

        <button type="submit" class="btn btn-primary">Assign</button>
        <a href="{{ route('company.routes.index') }}" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </div>
</div>
@endsection
