@props(['src', 'deleteUrl'])
<div class="col-12 col-md-6 col-lg-4 mb-4">
    <div class="options-container">
        <img class="img-fluid options-item" src="{{ $src }}" alt="Image">
        <div class="options-overlay bg-black-75">
            <div class="options-overlay-content">
                <a class="btn btn-sm btn-alt-secondary acms-delete-img-link" href="{{ $deleteUrl }}">
                    <i class="fa fa-times text-danger me-1"></i> Delete
                </a>
            </div>
        </div>
    </div>
</div>
