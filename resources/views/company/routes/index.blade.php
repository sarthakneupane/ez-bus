@extends('company.layouts.master')
@section('title','Manage Vehicle Routes')

@section('content')
<div class="container-fluid">
  <a href="{{ route('company.routes.create') }}" class="btn btn-primary mb-3">
    Assign Routes to Vehicle
  </a>

  <div class="card">
    <div class="card-body">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Image</th>
            <th>Vehicle No</th>
            <th>Assigned Routes</th>
            <th>Fare</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($vehicles as $v)
            <tr>
              <td>
                @if($v->image)
                    <img src="{{ asset('storage/' . $v->image) }}" alt="Vehicle Image" class="img-thumbnail" style="max-width: 100px;">
                @else
                    <span class="text-muted">No Image</span>
                @endif
            </td>
              <td>{{ $v->vehicle_no }}</td>
              <td>
                @if($v->routes->count())
                  @foreach($v->routes as $r)
                    <div>
                      
                        {{ $r->fromLocation->name }} &rarr; {{ $r->toLocation->name }}
                      
                    </div>
                  @endforeach
                @else
                  <span class="text-muted">N/A</span>
                @endif
              </td>
              <td>
                @if($v->routes->count())
                  @foreach($v->routes as $r)
                    <div>
                      Rs. {{ number_format($v->adjustedFare($r), 2) }}
                    </div>
                  @endforeach
                @else
                  <span class="text-muted">N/A</span>
                @endif
              </td>
              <td>
                {{-- <a href="{{ route('company.routes.edit', $v->id) }}" class="btn btn-warning btn-sm">Edit</a> --}}
                <form action="{{ route('company.routes.destroy', $v->id) }}" method="POST" style="display:inline;">
                  @csrf @method('DELETE')
                  <button onclick="return confirm('Remove all routes?')" class="btn btn-danger btn-sm">
                    Remove
                  </button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
