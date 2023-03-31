<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * Class LoginController
 * @package App\Http\Admin\Auth
 */
class LoginController extends Controller
{
    public function index(): View
    {
        return view('admin.auth.login');
    }

    /**
     * Authenticate the user and redirect to the dashboard.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        if (auth()->guard('admin')->attempt($credentials)) {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()
            ->back()
            ->withInput($request->only('email', 'password', 'remember'))
            ->withErrors(['message' => 'Wrong credentials!']);
    }
}
