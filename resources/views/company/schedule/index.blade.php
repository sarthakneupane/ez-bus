@extends('company.layouts.master')
@section('title','Schedules')
@section('content')
<div class="container-fluid">

  {{-- Breadcrumb --}}
  <div class="row mb-2">
    <div class="col-12">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('company.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Schedules</li>
        </ol>
      </nav>
    </div>
  </div>

  
  <a href="{{ route('company.schedules.create') }}" class="btn btn-primary mb-3">Add Schedule</a>
  <a href="{{ route('company.schedules.history') }}" class="btn btn-secondary mb-3">History</a>

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
          <th>Status</th>
          <th>Actions</th>
          <th>View Bookings</th>
        </tr>
      </thead>
      <tbody>
        @foreach($schedules as $s)
        @php $vhr = $s->vehicleHasRoute; @endphp
        <tr>
          <td>{{ $s->id }}</td>
          <td>{{ $s->vehicleHasRoute->vehicle->vehicle_no }}</td>
          <td>{{ $s->vehicleHasRoute->route->fromLocation->name }} &rarr; {{ $s->vehicleHasRoute->route->toLocation->name }}</td>
          <td>{{ $s->departure_date_time }}</td>
          <td>{{ $s->arrival_date_time }}</td>
          {{-- <td>{{ ucfirst($s->status) }}</td> --}}
          <td>{{ $s->bookedSeats->count() }}</td>
          <td>
            @php
              $statusText = [
                '1' => 'Active',
                '2' => 'On Journey',
                '0' => 'Completed'
              ];
            @endphp
            {{ $statusText[$s->status] ?? 'Unknown' }}
          </td>
          
          <td>
            <a href="{{ route('company.schedules.edit', $s->id) }}" class="btn btn-warning btn-sm">Edit</a>
          </td>
          <td>
            <a href="{{ route('company.schedules.bookings', $s->id) }}"
              class="btn btn-sm btn-outline-primary">
              View Bookings
           </a>
           


          </td> 
        </tr>
        @endforeach
      </tbody>
    </table>
  </div></div>
</div>


@endsection

