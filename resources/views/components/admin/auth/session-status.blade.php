@props(['status'])

@if($status)
    <div class="row g-0 justify-content-center">
        <div class="col-sm-8 col-xl-6">
            <div class="mb-0 text-center">
                <div class="alert alert-success alert-dismissible" role="alert">
                    <p class="mb-0">
                        {{ $status }}
                    </p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
@endif
