@extends('admin.layouts.authentication')

@section('meta')
    <title>{{ env('APP_NAME') }} - Dashboard Forgot Password</title>
    <meta name="title" content="Amigo CMS Dashboard Forgot Password">
    <meta name="description" content="Amigo CMS Dashboard Forgot Password">
@endsection

@section('content')
    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="fw-bold mb-2">
            Forgot Password?
        </h1>
        <p class="fw-medium text-muted">
            Please provide your account’s email, and we will send you link to reset your password.
        </p>
    </div><!-- END Header -->

    <x-admin.auth.session-status :status="session('status')" />

    <x-admin.auth.validation-errors :errors="$errors" />

    <!-- Reminder Form -->
    <div class="row g-0 justify-content-center">
        <div class="col-sm-8 col-xl-4">
            <form class="js-validation-reminder" action="{{ route('admin.auth.password.email') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <input type="email"
                           class="form-control form-control-lg form-control-alt py-3"
                           id="email"
                           name="email"
                           placeholder="Email" />
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-lg btn-primary">
                        <i class="fa fa-fw fa-envelope me-1 opacity-50"></i> Send Mail
                    </button>
                </div>
            </form>
        </div>
    </div><!-- END Reminder Form -->
@endsection
