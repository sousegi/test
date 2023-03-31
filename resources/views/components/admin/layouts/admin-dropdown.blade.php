<!-- User Dropdown -->
<div class="dropdown d-inline-block ms-2">
    <button type="button" class="btn btn-sm btn-alt-secondary d-flex align-items-center" id="page-header-user-dropdown" data-bs-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
        <img class="rounded-circle" src="{{ asset('media/admin/avatar.jpg') }}" alt="Header Avatar" style="width: 21px;">
        <span class="d-none d-sm-inline-block ms-2">{{ $adminName }}</span>
        <i class="fa fa-fw fa-angle-down d-none d-sm-inline-block opacity-50 ms-1 mt-1"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-md dropdown-menu-end p-0 border-0" aria-labelledby="page-header-user-dropdown">
        <div class="p-3 text-center bg-body-light border-bottom rounded-top">
            <img class="img-avatar img-avatar48 img-avatar-thumb" src="{{ asset('media/admin/avatar.jpg') }}" alt="">
            <p class="mt-2 mb-0 fw-medium">{{ $adminName }}</p>
            <p class="mb-0 text-muted fs-sm fw-medium">{{ $adminEmail }}</p>
        </div>
        <div class="p-2">
            <h5 class="dropdown-header text-uppercase">Site Options</h5>
            <a class="dropdown-item d-flex align-items-center justify-content-between" href="{{ config('app.url') }}">
                <span class="fs-sm fw-medium">Visit site</span>
                <i class="fa fa-globe ml-1"></i>
            </a>
            <a class="dropdown-item d-flex align-items-center justify-content-between" href={{ route('admin.cache') }}>
                <span class="fs-sm fw-medium">Clear cache</span>
                <i class="far fa-trash-can ml-1"></i>
            </a>
        </div>
        <div role="separator" class="dropdown-divider m-0"></div>
        <div class="p-2">
            <h5 class="dropdown-header text-uppercase">Account Options</h5>
{{--            TODO: Make Profile page --}}
{{--            <a class="dropdown-item d-flex align-items-center justify-content-between" href="/profile-edit">--}}
{{--                <span class="fs-sm fw-medium">Profile</span>--}}
{{--                <i class="far fa-user ml-1"></i>--}}
{{--            </a>--}}
            <a class="dropdown-item d-flex align-items-center justify-content-between" href="{{ route('admin.auth.logout') }}">
                <span class="fs-sm fw-medium">Log Out</span>
                <i class="fa fa-arrow-right-from-bracket ml-1"></i>
            </a>
        </div>
    </div>
</div><!-- END User Dropdown -->
