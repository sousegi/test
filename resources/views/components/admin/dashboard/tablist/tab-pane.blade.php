@props(['target', 'active'])

<div class="tab-pane {{ ($active) ? 'active' : '' }}"
     id="{{ $target }}"
     role="tabpanel"
     aria-label="{{ $target }}-tab">
    {{ $slot }}
</div>
