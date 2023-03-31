@extends('admin.layouts.authentication')

@section('meta')
    <title>{{ env('APP_NAME') }} - Dashboard Login</title>
    <meta name="title" content="Amigo CMS Dashboard Login">
    <meta name="description" content="Amigo CMS Dashboard Login">
@endsection

@section('content')
    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="fw-bold mb-2">
            Sign In
        </h1>
        <p class="fw-medium text-muted">
            Welcome
        </p>
    </div><!-- END Header -->

    <x-admin.auth.session-status :status="session('status')" />

    <x-admin.auth.validation-hidden-errors :errors="$errors" />

    <!-- Sign In Form -->
    <div class="row g-0 justify-content-center">
        <div class="col-sm-8 col-xl-4">
            <form class="js-validation-signin" action="{{ route('admin.auth.authenticate') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <input type="email"
                           class="form-control form-control-lg form-control-alt py-3"
                           id="email"
                           name="email"
                           placeholder="Email" />
                </div>
                <div class="mb-4">
                    <input type="password"
                           class="form-control form-control-lg form-control-alt py-3"
                           id="password"
                           name="password"
                           placeholder="Password" />
                </div>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <a class="text-muted fs-sm fw-medium d-block d-lg-inline-block mb-1" href="{{ route('admin.auth.password.request') }}">
                            Forgot Password?
                        </a>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-lg btn-primary">
                            <i class="fa fa-fw fa-sign-in-alt me-1 opacity-50"></i> Sign In
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div><!-- END Sign In Form -->
@endsection
