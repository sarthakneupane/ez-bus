<div class="sidebar">
    <div class="scrollbar-inner sidebar-wrapper">
        <div class="user">
            {{-- </span>
                    <span>{{ Auth::user()->busCompany->bc_name ?? 'No Bus Company' }}</span> --}}
                    
            <div class="info">
                <a class="" data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                    
                    <span>
                        <span>{{ Auth::user()->name }}</span>
                        <span class="user-level">{{ Auth::user()->busCompany->bc_name ?? 'No Bus Company' }}</span>
                        <span class="caret"></span>
                    </span>
                </a>
                <div class="clearfix"></div>

                <div class="collapse in" id="collapseExample" aria-expanded="true">
                    <ul class="nav">
                        <li><a href="{{ route('company.profile') }}"><span class="link-collapse">My Profile</span></a></li>
                        {{-- <li><a href="#edit"><span class="link-collapse">Edit Profile</span></a></li>
                        <li><a href="#settings"><span class="link-collapse">Settings</span></a></li> --}}
                    </ul>
                </div>
            </div>
        </div>
        <ul class="nav">
            <li class="nav-item {{ Route::is('company.dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('company.dashboard') }}">
                    <i class="la la-dashboard"></i>
                    <p>Dashboard</p>
                    {{-- <span class="badge badge-count">5</span> --}}
                </a>
            </li>

            <li class="nav-item {{ Route::is('company.vehicles') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('company.vehicles') }}">
                    <i class="la la-bus"></i>
                    <p>Vehicles</p>
                    {{-- <span class="badge badge-count">10</span>  --}}
                </a>
            </li>

            <li class="nav-item {{ Route::is('company.routes') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('company.routes.index') }}">
                    <i class="la la-map"></i>
                    <p>Routes</p>
                </a>
            </li>

            <li class="nav-item {{ Route::is('company.schedules') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('company.schedules') }}">
                    <i class="la la-calendar"></i>
                    <p>Schedules</p>
                </a>
            </li>
            <li class="nav-item {{ Route::is('company.reviews.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('company.reviews.index') }}">
                    <i class="las la-star"></i> Customer Reviews
                </a>
            </li>
            
            
        </ul>
    </div>
</div>
