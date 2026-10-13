<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // 1. If the user is an admin, show the admin dashboard metrics
        if ($user && $user->usertype === 'admin') {
            $now = Carbon::now();

            $totalPhysical = Book::sum('quantity');
            $borrowedCount = Borrow::where('status', 'borrowed')->where('due_at', '>=', $now)->count();
            $overdueCount  = Borrow::where('status', 'borrowed')->where('due_at', '<', $now)->count();

            // Fixed math and removed the stray dash error
            $availableBooksCount = max(0, $totalPhysical - ($borrowedCount + $overdueCount));
            
            $pendingRequests = Borrow::with(['user', 'book'])->where('status', 'pending')->latest()->get();

            return view('admin.index', compact(
                'availableBooksCount', 
                'borrowedCount', 
                'overdueCount', 
                'pendingRequests'
            ));
        }

        

        // 2. If it's a regular student, send them straight to their book catalog
        return redirect()->route('dashboard');
    }
}