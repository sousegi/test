<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Requests\Auth\PasswordResetRequest;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;

/**
 * Class ForgotPasswordController
 * @package App\Http\Admin\Auth
 */
class ForgotPasswordController
{
    /**
     * Display the password reset view for the given token.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        return view('admin.auth.forgot-password');
    }

    /**
     * Handle an incoming new password request.
     *
     * @param  \App\Http\Requests\Auth\PasswordResetRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PasswordResetRequest $request): RedirectResponse
    {
        // Configuring the default password reset link
        ResetPassword::createUrlUsing(
            fn($notifiable, $token) => url(route('admin.auth.password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false))
        );

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::broker('admins')->sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]);
    }
}
