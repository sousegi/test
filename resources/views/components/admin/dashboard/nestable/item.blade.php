@props(['title', 'id', 'published', 'buttons'])

<li class="dd-item d-flex flex-wrap justify-content-between align-items-center {{ $published ?: 'table-danger' }}" data-id="{{ $id }}">
    <div class="dd-handle"><em class="fa fa-arrows-alt fa-1x"></em></div>
    <div class="font-w600 font-size-sm flex-fill" data-item-id="{{ $id }}">
        {{ $title }}
    </div>
    <div class="text-center" style="width: 150px;">
        {{ $buttons }}
    </div>

    {{ $slot }}
</li>
