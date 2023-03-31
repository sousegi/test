@props(['title', 'active', 'icon' => null])

<li class="nav-main-item {{ $active }}">
    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
        @if(!is_null($icon))
            <em class="nav-main-link-icon {{ $icon }}"></em>
        @endif
        <span class="nav-main-link-name">{{ $title }}</span>
    </a>
    <ul class="nav-main-submenu">
        {{ $slot }}
    </ul>
</li>
