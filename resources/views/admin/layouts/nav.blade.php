<!-- Sidebar -->
<nav id="sidebar" aria-label="Main Navigation">

    <x-admin.dashboard.sidebar.header />

    <x-admin.layouts.nav-container>
        <x-admin.dashboard.nav.nav-li
                :href="route('admin.dashboard')"
                :active="setActive('admin/dashboard*')"
                :icon="'si si-speedometer'"
                :title="'Dashboard'" />

{{--        @foreach($modules as $module)--}}
{{--            <x-admin.dashboard.nav.nav-li--}}
{{--                    :href="'/admin/' . $module->name"--}}
{{--                    :active="setActive('admin/' . $module->name . '*')"--}}
{{--                    :icon="$module->icon"--}}
{{--                    :title="$module->title ?? $module->name"--}}
{{--            />--}}
{{--        @endforeach--}}

        <x-admin.dashboard.nav.nav-li
            :href="route('admin.products.index')"
            :active="setActive('admin/products*')"
            :icon="'si si-speedometer'"
            :title="'Products'" />

        <x-admin.dashboard.nav.nav-li
            :href="route('admin.users.index')"
            :active="setActive('admin/users*')"
            :icon="'si si-user'"
            :title="'Users'" />



        <x-admin.dashboard.nav.nav-menu
                :title="'Settings'"
                :icon="'si si-settings'"
                :active="setActive(['admin/settings*', 'admin/admins*', 'admin/translations*', 'admin/languages*'], 'open')"
        >
            <x-admin.dashboard.nav.nav-li
                    :href="route('admin.settings.index')"
                    :active="setActive('admin/settings*')"
                    :title="'Site Settings'" />
            <x-admin.dashboard.nav.nav-li
                    :href="route('admin.admins.index')"
                    :active="setActive('admin/admins*')"
                    :title="'Admins'" />
            <x-admin.dashboard.nav.nav-li
                    :href="route('admin.languages.index')"
                    :active="setActive('admin/languages*')"
                    :title="'Languages'" />
            <x-admin.dashboard.nav.nav-li
                    :href="route('admin.translations.index')"
                    :active="setActive('admin/translations*')"
                    :title="'Translations'" />
        </x-admin.dashboard.nav.nav-menu>
    </x-admin.layouts.nav-container>

</nav><!-- END Sidebar -->
