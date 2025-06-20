<div class="sidebar">
    <div class="scrollbar-inner sidebar-wrapper">
        <div class="user">
            {{-- <div class="photo">
                <img src="assets/img/profile.jpg">
            </div> --}}
            <div class="info">
                <a class="" data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                    <span>
                        {{ Auth::user()->name }}
                        <span class="user-level">Administrator</span>
                        <span class="caret"></span>
                    </span>
                </a>
                <div class="clearfix"></div>

                <div class="collapse in" id="collapseExample" aria-expanded="true" style="">
                    <ul class="nav">
                        <li>
                            <a href="{{ route('admin.profile') }}">
                            {{-- <a href="#"> --}}

                                <span class="link-collapse">My Profile</span>
                            </a>
                        </li>
                        {{-- <li>
                            <a href="#edit">
                                <span class="link-collapse">Edit Profile</span>
                            </a>
                        </li>
                        <li>
                            <a href="#settings">
                                <span class="link-collapse">Settings</span>
                            </a>
                        </li> --}}
                    </ul>
                </div>
            </div>
        </div>
        <ul class="nav">
            <li class="nav-item {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" >
                    <i class="la la-dashboard"></i>
                    <p>Dashboard</p>
                    {{-- <span class="badge badge-count">5</span> --}}
                </a>
            </li>

            <li class="nav-item {{ request()->is('admin/location') ? 'active' : '' }}">
                <a href="{{ route('admin.location') }}">
                    <i class="la la-map-marker"></i>
                    <p>Locations</p>
                    {{-- <span class="badge badge-count">{{ $locationCount ?? 0 }}</span> <!-- Dynamic location count with null check --> --}}
                </a>
            </li>
            
            

            <li class="nav-item  {{ request()->is('admin/route') ? 'active' : '' }}">
                <a href="{{ route('admin.route') }}">
                    <i class="la la-map"></i>
                    <p>Routes</p>
                    {{-- <span class="badge badge-count">50</span> --}}
                </a>
            </li>

            <li class="nav-item {{ request()->is('admin/bus-company*') ? 'active' : '' }}">
                <a href="{{ route('admin.bus_company') }}">
                    <i class="la la-bus"></i>
                    <p>Bus Companies</p>
                    {{-- <span class="badge badge-count">6</span> --}}
                </a>
            </li>

            <li class="nav-item {{ request()->is('admin/vehicle-types*') ? 'active' : '' }}">
                <a href="{{ route('admin.vehicle_type.index') }}">
                    <i class="la la-bus"></i>
                    <p>Vehicle Types</p>
                    {{-- <span class="badge badge-count">6</span> --}}
                </a>
            </li>

            <li class="nav-item {{ request()->is('admin/vehicle-classes*') ? 'active' : '' }}">
                <a href="{{ route('admin.vehicle_class') }}">
                    <i class="la la-bus"></i>
                    <p>Vehicle Classes</p>
                    {{-- <span class="badge badge-count">7</span> --}}
                </a>
            </li>

            <li class="nav-item {{ request()->is('admin/fare*') ? 'active' : '' }}">
                <a href="{{ route('admin.fare.index') }}">
                    <i class="la la-money"></i>
                    <p>Manage Fare</p>
                    {{-- <span class="badge badge-count">7</span> --}}
                </a>
            </li>

            <li class="nav-item {{ request()->is('admin/seat_formats*') ? 'active' : '' }}">
                <a href="{{ route('admin.seat_formats.index') }}">
                    <i class="fas fa-chair"></i>

                    <p>Seat Formats</p>
                </a>
            </li>


        </ul>
    </div>
</div>
