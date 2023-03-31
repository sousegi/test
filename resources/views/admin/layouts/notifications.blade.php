@if(session()->has('success'))
    <x-admin.dashboard.notification :type="'success'" :icon="'fa fa-check me-1'" :message="session()->get('success')" />
@endif
@if(session()->has('error'))
    <x-admin.dashboard.notification :type="'danger'" :icon="'fa fa-exclamation me-1'" :message="session()->get('error')" />
@endif
@if(session()->has('warning'))
    <x-admin.dashboard.notification :type="'warning'" :icon="'fa fa-times me-1'" :message="session()->get('warning')" />
@endif
