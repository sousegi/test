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
    <link rel="stylesheet" id="css-main" href="{{ asset('/css/oneui.css') }}">

    @yield('css_after')

    <!-- Scripts -->
    <script>
      window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};
    </script>
</head>

<body>
    <div id="page-container">
        <!-- Main Container -->
        <main id="main-container">

            <!-- Page Content -->
            <div class="bg-image" style="background-image: url('{{ asset('media/admin/main-bg.jpg') }}');">
                <div class="row g-0 bg-primary-dark-op">

                    <x-admin.auth.info-section />

                    <!-- Main Section -->
                    <div class="hero-static col-lg-8 d-flex flex-column align-items-center bg-body-light">
                        <div class="p-3 w-100 d-lg-none text-center">
                            <p class="link-fx fw-semibold fs-2 text-dark">
                                Amigo
                                <span class="fw-normal">CMS</span>
                            </p>
                        </div>

                        <!-- Content -->
                        <div class="p-4 w-100 flex-grow-1 d-flex align-items-center">
                            <div class="w-100">

                                @yield('content')

                            </div>
                        </div><!-- END Content -->

                        <x-admin.auth.version :version="$version" />

                    </div><!-- END Main Section -->
                </div>
            </div><!-- END Page Content -->
        </main><!-- END Main Container -->

    </div><!-- END Page Container -->

    <!-- OneUI Core JS -->
    <script src="{{ asset('js/oneui.app.js') }}"></script>

    @yield('js_after')
</body>

</html>
