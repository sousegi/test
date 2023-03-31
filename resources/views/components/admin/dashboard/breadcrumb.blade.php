@props(['title', 'href'])

<li {{ $attributes->class(['breadcrumb-item'])->merge(isset($href) ? ['aria-current' => 'page'] : []) }}>
    @if(isset($href))
        <a class="link-fx" href="{{ $href }}">{{ $title }}</a>
    @else
        {{ $title }}
    @endif
</li>
