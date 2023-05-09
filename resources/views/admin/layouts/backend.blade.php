<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <!-- Meta tags -->
    @yield('meta')

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Icons -->
    <link rel="shortcut icon" href="{{ asset('media/admin/favicons/favicon.png') }}">
    <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('media/admin/favicons/favicon-192x192.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('media/admin/favicons/apple-icon-180x180.png') }}">

    <!-- Fonts and Styles -->
    @yield('css_before')

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="{{ asset('js/plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" id="css-main" href="{{ asset('/css/oneui.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dropzone.min.css') }}">

    @yield('css_after')

    <!-- Scripts -->
    <script>
      window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};
    </script>
</head>

<body>
    <div id="page-container" class="sidebar-o enable-page-overlay sidebar-dark side-scroll page-header-fixed main-content-narrow remember-theme amigo-sidebar-dark">
        <!-- Page Loader -->
        <div id="page-loader" class="show"></div>
        <!-- END Page Loader -->

        @include('admin.layouts.nav')

        @include('admin.layouts.header')

        <!-- Main Container -->
        <main id="main-container">
            <!-- Hero -->
            @yield('head-container')
            <!-- END Hero -->

            <!-- Page Content -->
            <div class="content">
                @yield('content')
            </div><!-- END Page Content -->
        </main><!-- END Main Container -->

        <x-admin.dashboard.footer :version="$version" />

    </div><!-- END Page Container -->

    @include('admin.layouts.notifications')

    <!-- JS Plugins -->
    <script src="{{ asset('js/lib/jquery.min.js') }}"></script>
    <script src="{{ asset('js/plugins/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('js/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

    <!-- OneUI Core JS -->
    <script src="{{ asset('js/oneui.app.js') }}"></script>

    <!-- Laravel Scaffolding JS -->
    <script src="{{ asset('/js/acms.app.js') }}"></script>

    @yield('js_after')
</body>

</html>
