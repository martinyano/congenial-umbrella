<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\LibraryAttendance;

class KioskController extends Controller
{
    public function index()
    {
        return view('kiosk.entry');
    }

    public function processScan(Request $request)
    {
        $request->validate([
            'rfid_uid' => 'required|string',
        ]);

        $cleanUid = trim($request->rfid_uid);
        $user = User::where('rfid_uid', $cleanUid)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unregistered ID card. Please contact the librarian.',
            ], 404);
        }

        // Check if student is currently inside (has an entry without an exit)
        $activeAttendance = LibraryAttendance::where('user_id', $user->id)
            ->whereNull('exit_time')
            ->latest()
            ->first();

        if ($activeAttendance) {
            // LOG EXIT: Student is leaving
            $activeAttendance->update([
                'exit_time' => now(),
            ]);

            return response()->json([
                'success' => true,
                'type' => 'exit',
                'message' => "Goodbye, {$user->name}! Exit logged.",
            ]);
        } else {
            // LOG ENTRY: Student is entering
            LibraryAttendance::create([
                'user_id' => $user->id,
                'entry_time' => now(),
            ]);

            // Optional: Log into session if this kiosk handles individual user dashboard redirects
            Auth::login($user);

            return response()->json([
                'success' => true,
                'type' => 'entry',
                'message' => "Welcome, {$user->name}! Entry logged.",
                'redirect_url' => route('dashboard'),
            ]);
        }
    }
}