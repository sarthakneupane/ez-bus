@extends('admin.layouts.master')

@section('title', 'Manage Fare')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title">Manage Fare</div>
                <a href="{{ route('admin.fare.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Add New Fare Increment
                </a>
            </div>
            
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Vehicle Type - Class</th>
                                <th>Fare Increment (%)</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fares as $index => $fare)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $fare['vehicle_type'] }} - {{ $fare['vehicle_class'] }}</td>
                                    
                                    {{-- Inline edit form --}}
                                    <td>
                                        <form action="{{ route('admin.fare.update', $fare['id']) }}" method="POST" class="d-flex">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="fare_increment" 
                                                class="form-control form-control-sm me-2"
                                                placeholder="{{ $fare['fare_increment'] }}" 
                                                value="{{ $fare['fare_increment'] }}" 
                                                step="0.01" min="0"
                                                style="width: 100px;">

                                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                        </form>
                                    </td>

                                    {{-- Delete button --}}
                                    <td>
                                        <form action="{{ route('admin.fare.destroy', $fare['id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this fare?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
