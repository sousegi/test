@props(['href', 'active', 'title', 'icon' => null])

<li class="nav-main-item">
    <a class="nav-main-link {{ $active }}" href="{{ $href }}">
        @if(!is_null($icon))
            <em class="nav-main-link-icon {{ $icon }}"></em>
        @endif
        <span class="nav-main-link-name">{{ $title }}</span>
    </a>
</li>
