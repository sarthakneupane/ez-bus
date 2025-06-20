@extends('admin.layouts.master')

@section('title', 'Add Route')

@section('content')
    <div class="container-fluid py-4">

        {{-- Bread Crumb --}}
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.route') }}">Routes</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Route</li>
                    </ol>
                </nav>
            </div>
        </div>

        

        <div class="card shadow-lg">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title">Add Route</div>
                <div class="mb-3">
                    <a href="{{ route('admin.route') }}" class="btn btn-primary">
                        <i class="fas fa-list"></i> View Routes
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.route.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="from-select" class="form-label">Starting Point</label>
                        <select name="from" class="form-select w-100" required id="from-select">
                            <option value="">Select Starting Point</option>
                            @foreach ($locations as $location)
                                <option value="{{ $location->id }}">{{ $location->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 d-none" id="to-select-div">
                        <label for="to-select" class="form-label">Destination</label>
                        <select name="to" class="form-select w-100" required id="to-select">
                            <option value="">Select Destination</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="fare" class="form-label">Fare</label>
                        <input type="number" name="fare" id="fare" class="form-control" required min="0" step="0.01">
                    </div>
                    
                    
                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-plus-circle"></i> Add Route
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#from-select').select2({ width: '100%' });
            $('#to-select').select2({ width: '100%' });

            $('#from-select').change(function() {
                var from = $(this).val();
                if (from) {
                    $.ajax({
                        type: "GET",
                        url: "?getlocation&from=" + from,
                        success: function(response) {
                            $('#to-select-div').removeClass('d-none');
                            $('#to-select').empty().append('<option value="">Select Destination</option>');
                            $.each(response, function(i, item) {
                                $('#to-select').append($('<option>', {
                                    value: item.id,
                                    text: item.name
                                }));
                            });
                        }
                    });
                } else {
                    $('#to-select-div').addClass('d-none');
                    $('#to-select').empty();
                }
            });
        });
    </script>
@endpush
