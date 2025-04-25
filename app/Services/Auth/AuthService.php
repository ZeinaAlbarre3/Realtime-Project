<?php

namespace App\Services\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function login(array $data,String $guard,String $redirectRoute): RedirectResponse
    {
        if (Auth::guard($guard)->attempt($data)) {
            session()->regenerate();
            return redirect()->route($redirectRoute);
        } else {
            return back()->withErrors(['auth' => 'Invalid credentials.']);
        }
    }

    public function logout(String $guard,String $redirectRoute): RedirectResponse
    {
        Auth::guard($guard)->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route($redirectRoute);
    }
}
