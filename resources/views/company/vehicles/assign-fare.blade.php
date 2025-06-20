{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <h2>Assign Fare to Vehicle: {{ $vehicle->vehicle_no }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('company.vehicles.store-assign-fare', $vehicle->id) }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="fare_id">Select Fare</label>
            <select name="fare_id" id="fare_id" class="form-control" required>
                <option value="">-- Select Fare --</option>
                @foreach($fares as $fare)
                    <option value="{{ $fare->id }}">
                        Route: {{ $fare->route->from->name }} - {{ $fare->route->to->name }}, Price: {{ $fare->fare }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Assign Fare</button>
    </form>
</div>
@endsection --}}
