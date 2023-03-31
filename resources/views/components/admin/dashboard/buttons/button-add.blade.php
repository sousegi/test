@props(['title', 'href' => 'javascript:void(0);'])

<a class="btn btn-primary btn-sm ms-2" href="{{ $href }}">
    <i class="fa fa-fw fa-plus"></i>
    {{ $title }}
</a>
