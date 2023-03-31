@props(['title'])

<!-- Block Header -->
<div class="block-header block-header-default">
    <h3 class="block-title">{{ $title }}</h3>
    {{ $slot }}
</div><!-- End Block Header -->
