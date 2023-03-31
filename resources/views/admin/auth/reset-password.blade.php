@extends('admin.layouts.authentication')

@section('meta')
    <title>{{ env('APP_NAME') }} - Dashboard Update Password</title>
    <meta name="title" content="Amigo CMS Dashboard Reset Password">
    <meta name="description" content="Amigo CMS Dashboard Reset Password">
@endsection

@section('content')
    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="fw-bold mb-2">
            Update Password
        </h1>
        <p class="fw-medium text-muted">
            Please provide your account’s email and new password!
        </p>
    </div><!-- END Header -->

    <x-admin.auth.validation-errors :errors="$errors"/>

    <!-- Reminder Form -->
    <div class="row g-0 justify-content-center">
        <div class="col-sm-8 col-xl-4">
            <form class="js-validation-reminder" action="{{ route('admin.auth.password.update') }}" method="POST">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="mb-4">
                    <input type="email"
                           class="form-control form-control-lg form-control-alt py-3"
                           id="email"
                           name="email"
                           placeholder="email"
                           value="{{ old('email') }}"
                           required />
                </div>

                <div class="mb-4">
                    <input type="password"
                           class="form-control form-control-lg form-control-alt py-3"
                           id="password"
                           name="password"
                           placeholder="Password"
                           required />
                </div>

                <div class="mb-4">
                    <input type="password"
                           class="form-control form-control-lg form-control-alt py-3"
                           id="password_confirmation"
                           name="password_confirmation"
                           placeholder="Confirm Password"
                           required />
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-lg btn-primary">
                        <i class="fa fa-fw fa-lock me-1 opacity-50"></i> Update Password
                    </button>
                </div>
            </form>
        </div>
    </div><!-- END Reminder Form -->
@endsection
