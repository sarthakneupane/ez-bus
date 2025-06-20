<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<style>
    .search-form-container {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        padding: 25px;
        margin-bottom: 30px;
        z-index: 1;
    }
    
    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 8px;
    }
    
    .custom-search-btn {
        background-color: #0a3b55;
        color: white;
        transition: all 0.3s ease;
        height: 48px;
        font-weight: 600;
        border: none;
        border-radius: 6px !important;
    }
    
    .custom-search-btn:hover {
        background-color: #F6B407;
        color: #000;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .select2-container {
        width: 100% !important;
    }
    
    .select2-selection--single {
        height: 48px !important;
        border: none !important;
        background: transparent !important;
    }
    
    .select2-selection__rendered {
        line-height: 48px !important;
        padding-left: 0 !important;
        color: #495057 !important;
    }
    
    .select2-selection__arrow {
        height: 48px !important;
    }
    
    .input-icon-container {
        display: flex;
        align-items: center;
        background-color: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        padding: 0 15px;
        height: 48px;
        transition: all 0.3s ease;
    }
    
    .input-icon-container:hover {
        border-color: #0a3b55;
        box-shadow: 0 0 0 2px rgba(10, 59, 85, 0.1);
    }
    
    .input-icon-container:focus-within {
        border-color: #0a3b55;
        box-shadow: 0 0 0 3px rgba(10, 59, 85, 0.2);
    }
    
    .input-icon-container img {
        width: 20px;
        margin-right: 12px;
        opacity: 0.7;
    }
    
    .form-control {
        height: 48px;
        border-radius: 6px;
        border: 1px solid #e0e0e0;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #0a3b55;
        box-shadow: 0 0 0 3px rgba(10, 59, 85, 0.2);
    }
    
    .location-swap-icon {
        background: #f8f9fa;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 32px auto 0;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 1px solid #e0e0e0;
    }
    
    .location-swap-icon:hover {
        background: #e9ecef;
        transform: rotate(180deg);
    }
    
    .location-swap-icon img {
        width: 20px;
        height: 20px;
    }
</style>

<div class="search-form-container">
    <form method="POST" action="{{ route('search.schedules') }}">
        @csrf
        <div class="row g-4 align-items-end">
            <!-- From Location -->
            <div class="col-lg-3 col-md-6">
                <label for="from_loc" class="form-label">From</label>
                <div class="input-icon-container">
                    <img src="{{ asset('images/location.png') }}" alt="From Icon">
                    <select id="from_loc" name="from_loc" class="form-select select2" required>
                        <option value="" disabled {{ old('from_loc', $from_loc ?? '') == '' ? 'selected' : '' }}>
                            Select starting point
                        </option>
                        @foreach($locations as $location)
                            <option value="{{ $location->name }}" {{ old('from_loc', $from_loc ?? '') == $location->name ? 'selected' : '' }}>
                                {{ $location->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Arrow Icon -->
            <div class="col-lg-1 col-md-2 d-none d-lg-block text-center">
                <div class="location-swap-icon" id="swapLocations">
                    <img src="{{ asset('images/arrow.png') }}" alt="Swap Locations">
                </div>
            </div>

            <!-- To Location -->
            <div class="col-lg-3 col-md-6">
                <label for="to_loc" class="form-label">To</label>
                <div class="input-icon-container">
                    <img src="{{ asset('images/location.png') }}" alt="To Icon">
                    <select id="to_loc" name="to_loc" class="form-select select2" required>
                        <option value="" disabled {{ old('to_loc', $to_loc ?? '') == '' ? 'selected' : '' }}>
                            Select destination
                        </option>
                        @foreach($locations as $location)
                            <option value="{{ $location->name }}" {{ old('to_loc', $to_loc ?? '') == $location->name ? 'selected' : '' }}>
                                {{ $location->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Date -->
            <div class="col-lg-2 col-md-6">
                <label for="dep_date" class="form-label">Departure Date</label>
                <input type="date" id="dep_date" name="dep_date" class="form-control"
                    value="{{ old('dep_date', $dep_date ?? date('Y-m-d')) }}" required>
            </div>

            <!-- Search Button -->
            <div class="col-lg-3 col-md-6 d-flex align-items-end">
                <button type="submit" class="btn w-100 custom-search-btn py-2">
                    <i class="bi bi-search me-2"></i> Search Buses
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Type or select a location",
            allowClear: true,
            dropdownParent: $('.search-form-container')
        });
        
        // Location swap functionality
        $('#swapLocations').click(function() {
            var fromLoc = $('#from_loc').val();
            var toLoc = $('#to_loc').val();
            
            $('#from_loc').val(toLoc).trigger('change');
            $('#to_loc').val(fromLoc).trigger('change');
        });
    });
</script>