@props(['title', 'active', 'target'])

<li class="nav-item">
    <button class="nav-link {{ ($active) ? 'active' : ''}}"
            id="{{ $target }}-tab"
            data-bs-toggle="tab"
            data-bs-target="#{{ $target }}"
            role="tab"
            aria-controls="{{ $target }}"
            aria-selected="true"
            type="button">
        {{ $title }}
    </button>
</li>
