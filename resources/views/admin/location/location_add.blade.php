@extends('admin.layouts.master')

@section('title', 'Add Location')

@section('content')
    <div class="container-fluid">

        {{-- Bread Crumb --}}
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.location') }}">Locations</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Location</li>
                    </ol>
                </nav>
            </div>
        </div>

        {{-- Add New Location Form --}}

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="card-title">Add New Location</div>
                        <div class="mb-3">
                            <a href="{{ route('admin.location') }}" class="btn btn-primary">View Locations</a>
                        </div>
                    </div>
                    <form class="card-body" action="{{ route('admin.location.store') }}" method="POST" class="">
                        @csrf
                        @error('name')
                            <div class="alert alert-danger">
                                <span class="text-white">{{ $message }}</span>
                            </div>
                        @enderror
                        <div class="mb-4">
                            <label for="locationName">Location Name</label>
                            <input type="text" name="name" class="form-control input-square" id="locationName"
                                placeholder="Enter location name">
                        </div>
                        <div class="mb-4">
                            <input type="checkbox" name="stay" class="" value="on" id="stayPage"
                                placeholder="Enter location name">
                            <label for="stayPage">Stay on this page after submitting the form</label>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-outline-primary btn-sm w-100 " >Add</button>
                            </div>
                            <div class="col-md-6">
                                <button type="reset" class="btn btn-outline-warning btn-sm w-100 ">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Input Value</div>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <label for="locationName">Location Name</label>
                            <h5 id="locationValue"></h5>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection

@push('styles')
    <style>
        [type="checkbox"]:not(:checked),
        [type="checkbox"]:checked {
            position: relative;
            left: 0;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#locationName').on('input', function() {
                var value = $(this).val();
                $('#locationValue').html(value);
            });
        });
    </script>
@endpush
