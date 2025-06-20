<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>EZ-Bus</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Vite Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        html, body {
        height: 100%;
        margin: 0;
        display: flex;
        flex-direction: column;
        }

        #app {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
        }
        .navbar {
            background-color: #ffffff !important;
            padding-top: 0.3rem;
            padding-bottom: 0.3rem;
            position: fixed;
            width: 100%;
            z-index: 10;
        }
        .navbar-brand img {
            height: 55px;
        }
        .nav-link {
            color: #0a3b55; !important;
        }
        .nav-link.active {
            color: #F6B407 !important;
            font-weight: bold;
        }
        .nav-link:hover {
            color: #F6B407 !important;
        }
        .dropdown-menu {
            background-color: #ffffff;
        }
        .dropdown-item {
            color: #070030;
        }
        .dropdown-item:hover {
            background-color: #ffffff;
            color: #F6B407
        }
        footer{
            position: relative;
            background-color: #2c2c2c;
            color: white;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    <img src="{{ asset('images/logoo.png') }}" alt="EZ-Bus">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
                                <i class="bi bi-search"></i> Search Bus
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('about') ? 'active' : '' }}" href="{{ url('/about') }}">
                                <i class="bi bi-info-circle"></i> About Us
                            </a>
                        </li>

                        @auth
                            @php
                                $userCompany = \App\Models\BusCompany::where('user_id', auth()->id())->first();
                            @endphp

                            {{-- @if(!$userCompany)
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('company/add') ? 'active' : '' }}" href="{{ route('company.add') }}">
                                        <i class="bi bi-plus-circle"></i> Add Company
                                    </a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <span class="nav-link text-warning">
                                        <i class="bi bi-clock-history"></i> Company under review
                                    </span>
                                </li>
                            @endif --}}

                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('my-tickets') ? 'active' : '' }}" href="{{ route('my.tickets') }}">
                                    <i class="bi bi-ticket-perforated"></i> My Tickets
                                </a>
                            </li>
                        @endauth
                    </ul>

                    <!-- Right Side -->
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('login') ? 'active' : '' }}" href="{{ route('login') }}">Login</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('register') ? 'active' : '' }}" href="{{ route('register') }}">Register</a>
                                </li>
                            @endif
                        @else
                            

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end">
                                    
                                       <a class="dropdown-item {{ request()->is('profile') ? 'active' : '' }}" href="{{ route('profile') }}">
    <i class="bi bi-person-circle"></i> My Profile
</a>

                                    
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="pt-5">
            @yield('content')
        </main>

    </div>

    <!-- Scripts -->
    @stack('scripts')
    <footer class="bg-dark text-light text-center text-lg-start mt-5 border-top">
        <div class="container p-4">
            <div class="row">
                <div class="col-md-6 text-start">
                    <h6 class="text-uppercase fw-bold">EZ-Bus</h6>
                    <p>Your Destination, Our Determination.</p>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('about')}}" class="text-decoration-none me-3 text-light">About Us</a>
                    <a href="#" class="text-decoration-none me-3 text-light">Terms</a>
                    <a href="#" class="text-decoration-none text-light">Privacy</a>
                </div>
            </div>
            <div class="text-center p-2">
                &copy; {{ date('Y') }} EZ-Bus. All rights reserved.
            </div>
        </div>
        
    </footer>
    
    
</body>
</html>
