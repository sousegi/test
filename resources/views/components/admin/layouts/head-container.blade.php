@props(['title', 'description'])

<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1 mb-1 mb-md-0">
                <h1 class="h3 fw-bold mb-2">
                    {{ $title }}
                </h1>
                @if(isset($description))
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                        {{ $description }}
                    </h2>
                @endif
            </div>
            {{ $slot }}
        </div>
    </div>
</div>
