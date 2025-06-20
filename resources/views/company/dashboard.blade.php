@push('styles')
<style>
    /* Dashboard Container */
    .dashboard-container {
        padding: 20px;
        background-color: #f8f9fa;
    }
    
    /* Card Styling */
    .stats-card {
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 20px;
        border: none;
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    }
    
    .card-warning {
        background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
        color: white;
    }
    
    .card-primary {
        background: linear-gradient(135deg, #2196F3 0%, #0d47a1 100%);
        color: white;
    }
    
    .card-info {
        background: linear-gradient(135deg, #00bcd4 0%, #00838f 100%);
        color: white;
    }
    
    .card-success {
        background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%);
        color: white;
    }
    
    .icon-big i {
        font-size: 3rem;
        opacity: 0.8;
    }
    
    .numbers h4 {
        font-weight: 600;
        font-size: 1.8rem;
    }
    
    .numbers p {
        font-size: 0.9rem;
        margin-bottom: 0.2rem;
        opacity: 0.9;
    }
    
    /* Chart Containers */
    /* Add this inside your existing <style> block */

.chart-container {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 400px; /* Fixed height for uniformity */
}

.chart-container canvas {
    flex-grow: 1;
}
#scheduleRouteChart {
    width: 100% !important;
    min-width: 500px; /* Makes it roughly double default width */
}


    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .numbers h4 {
            font-size: 1.5rem;
        }
        
        .icon-big i {
            font-size: 2.5rem;
        }
        
        .chart-container {
            min-height: 250px;
        }
    }
    
    @media (max-width: 576px) {
        .numbers h4 {
            font-size: 1.3rem;
        }
        
        .icon-big i {
            font-size: 2rem;
        }
    }
</style>
@endpush

@extends('company.layouts.master')

@section('content')
<div class="dashboard-container">
    <h4 class="page-title mb-4">Company Dashboard</h4>
    
    <!-- Stats Cards Row -->
    <div class="row">
        <!-- Vehicles Card -->
        <div class="col-md-6 col-lg-3">
            <div class="stats-card card card-warning">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="la la-bus"></i>
                            </div>
                        </div>
                        <div class="col-7 d-flex align-items-center">
                            <div class="numbers">
                                <p class="card-category">Vehicles</p>
                                <h4 class="card-title">{{ $vehicleCount }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Routes Card -->
        <div class="col-md-6 col-lg-3">
            <div class="stats-card card card-primary">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="la la-road"></i>
                            </div>
                        </div>
                        <div class="col-7 d-flex align-items-center">
                            <div class="numbers">
                                <p class="card-category">Routes</p>
                                <h4 class="card-title">{{ $routeCount }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Schedules Card -->
        <div class="col-md-6 col-lg-3">
            <div class="stats-card card card-info">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="la la-calendar"></i>
                            </div>
                        </div>
                        <div class="col-7 d-flex align-items-center">
                            <div class="numbers">
                                <p class="card-category">Upcoming Schedules</p>
                                <h4 class="card-title">{{ $scheduleCount }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bookings Card -->
        <div class="col-md-6 col-lg-3">
            <div class="stats-card card card-success">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="la la-ticket"></i>
                            </div>
                        </div>
                        <div class="col-7 d-flex align-items-center">
                            <div class="numbers">
                                <p class="card-category">Bookings</p>
                                <h4 class="card-title">{{ $bookingCount }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 1 -->
    <div class="row mt-4">
        <!-- Bookings Chart -->
        <div class="col-lg-6">
            <div class="chart-container">
                <h5 class="chart-title mb-3">Daily Bookings</h5>
                <canvas id="bookingsChart"></canvas>
            </div>
        </div>
        

    <!-- Charts Row 2 -->
    <div class="row mt-4">
        <!-- Schedule Route Chart -->
        <div class="col-12">
            <div class="chart-container">
                <h5 class="chart-title mb-3">Schedules by Route</h5>
                <canvas id="scheduleRouteChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    // Bookings per month (Line Chart)
    const bookingsChart = new Chart(document.getElementById('bookingsChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($bookingDates) !!},
            datasets: [{
                label: 'Bookings',
                data: {!! json_encode($bookingCounts) !!},
                borderColor: 'blue',
                backgroundColor: 'transparent',
                borderWidth: 2,
                tension: 0.4,
                fill: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });


    // Schedules per Route (Bar Chart)
    const scheduleRouteChart = new Chart(document.getElementById('scheduleRouteChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($routeNames) !!},
            datasets: [{
                label: 'Upcoming Schedules',
                data: {!! json_encode($scheduleCountsByRoute) !!},
                backgroundColor: 'rgba(142, 68, 173, 0.7)',
                borderColor: 'rgba(142, 68, 173, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

@endsection