<!-- resources/views/layouts/master.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>@yield('title', 'Dashboard')</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />

    <!-- CSS Links -->
    <link rel="stylesheet" href="{{ asset('template/css/bootstrap.min.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="{{ asset('template/css/ready.css') }}">
    <link rel="stylesheet" href="{{ asset('template/css/demo.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .container {
            margin: 0px 0px 0px 0px;
        }
    </style>


    @stack('styles')
</head>

<body>

    <div class="wrapper">
        <div class="main-header">
            <div class="logo-header">
                <a href="index.html" class="logo">
                    EZ Bus
                </a>
                <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse"
                    data-target="collapse" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <button class="topbar-toggler more"><i class="la la-ellipsis-v"></i></button>
            </div>
            @include('admin.layouts.partials.navbar')
        </div>
        @include('admin.layouts.partials.sidebar')
        <div class="main-panel">
            <div class="content">
                @yield('content')
            </div>
            @include('admin.layouts.partials.footer')
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('template/js/jquery.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('template/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('template/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('template/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('template/js/plugin/chartist/chartist.min.js') }}"></script>
    <script src="{{ asset('template/js/plugin/chartist/plugin/chartist-plugin-tooltip.min.js') }}"></script>
    <script src="{{ asset('template/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('template/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js') }}"></script>
    <script src="{{ asset('template/js/plugin/jquery-mapael/jquery.mapael.min.js') }}"></script>
    <script src="{{ asset('template/js/plugin/jquery-mapael/maps/world_countries.min.js') }}"></script>
    <script src="{{ asset('template/js/plugin/chart-circle/circles.min.js') }}"></script>
    <script src="{{ asset('template/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ asset('template/js/ready.min.js') }}"></script>
    <script src="{{ asset('template/js/bootstrap.bundle.min.js') }}"></script>

    <script>
        function alerts(title, message, type, icon) {
            $.notify({
                icon: icon,
                title: title,
                message: message,
            }, {
                type: type,
                placement: {
                    from: "bottom",
                    align: "right"
                },
                time: 1000,
            });
        }
    </script>

    @if (session('status'))
        <script>
            alerts("{{ session('status.title') }}", "{{ session('status.message') }}", "{{ session('status.type') }}",
                "{{ session('status.icon') }}");
        </script>
    @endif



    @stack('scripts')
</body>

</html>
