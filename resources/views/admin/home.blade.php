@extends('admin.layouts.master')

@section('title', 'Home Page')

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
    
    .card-danger {
        background: linear-gradient(135deg, #f44336 0%, #c62828 100%);
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
    .chart-container {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 400px;
    }
    
    .chart-container canvas {
        flex-grow: 1;
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

@section('content')
<div class="dashboard-container">
    <h4 class="page-title mb-4">Admin Dashboard</h4>
    
    <!-- Stats Cards Row -->
    <div class="row">
        <!-- Users Card -->
        <div class="col-md-6 col-lg-3">
            <div class="stats-card card card-warning">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="la la-users"></i>
                            </div>
                        </div>
                        <div class="col-7 d-flex align-items-center">
                            <div class="numbers">
                                <p class="card-category">Users</p>
                                <h4 class="card-title">{{ $usersCount }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bus Companies Card -->
        <div class="col-md-6 col-lg-3">
            <div class="stats-card card card-success">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="la la-bus"></i>
                            </div>
                        </div>
                        <div class="col-7 d-flex align-items-center">
                            <div class="numbers">
                                <p class="card-category">Bus Companies</p>
                                <h4 class="card-title">{{ $busCompaniesCount }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Locations Card -->
        <div class="col-md-6 col-lg-3">
            <div class="stats-card card card-danger">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="la la-map-marker"></i>
                            </div>
                        </div>
                        <div class="col-7 d-flex align-items-center">
                            <div class="numbers">
                                <p class="card-category">Locations</p>
                                <h4 class="card-title">{{ $locationsCount }}</h4>
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
                                <i class="la la-angle-double-right"></i>
                            </div>
                        </div>
                        <div class="col-7 d-flex align-items-center">
                            <div class="numbers">
                                <p class="card-category">Routes</p>
                                <h4 class="card-title">{{ $routesCount }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mt-4">
        <!-- Bookings Per Day Chart -->
        <div class="col-lg-6">
            <div class="chart-container">
                <h5 class="chart-title mb-3">Bookings Per Day (Last 7 Days)</h5>
                <canvas id="bookingsPerDayChart"></canvas>
            </div>
        </div>

        <!-- Top Rated Bus Companies Chart -->
        <div class="col-lg-6">
            <div class="chart-container">
                <h5 class="chart-title mb-3">Top Rated Bus Companies</h5>
                <canvas id="topCompaniesChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    // Bookings Per Day Chart
   // Bookings Per Day Chart
const bookingsCtx = document.getElementById('bookingsPerDayChart').getContext('2d');
new Chart(bookingsCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($bookingsPerDay->pluck('date')) !!},
        datasets: [{
            label: 'Bookings',
            data: {!! json_encode($bookingsPerDay->pluck('count')) !!},
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 2,
            fill: false,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        },
        plugins: {
            legend: {
                position: 'top',
            }
        }
    }
});


    // Top Companies Chart
    const topCompaniesCtx = document.getElementById('topCompaniesChart').getContext('2d');
    new Chart(topCompaniesCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($topCompanies->pluck('company_name')) !!},
            datasets: [{
                label: 'Average Rating',
                data: {!! json_encode($topCompanies->pluck('average_rating')) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 5
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
@endsection