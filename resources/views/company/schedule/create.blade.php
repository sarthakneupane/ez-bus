@extends('company.layouts.master')
@section('title','Add Schedule')
@section('content')
<div class="container-fluid">
  <div class="card"><div class="card-body">
    @if($errors->any())
      <div class="alert alert-danger"><ul>
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
      </ul></div>
    @endif

    <form action="{{ route('company.schedules.store') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label for="vhr" class="form-label">Vehicle & Route</label>
        <select name="vehicle_has_routes_id" id="vhr" class="form-control" required>
          <option value="">-- Select --</option>
          @foreach($vhrs as $vhr)
            <option value="{{ $vhr->id }}">
              {{ $vhr->vehicle->vehicle_no }} ({{ $vhr->route->fromLocation->name }}→{{ $vhr->route->toLocation->name }})
            </option>
          @endforeach
        </select>
      </div>
      <div class="mb-3">
        <label for="dep" class="form-label">Departure Date & Time</label>
        <input type="datetime-local" name="departure_date_time" id="dep" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="arr" class="form-label">Arrival Date & Time</label>
        <input type="datetime-local" name="arrival_date_time" id="arr" class="form-control" required>
      </div>
      {{-- <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select name="status" id="status" class="form-control">
          <option value="active">Active</option>
          <option value="inactive">Inactive</option>
        </select>
      </div> --}}

      <button class="btn btn-primary">Save</button>
      <a href="{{ route('company.schedules') }}" class="btn btn-secondary">Cancel</a>
    </form>
  </div></div>
</div>
@endsection