<!-- Side Header -->
<div class="content-header">
    <!-- Logo -->
    <a class="fw-semibold text-dual" href="javascript:void(0)">
        <span class="smini-visible">
            <!-- Project Favicon -->
            <img class="fa fa-circle-notch text-primary"
                 src="{{ asset('media/admin/favicons/favicon.png') }}"
                 alt="Project Name Favicon" width="16" height="16">
        </span>
        <span class="smini-hide fs-5 tracking-wider">{{ env('APP_NAME') }}</span>
    </a><!-- END Logo -->

    <!-- Extra -->
    <div>
        <!-- Dark Mode -->
        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
        <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="layout"
                data-action="dark_mode_toggle">
            <i class="far fa-moon"></i>
        </button><!-- END Dark Mode -->

        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
        <a class="d-lg-none btn btn-sm btn-alt-secondary ms-1" data-toggle="layout" data-action="sidebar_close"
           href="javascript:void(0)">
            <i class="fa fa-fw fa-times"></i>
        </a><!-- END Close Sidebar -->
    </div><!-- END Extra -->
</div><!-- END Side Header -->
