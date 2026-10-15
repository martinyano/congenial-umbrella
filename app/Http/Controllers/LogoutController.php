<?php

namespace App\Http\Controllers;

use App\Models\LibraryAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function destroy(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            // Find open library attendance (where exit_time is NULL)
            $activeAttendance = LibraryAttendance::where('user_id', $user->id)
                ->whereNull('exit_time')
                ->latest()
                ->first();

            // Log the exit time
            if ($activeAttendance) {
                $activeAttendance->update([
                    'exit_time' => now(),
                ]);
            }
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
