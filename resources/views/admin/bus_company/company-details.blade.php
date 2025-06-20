@extends('admin.layouts.master')

@section('title', 'Company Details')

@section('content')
<div class="container-fluid">
     {{-- Bread Crumb --}}
     <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.bus_company') }}">Bus Companies</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $company->bc_name }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title">{{ $company->bc_name }} </div>
                <a href="{{ route('admin.company.details.schedules', $company->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> View Schedules
                </a>
            </div>
        </div>
            
        <div class="card-body">
            <ul class="list-group mb-3">
                <li class="list-group-item"><strong>Owner Name:</strong> {{ $company->user->name ?? 'N/A' }}</li>
                <li class="list-group-item"><strong>Email:</strong> {{ $company->user->email ?? 'N/A' }}</li>
                <li class="list-group-item"><strong>Phone:</strong> {{ $company->user->phone ?? 'N/A' }}</li>
                <li class="list-group-item"><strong>No. of Buses:</strong> {{ $vehicleCount }}</li>

                <li class="list-group-item">
                    <strong>Average Rating:</strong> 
                    @if($avgRating)
                        {{ number_format($avgRating, 1) }} ⭐
                    @else
                        <span class="text-muted">No reviews yet</span>
                    @endif
                </li>

               <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <strong>Status:</strong> 
                    <span class="badge bg-{{ $company->status == 1 ? 'success' : 'danger' }}">
                        {{ $company->status == 1 ? 'Approved' : 'Pending' }}
                    </span>
                </div>
                <form action="{{ route('admin.company.toggleStatus', $company->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-sm btn-{{ $company->status == 1 ? 'danger' : 'success' }}">
                        {{ $company->status == 1 ? 'Deactivate' : 'Activate' }}
                    </button>
                </form>
            </li>

            </ul>

            <h5 class="mb-3">Documents</h5>
            <div class="mb-3">
                @if($company->company_registration)
                    <a href="{{ Storage::url($company->company_registration) }}" 
                       target="_blank" 
                       class="btn btn-outline-primary btn-sm me-2">
                        <i class="fas fa-file-pdf"></i> Company Registration
                    </a>
                @endif
                @if($company->cover_letter)
                    <a href="{{ Storage::url($company->cover_letter) }}" 
                       target="_blank" 
                       class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-file-pdf"></i> Cover Letter
                    </a>
                @endif
            </div>

            <h4 class="mt-4 mb-3">Vehicle Details</h4>
            @if($company->vehicles->isEmpty())
                <div class="alert alert-info">No vehicles have been added by this company yet.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Vehicle No.</th>
                                <th>Type</th>
                                <th>Class</th>
                                <th>Seat Capacity</th>
                                <th>Registration PDF</th>
                                <th>Ratings</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($company->vehicles as $vehicle)
                                <tr>
                                    <td>{{ $vehicle->id }}</td>
                                    <td>
                                        @if($vehicle->image)
                                            <a href="{{ Storage::url($vehicle->image) }}" target="_blank">
                                                <img src="{{ Storage::url($vehicle->image) }}" 
                                                     alt="Vehicle Image" 
                                                     style="width: 80px; height: auto; border-radius: 5px; transition: transform 0.2s;"
                                                     onmouseover="this.style.transform='scale(1.1)'" 
                                                     onmouseout="this.style.transform='scale(1)'">
                                            </a>
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </td>
                                    
                                    <td>{{ $vehicle->vehicle_no }}</td>
                                    <td>{{ $vehicle->vehicleType->name ?? 'N/A' }}</td>
                                    <td>{{ $vehicle->vehicleClass->name ?? 'N/A' }}</td>
                                    <td>
                                        @php
                                            $format = $vehicle->seatFormat;
                                            $left = $format->column_left ?? 0;
                                            $right = $format->column_right ?? 0;
                                            $rows = $format->rows ?? 0;
                                            $capacity = ($left * $rows) + ($right * $rows);
                                        @endphp
                                        {{ $capacity }}
                                    </td>
                                    
                                    <td>
                                        @if($vehicle->registration_pdf)
                                            <a href="{{ Storage::url($vehicle->registration_pdf) }}" 
                                               target="_blank" 
                                               class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-file-pdf"></i> View
                                            </a>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $vehicleRating = $vehicle->reviews->avg('stars');
                                        @endphp
                                        @if($vehicleRating)
                                            {{ number_format($vehicleRating, 1) }} ⭐
                                        @else
                                            <span class="text-muted">No reviews</span>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
           <h4 class="mt-5 mb-3">Customer Reviews</h4>

@if($companyReviews->isEmpty())
    <div class="alert alert-info">No reviews submitted for this company yet.</div>
@else
    <ul class="list-group">
        @foreach($companyReviews as $review)
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div>
                    <strong>{{ $review->user->name ?? 'Anonymous' }}:</strong>
                    <p class="mb-0">{{ $review->message }}</p>
                </div>
                <span class="badge bg-primary ms-3">{{ $review->stars }} ⭐</span>
            </li>
        @endforeach
    </ul>
@endif


        </div>
    </div>
</div>
@endsection
