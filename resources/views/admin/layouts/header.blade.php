<!-- Header -->
<header id="page-header">
    <!-- Header Content -->
    <div class="content-header">

        <!-- Left Section -->
        <div class="d-flex align-items-center">
            <x-admin.dashboard.sidebar.toggler />
            <x-admin.dashboard.sidebar.toggler-mini />

            @yield('header-left-block-content')

        </div><!-- END Left Section -->

        <!-- Header Center Section -->
        <div class="d-flex align-items-center">

            @yield('header-center-block-content')

        </div><!-- END Header Center Section -->

        <!-- Right Section -->
        <div class="d-flex align-items-center">

            @yield('header-right-block-content')

            <x-admin.layouts.admin-dropdown />
        </div><!-- END Right Section -->
    </div><!-- END Header Content -->
</header><!-- END Header -->
