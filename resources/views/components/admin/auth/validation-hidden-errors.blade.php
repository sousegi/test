@props(['errors'])

@if($errors->any())
    <div class="row g-0 justify-content-center">
        <div class="col-sm-8 col-xl-6">
            <div class="mb-4 text-center">
                <div class="invalid-feedback ">Wrong Credentials</div>
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <p class="mb-0">
                        Wrong Credentials
                    </p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
@endif
