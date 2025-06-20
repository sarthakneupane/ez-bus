@extends('admin.layouts.master')

@section('title', 'Bus Company Details')

@section('content')
    <div class="container-fluid">
        {{-- Bread Crumb --}}
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Bus Companies</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-title">Bus Company Details</div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Bus Company Name</th>
                                <th>Owner Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                {{-- <th>No. of Buses</th> --}}
                                <th>Documents</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($buses as $bus)
                                <tr>
                                    <td>{{ $bus->id }}</td>
                                    <td>
                                        <a href="{{ route('admin.company.details', $bus->id) }}">
                                            {{ $bus->bc_name }}
                                        </a>
                                    </td>
                                    
                                    <td>{{ $bus->user->name ?? 'N/A' }}</td>
                                    <td>{{ $bus->user->email ?? 'N/A' }}</td>
                                    <td>{{ $bus->user->phone ?? 'N/A' }}</td>
                                    {{-- <td>{{ $bus->no_of_bus }}</td> --}}
                                    <td>
                                        @if($bus->company_registration)
                                            <a href="{{ Storage::url($bus->company_registration) }}" 
                                               target="_blank" 
                                               class="btn btn-sm btn-outline-primary mb-1">
                                                <i class="fas fa-file-pdf"></i> Registration
                                            </a>
                                        @endif
                                        @if($bus->cover_letter)
                                            <a href="{{ Storage::url($bus->cover_letter) }}" 
                                               target="_blank" 
                                               class="btn btn-sm btn-outline-secondary mb-1">
                                                <i class="fas fa-file-pdf"></i> Cover Letter
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($bus->status == '1')
                                            <span class="text-success">✅ Approved</span>
                                        @elseif ($bus->status == '0')
                                            <span style="color: rgb(255, 213, 0);">⌛ Pending</span>

                                        @else
                                            <span class="text-failure">❌ Rejected</span>
                                        @endif
                                        
                                    </td>
                                    <td>
                                    @if($bus->status == 0)
                                        <div class="d-flex gap-1">
                                            <form action="{{ route('admin.approveCompany', $bus->id) }}" method="POST" class="d-inline-block">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    ✔️ Approve
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.rejectCompany', $bus->id) }}" method="POST" class="d-inline-block">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to reject this company?')">
                                                    ❌ Reject
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span> - </span>
                                    @endif
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