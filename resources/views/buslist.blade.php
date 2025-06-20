@push('styles')
<style>
    :root {
        --primary-gold: #f6b407;
        --primary-dark: #062a40;
        --gold-light: #f8c547;
        --dark-light: #0a3a52;
    }

    .bus-card {
        min-height: 180px;
        transition: box-shadow 0.3s ease;
    }
    .bus-card:hover {
        box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
    }

    .filter-section {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--dark-light) 100%);
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 8px 25px rgba(6, 42, 64, 0.2);
    }

    .filter-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 10px;
        padding: 20px;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, var(--primary-gold) 0%, var(--gold-light) 100%);
        border: none;
        color: var(--primary-dark);
        font-weight: 600;
        padding: 10px 25px;
        border-radius: 25px;
        transition: all 0.3s ease;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(246, 180, 7, 0.4);
        color: var(--primary-dark);
    }

    .btn-outline-custom {
        border: 2px solid var(--primary-gold);
        color: var(--primary-gold);
        background: transparent;
        font-weight: 600;
        padding: 8px 20px;
        border-radius: 20px;
        transition: all 0.3s ease;
    }

    .btn-outline-custom:hover {
        background: var(--primary-gold);
        color: var(--primary-dark);
        transform: translateY(-2px);
    }

    .page-header {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--dark-light) 100%);
        color: white;
        padding: 40px 0;
        margin-bottom: 0;
        border-radius: 0 0 25px 25px;
    }

    .main-content {
        margin-top: 30px;
    }

    .form-control:focus {
        border-color: var(--primary-gold);
        box-shadow: 0 0 0 0.2rem rgba(246, 180, 7, 0.25);
    }

    .form-select:focus {
        border-color: var(--primary-gold);
        box-shadow: 0 0 0 0.2rem rgba(246, 180, 7, 0.25);
    }

    .filter-toggle {
        background: var(--primary-gold);
        color: var(--primary-dark);
        border: none;
        padding: 10px 20px;
        border-radius: 25px;
        font-weight: 600;
        margin-bottom: 20px;
    }

    .filter-label {
        color: var(--primary-gold) !important;
        font-weight: 600 !important;
        text-shadow: 0 1px 2px rgba(0,0,0,0.3);
    }

    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
        border-radius: 15px;
    }

    .results-container {
        position: relative;
        min-height: 200px;
    }

    .no-results {
        text-align: center;
        padding: 60px 20px;
        color: #6c757d;
    }

    .no-results i {
        font-size: 4rem;
        color: var(--primary-gold);
        margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .filter-section {
            padding: 15px;
        }
        
        .bus-card {
            margin-bottom: 20px;
        }
    }
</style>
@endpush

@extends('layouts.app')

@section('content')

<!-- Page Header -->
<div class="page-header">
    <div class="container">
        <div class="text-center">
            <h1 class="display-4 fw-bold mb-2" style="margin-top: 50px;">Available Buses</h1>
            <p class="lead mb-0">Find and book your perfect journey</p>
        </div>
    </div>
</div>

<div class="container main-content">
    @if(session('error'))
        <div class="alert alert-danger text-center rounded-3 border-0 shadow-sm">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
        </div>
    @endif

    <!-- Filters Section -->
    <div class="filter-section">
        <button class="btn filter-toggle d-md-none w-100" type="button" data-bs-toggle="collapse" data-bs-target="#filtersCollapse">
            <i class="fas fa-filter me-2"></i>Filters & Sort
        </button>
        
        <div class="collapse d-md-block" id="filtersCollapse">
            <div class="filter-card">
                <form id="filterForm">
                    @csrf
                    <!-- Preserve existing search parameters -->
                    <input type="hidden" name="from_location" value="{{ request('from_location') }}">
                    <input type="hidden" name="to_location" value="{{ request('to_location') }}">
                    <input type="hidden" name="departure_date" value="{{ request('departure_date') }}">

                    <div class="row g-3">
                        <!-- Sort By -->
                        <div class="col-md-3">
                            <label class="form-label filter-label">
                                <i class="fas fa-sort me-2"></i>Sort By
                            </label>
                            <select name="sort_by" class="form-select filter-input">
                                <option value="departure_time">Departure Time</option>
                                <option value="fare_low">Price: Low to High</option>
                                <option value="fare_high">Price: High to Low</option>
                                <option value="rating">Rating</option>
                                <option value="available_seats">Available Seats</option>
                            </select>
                        </div>

                        <!-- Price Range -->
                        <div class="col-md-3">
                            <label class="form-label filter-label">
                                <i class="fas fa-money-bill me-2"></i>Max Price
                            </label>
                            <input type="number" name="max_price" class="form-control filter-input" placeholder="Enter max price">
                        </div>

                        <!-- Departure Time -->
                        <div class="col-md-3">
                            <label class="form-label filter-label">
                                <i class="fas fa-clock me-2"></i>Departure Time
                            </label>
                            <select name="departure_time" class="form-select filter-input">
                                <option value="">Any Time</option>
                                <option value="morning">Morning (6AM - 12PM)</option>
                                <option value="afternoon">Afternoon (12PM - 6PM)</option>
                                <option value="evening">Evening (6PM - 12AM)</option>
                                <option value="night">Night (12AM - 6AM)</option>
                            </select>
                        </div>

                        <!-- Bus Company -->
                        <div class="col-md-3">
                            <label class="form-label filter-label">
                                <i class="fas fa-bus me-2"></i>Bus Company
                            </label>
                            <select name="bus_company" class="form-select filter-input">
                                <option value="">All Companies</option>
                                @foreach($schedules->pluck('vehicleHasRoute.vehicle.busCompany.bc_name')->unique()->filter() as $company)
                                    <option value="{{ $company }}">{{ $company }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <button type="button" id="clearFilters" class="btn btn-outline-light">
                                <i class="fas fa-undo me-2"></i>Clear Filters
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Results Container -->
    <div class="results-container">
        <!-- Results Count -->
        <div class="d-flex justify-content-between align-items-center mb-4" id="resultsCount">
            <h5 class="mb-0" style="color: var(--primary-dark);">
                <i class="fas fa-list me-2"></i><span id="busCount">{{ $schedules->count() }}</span> buses found
            </h5>
        </div>

        <!-- Bus Cards Container -->
        <div id="busResults">
            @if($schedules->isEmpty())
                <div class="no-results">
                    <i class="fas fa-bus"></i>
                    <h3 class="text-muted mb-3">No buses available</h3>
                    <p class="text-muted">No buses found for the selected route and date. Try adjusting your filters.</p>
                </div>
            @else
                <div class="row mt-3 g-3">
                    @foreach($schedules as $schedule)
                        @php $vhr = $schedule->vehicleHasRoute; @endphp
                        <div class="col-md-6 col-lg-4">
                            <div class="border rounded p-3 shadow-sm position-relative h-100 d-flex flex-column justify-content-between bus-card">
                                <!-- Top Row: Logo & Fare -->
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="d-flex align-items-center gap-2">
                                        @if($vhr->vehicle->image)
                                            <a href="{{ asset('storage/' . $vhr->vehicle->image) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $vhr->vehicle->image) }}" alt="Vehicle Image" class="img-thumbnail" style="max-width: 100px;">
                                            </a>
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                        
                                        <div>
                                            {{-- Star Rating --}}
                                            <div class="mb-1">
                                                @if ($schedule->average_stars > 0)
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $schedule->average_stars)
                                                            <i class="fas fa-star text-warning"></i>
                                                        @else
                                                            <i class="far fa-star text-secondary"></i>
                                                        @endif
                                                    @endfor
                                                    
                                                @else
                                                    <span class="text-muted small">Not Rated</span>
                                                @endif
                                            </div>
                                            
                                            {{-- Company Name --}}
                                            <strong>{{ optional($vhr->vehicle->busCompany)->bc_name ?? 'N/A' }}</strong><br>
                                            <small>{{ optional($vhr->vehicle)->vehicle_no ?? 'N/A' }}</small>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <span class="fw-bold text-success">₨ {{ number_format($schedule->computed_fare, 2) }}</span>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-start">
                                <!-- Amenities -->
                                <div class="mt-2 small text-warning">
                                    {{ $vhr->vehicle->amenities ?? 'N/A' }}
                                </div>
                                <!-- Just below time or fare info -->
                                <div class="mt-1 small text-muted">
                                    Available Seats: 
                                    <strong>
                                        {{ $schedule->available_seats }} / {{ $schedule->total_seats }}
                                    </strong>
                                </div>
                                </div>

                                <!-- Time Info -->
                                <div class="mt-2">
                                    @php
                                        $departure = \Carbon\Carbon::parse($schedule->departure_date_time);
                                        $arrival = \Carbon\Carbon::parse($schedule->arrival_date_time);
                                        $duration = $departure->diff($arrival);
                                    @endphp
                                
                                    {{ $departure->format('h:i A') }} - {{ $arrival->format('h:i A') }}
                                    ({{ $duration->h }}h {{ $duration->i }}m)
                                </div>

                                <!-- Route Info -->
                                <div class="mt-3 d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ optional($vhr->route->fromLocation)->name ?? 'N/A' }}</strong>
                                        →
                                        <strong>{{ optional($vhr->route->toLocation)->name ?? 'N/A' }}</strong>
                                    </div>
                                    @auth
                                        <a href="#"
                                            class="btn btn-sm btn-outline-primary open-seat-modal"
                                            data-schedule-id="{{ $schedule->id }}"
                                            data-fare="{{ $schedule->computed_fare }}"
                                            data-company="{{ optional($vhr->vehicle->busCompany)->bc_name ?? 'N/A' }}"
                                            data-vehicle="{{ optional($vhr->vehicle)->vehicle_no ?? 'N/A' }}"
                                            data-route="{{ optional($vhr->route->fromLocation)->name ?? '' }} - {{ optional($vhr->route->toLocation)->name ?? '' }}"
                                            data-time="{{ \Carbon\Carbon::parse($schedule->departure_date_time)->format('h:i A') }}">
                                            View Seats
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary">
                                            Login to View Seats
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Back Button -->
    <div class="text-center mt-5 mb-4">
        <a href="{{ route('welcome') }}" class="btn btn-outline-custom btn-lg">
            <i class="fas fa-arrow-left me-2"></i>Search Again
        </a>
    </div>
</div>

<!-- Enhanced Seat Layout Modal -->
<div class="modal fade" id="seatModal" tabindex="-1" aria-labelledby="seatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header" style="background: linear-gradient(135deg, var(--primary-dark) 0%, var(--dark-light) 100%); border-radius: 20px 20px 0 0;">
                <h5 class="modal-title text-black fw-bold" >
                    <i class="fas fa-chair me-2"></i>Select Your Seat
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="seatLayoutContainer">
                <div class="text-center">
                    <div class="spinner-border" style="color: var(--primary-gold);" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Loading seat layout...</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let filterTimeout;
    const filterForm = document.getElementById('filterForm');
    const filterInputs = document.querySelectorAll('.filter-input');
    const busResults = document.getElementById('busResults');
    const busCount = document.getElementById('busCount');
    const clearFiltersBtn = document.getElementById('clearFilters');

    // Function to show loading state
    function showLoading() {
        if (!document.querySelector('.loading-overlay')) {
            const loadingOverlay = document.createElement('div');
            loadingOverlay.className = 'loading-overlay';
            loadingOverlay.innerHTML = `
                <div class="text-center">
                    <div class="spinner-border" style="color: var(--primary-gold);" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Filtering buses...</p>
                </div>
            `;
            document.querySelector('.results-container').appendChild(loadingOverlay);
        }
    }

    // Function to hide loading state
    function hideLoading() {
        const loadingOverlay = document.querySelector('.loading-overlay');
        if (loadingOverlay) {
            loadingOverlay.remove();
        }
    }

    // Function to apply filters via AJAX
    function applyFilters() {
        showLoading();

        const formData = new FormData(filterForm);
        
        // Get current schedules data for filtering
        const currentSchedules = @json($schedules);
        
        // Apply client-side filtering
        let filteredSchedules = [...currentSchedules];

        // Sort filtering
        const sortBy = formData.get('sort_by');
        if (sortBy) {
            filteredSchedules.sort((a, b) => {
                switch (sortBy) {
                    case 'fare_low':
                        return a.computed_fare - b.computed_fare;
                    case 'fare_high':
                        return b.computed_fare - a.computed_fare;
                    case 'rating':
                        return (b.average_stars || 0) - (a.average_stars || 0);
                    case 'available_seats':
                        return b.available_seats - a.available_seats;
                    case 'departure_time':
                    default:
                        return new Date(a.departure_date_time) - new Date(b.departure_date_time);
                }
            });
        }

        // Price filtering
        const maxPrice = formData.get('max_price');
        if (maxPrice) {
            filteredSchedules = filteredSchedules.filter(schedule => 
                schedule.computed_fare <= parseFloat(maxPrice)
            );
        }

        // Departure time filtering
        const departureTime = formData.get('departure_time');
        if (departureTime) {
            filteredSchedules = filteredSchedules.filter(schedule => {
                const hour = new Date(schedule.departure_date_time).getHours();
                switch (departureTime) {
                    case 'morning':
                        return hour >= 6 && hour < 12;
                    case 'afternoon':
                        return hour >= 12 && hour < 18;
                    case 'evening':
                        return hour >= 18 && hour < 24;
                    case 'night':
                        return hour >= 0 && hour < 6;
                    default:
                        return true;
                }
            });
        }

        // Bus company filtering
        const busCompany = formData.get('bus_company');
        if (busCompany) {
            filteredSchedules = filteredSchedules.filter(schedule => 
                schedule.vehicle_has_route?.vehicle?.bus_company?.bc_name === busCompany
            );
        }

        // Generate HTML for filtered results
        setTimeout(() => {
            const html = generateBusCardsHTML(filteredSchedules);
            busResults.innerHTML = html;
            busCount.textContent = filteredSchedules.length;
            
            // Re-attach event listeners for new bus cards
            attachSeatModalListeners();
            hideLoading();
        }, 300);
    }

    // Function to generate bus cards HTML
    function generateBusCardsHTML(schedules) {
        if (schedules.length === 0) {
            return `
                <div class="no-results">
                    <i class="fas fa-bus"></i>
                    <h3 class="text-muted mb-3">No buses available</h3>
                    <p class="text-muted">No buses found matching your criteria. Try adjusting your filters.</p>
                </div>
            `;
        }

        let html = '<div class="row mt-3 g-3">';
        
        schedules.forEach(schedule => {
            const vhr = schedule.vehicle_has_route;
            const departure = new Date(schedule.departure_date_time);
            const arrival = new Date(schedule.arrival_date_time);
            const duration = Math.abs(arrival - departure);
            const hours = Math.floor(duration / (1000 * 60 * 60));
            const minutes = Math.floor((duration % (1000 * 60 * 60)) / (1000 * 60));

            // Generate star rating
            let starRating = '';
            if (schedule.average_stars > 0) {
                for (let i = 1; i <= 5; i++) {
                    if (i <= schedule.average_stars) {
                        starRating += '<i class="fas fa-star text-warning"></i>';
                    } else {
                        starRating += '<i class="far fa-star text-secondary"></i>';
                    }
                }
            } else {
                starRating = '<span class="text-muted small">Not Rated</span>';
            }

            html += `
                <div class="col-md-6 col-lg-4">
                    <div class="border rounded p-3 shadow-sm position-relative h-100 d-flex flex-column justify-content-between bus-card">
                        <!-- Top Row: Logo & Fare -->
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="d-flex align-items-center gap-2">
                                ${vhr?.vehicle?.image ? 
                                    `<a href="/storage/${vhr.vehicle.image}" target="_blank">
                                        <img src="/storage/${vhr.vehicle.image}" alt="Vehicle Image" class="img-thumbnail" style="max-width: 100px;">
                                    </a>` : 
                                    '<span class="text-muted">No Image</span>'
                                }
                                
                                <div>
                                    <div class="mb-1">
                                        ${starRating}
                                    </div>
                                    
                                    <strong>${vhr?.vehicle?.bus_company?.bc_name || 'N/A'}</strong><br>
                                    <small>${vhr?.vehicle?.vehicle_no || 'N/A'}</small>
                                </div>
                            </div>
                            <div class="text-end">
                                <span class="fw-bold text-success">₨ ${parseFloat(schedule.computed_fare).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-start">
                            <div class="mt-2 small text-warning">
                                ${vhr?.vehicle?.amenities || 'N/A'}
                            </div>
                            <div class="mt-1 small text-muted">
                                Available Seats: 
                                <strong>
                                    ${schedule.available_seats} / ${schedule.total_seats}
                                </strong>
                            </div>
                        </div>

                        <!-- Time Info -->
                        <div class="mt-2">
                            ${departure.toLocaleTimeString('en-US', {hour: 'numeric', minute: '2-digit', hour12: true})} - ${arrival.toLocaleTimeString('en-US', {hour: 'numeric', minute: '2-digit', hour12: true})}
                            (${hours}h ${minutes}m)
                        </div>

                        <!-- Route Info -->
                        <div class="mt-3 d-flex justify-content-between align-items-center">
                            <div>
                                <strong>${vhr?.route?.from_location?.name || 'N/A'}</strong>
                                →
                                <strong>${vhr?.route?.to_location?.name || 'N/A'}</strong>
                            </div>
                            @auth
                                <a href="#"
                                    class="btn btn-sm btn-outline-primary open-seat-modal"
                                    data-schedule-id="${schedule.id}"
                                    data-fare="${schedule.computed_fare}"
                                    data-company="${vhr?.vehicle?.bus_company?.bc_name || 'N/A'}"
                                    data-vehicle="${vhr?.vehicle?.vehicle_no || 'N/A'}"
                                    data-route="${(vhr?.route?.from_location?.name || '') + ' - ' + (vhr?.route?.to_location?.name || '')}"
                                    data-time="${departure.toLocaleTimeString('en-US', {hour: 'numeric', minute: '2-digit', hour12: true})}">
                                    View Seats
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary">
                                    Login to View Seats
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            `;
        });

        html += '</div>';
        return html;
    }

    // Add event listeners to filter inputs
    filterInputs.forEach(input => {
        input.addEventListener('change', function() {
            clearTimeout(filterTimeout);
            filterTimeout = setTimeout(applyFilters, 300);
        });

        // For text inputs, also listen to keyup events
        if (input.type === 'text' || input.type === 'number') {
            input.addEventListener('keyup', function() {
                clearTimeout(filterTimeout);
                filterTimeout = setTimeout(applyFilters, 500);
            });
        }
    });

    // Clear filters functionality
    clearFiltersBtn.addEventListener('click', function() {
        filterInputs.forEach(input => {
            if (input.type === 'select-one') {
                input.selectedIndex = 0;
            } else {
                input.value = '';
            }
        });
        applyFilters();
    });

    // Function to attach seat modal listeners
    function attachSeatModalListeners() {
        document.querySelectorAll('.open-seat-modal').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();

                const scheduleId = this.dataset.scheduleId;
                const fare = parseFloat(this.dataset.fare);
                const company = this.dataset.company;
                const vehicle = this.dataset.vehicle;
                const route = this.dataset.route;
                const time = this.dataset.time;

                const modalElement = document.getElementById('seatModal');
                const modal = new bootstrap.Modal(modalElement);
                modal.show();

                const container = document.getElementById('seatLayoutContainer');
                container.innerHTML = `
                    <div class="text-center">
                        <div class="spinner-border" style="color: var(--primary-gold);" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Loading seat layout...</p>
                    </div>
                `;

                // Update modal title with bus details
                const modalTitle = modalElement.querySelector('.modal-title');
                modalTitle.innerHTML = `
                    <div>
                        <i class="fas fa-chair me-2"></i>Select Your Seat
                        <div class="small fw-normal mt-1 opacity-75">
                            ${company} (${vehicle}) | ${route} | ${time}
                        </div>
                    </div>
                `;

                // Fetch available seats
                fetch(`/api/seats/${scheduleId}`)
                    .then(res => res.text())
                    .then(html => {
                        container.innerHTML = html;

                        const selectedSeatsDisplay = container.querySelector('#selectedSeatsList');
                        const totalFareDisplay = container.querySelector('#totalFare');
                        const bookingForm = container.querySelector('#bookingForm');
                        const bookingSeatsInput = container.querySelector('#bookingSeats');
                        const bookingScheduleId = container.querySelector('#bookingScheduleId');
                        const bookingFareInput = container.querySelector('#bookingFare');
                        const bookingTotalInput = container.querySelector('#bookingTotal');
                        const bookingNoOfSeats = container.querySelector('#bookingNoOfSeats');

                        function updateSelectedSeatsDisplay() {
                            const selectedSeats = Array.from(container.querySelectorAll('td.seat.selected'))
                                .map(seat => seat.dataset.seat);

                            selectedSeatsDisplay.textContent = selectedSeats.length > 0
                                ? selectedSeats.join(', ')
                                : 'None';

                            const totalFare = selectedSeats.length * fare;
                            totalFareDisplay.textContent = totalFare.toFixed(2);

                            if (bookingSeatsInput) {
                                bookingSeatsInput.value = selectedSeats.join(',');
                            }

                            if (bookingScheduleId) {
                                bookingScheduleId.value = scheduleId;
                            }

                            if (bookingFareInput) {
                                bookingFareInput.value = fare;
                            }

                            if (bookingTotalInput) {
                                bookingTotalInput.value = totalFare;
                            }

                            if (bookingNoOfSeats) {
                                bookingNoOfSeats.value = selectedSeats.length;
                            }
                        }

                        // Add click event on each seat for selection
                        container.querySelectorAll('td.seat').forEach(seat => {
                            seat.addEventListener('click', function () {
                                if (this.classList.contains('booked')) return;

                                this.classList.toggle('selected');
                                this.classList.toggle('available');
                                updateSelectedSeatsDisplay();
                            });
                        });

                        // Handle form submission
                        if (bookingForm) {
                            bookingForm.addEventListener('submit', function(e) {
                                e.preventDefault();
                                
                                const selectedSeats = Array.from(container.querySelectorAll('td.seat.selected'))
                                    .map(seat => seat.dataset.seat);
                                    
                                if (selectedSeats.length === 0) {
                                    alert('Please select at least one seat');
                                    return;
                                }
                                
                                // Disable the submit button to prevent multiple submissions
                                const submitButton = bookingForm.querySelector('button[type="submit"]');
                                submitButton.disabled = true;
                                submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';

                                // Submit the form via AJAX
                                fetch(bookingForm.action, {
                                    method: 'POST',
                                    body: new FormData(bookingForm),
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                        'Accept': 'application/json'
                                    }
                                })
                                .then(response => {
                                    if (response.redirected) {
                                        window.location.href = response.url;
                                    } else {
                                        return response.json();
                                    }
                                })
                                .then(data => {
                                    if (data && data.success) {
                                        window.location.href = "{{ route('booking.success') }}";
                                    } else if (data && data.error) {
                                        alert(data.error);
                                        submitButton.disabled = false;
                                        submitButton.textContent = 'Confirm Booking';
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    alert('An error occurred. Please try again.');
                                    submitButton.disabled = false;
                                    submitButton.textContent = 'Confirm Booking';
                                });
                            });
                        }

                        updateSelectedSeatsDisplay();
                    })
                    .catch(error => {
                        console.error('Error loading seats:', error);
                        container.innerHTML = '<div class="alert alert-danger">Error loading seat layout. Please try again.</div>';
                    });
            });
        });
    }

    // Initial attachment of seat modal listeners
    attachSeatModalListeners();
});
</script>
@endpush
