<?php

namespace App\Http\Responses;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Http\Responses\LoginResponse as JetstreamLoginResponse;

class LoginResponse extends JetstreamLoginResponse
{
    public function toResponse($request): RedirectResponse
    {
        $user = Auth::user();

        // If user is admin, redirect to admin transactions/dashboard
        if ($user && $user->usertype === 'admin') {
            return redirect()->intended(route('admin.transactions'));
        }

        // If user is a student, redirect to student dashboard/catalog
        return redirect()->intended(route('dashboard'));
    }
}
