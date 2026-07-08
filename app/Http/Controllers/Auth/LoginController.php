<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function __construct(
        private readonly AuthService $authService,
    ) {
    }

    public function showLoginForm(): View
    {
        return view('restaurant.auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $user = $this->authService->login(
            $request->validated('email'),
            $request->validated('password'),
            $request->boolean('remember'),
        );

        $request->session()->regenerate();

        return redirect()->intended($user->redirectDefault());
    }

    public function logout(Request $request): RedirectResponse
    {
        $this->authService->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
