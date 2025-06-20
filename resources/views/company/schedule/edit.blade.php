@extends('company.layouts.master')
@section('title','Edit Schedule')
@section('content')
<div class="container-fluid">
  <div class="card"><div class="card-body">
    @if($errors->any())
      <div class="alert alert-danger"><ul>
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
      </ul></div>
    @endif

    <form action="{{ route('company.schedules.update', $schedule->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="mb-3">
        <label for="vhr" class="form-label">Vehicle &amp; Route</label>
        <select name="vehicle_has_routes_id" id="vhr" class="form-control" required>
          <option value="">-- Select --</option>
          @foreach($vhrs as $vhr)
            <option 
              value="{{ $vhr->id }}"
              {{ old('vehicle_has_routes_id', $schedule->vehicle_has_routes_id) == $vhr->id ? 'selected' : '' }}>
              
              {{ $vhr->vehicle->vehicle_no }}
              ({{ optional(optional($vhr->route)->fromLocation)->name ?? 'N/A' }}
              -
              {{ optional(optional($vhr->route)->toLocation)->name ?? 'N/A' }})


            </option>
          @endforeach
        </select>
      </div>

      <div class="mb-3">
        <label for="dep" class="form-label">Departure Date &amp; Time</label>
        <input
          type="datetime-local"
          name="departure_date_time"
          id="dep"
          class="form-control"
          required
          value="{{ old('departure_date_time', \Carbon\Carbon::parse($schedule->departure_date_time)->format('Y-m-d\TH:i')) }}"
        >
      </div>

      <div class="mb-3">
        <label for="arr" class="form-label">Arrival Date &amp; Time</label>
        <input
          type="datetime-local"
          name="arrival_date_time"
          id="arr"
          class="form-control"
          required
          value="{{ old('arrival_date_time', \Carbon\Carbon::parse($schedule->arrival_date_time)->format('Y-m-d\TH:i')) }}"
        >
      </div>


     @php
    use Carbon\Carbon;
    $arrivalPassed = Carbon::parse($schedule->arrival_date_time)->isPast();
@endphp

<div class="mb-3">
  <label for="status" class="form-label">Status</label>
  <select name="status" id="status" class="form-control" required>
    <option value="1" {{ old('status', $schedule->status) == '1' ? 'selected' : '' }}>Active</option>
    <option value="2" {{ old('status', $schedule->status) == '2' ? 'selected' : '' }}>On Journey</option>
    
    @if($arrivalPassed)
      <option value="0" {{ old('status', $schedule->status) == '0' ? 'selected' : '' }}>Completed</option>
    @endif
  </select>
</div>

      

      <button class="btn btn-primary">Update</button>
      <a href="{{ route('company.schedules') }}" class="btn btn-secondary">Cancel</a>
    </form>

  </div></div>
</div>
@endsection
