<?php

namespace App\Http\Controllers\SupportStaff\Auth;

use App\Enums\Auth\AuthGuard;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SupportAuthController extends Controller
{
    private AuthService $authService;
    public function __construct(AuthService $authService){
        $this->authService = $authService;
    }

    public function show()
    {
        return view('support.auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        return $this->authService->login($request->validated(), AuthGuard::SUPPORT_STAFF->value, 'support.dashboard');
    }

    public function logout(): RedirectResponse
    {
        return $this->authService->logout(AuthGuard::SUPPORT_STAFF->value,'support.login');
    }
}
