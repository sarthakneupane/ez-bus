@extends('company.layouts.master')
@section('title','Schedule History')
@section('content')
<div class="container-fluid">
  <a href="{{ route('company.schedules') }}" class="btn btn-primary mb-3">Back to Active</a>

  <div class="card"><div class="card-body">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Vehicle No</th>
          <th>Route</th>
          <th>Departure</th>
          <th>Arrival</th>
          <th>Booked Seats</th>
        </tr>
      </thead>
      <tbody>
        @foreach($schedules as $s)
        <tr>
          <td>{{ $s->id }}</td>
          <td>{{ $s->vehicleHasRoute->vehicle->vehicle_no }}</td>
          <td>{{ $s->vehicleHasRoute->route->fromLocation->name }} &rarr; {{ $s->vehicleHasRoute->route->toLocation->name }}</td>
          <td>{{ $s->departure_date_time }}</td>
          <td>{{ $s->arrival_date_time }}</td>
          <td>{{ $s->bookings_count }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div></div>
</div>
@endsection