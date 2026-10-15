<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminTransactionController extends Controller
{
    // Admin Dashboard View
    public function dashboard()
    {
        $now = Carbon::now();

        // 1. Total copies in system minus currently borrowed and overdue copies
        $totalPhysical = Book::sum('quantity');
        $borrowedCount = Borrow::where('status', 'borrowed')->where('due_at', '>=', $now)->count();
        $overdueCount  = Borrow::where('status', 'borrowed')->where('due_at', '<', $now)->count();

        $availableBooksCount = max(0, $totalPhysical - ($borrowedCount + $overdueCount));
        $pendingRequests = Borrow::with(['user', 'book'])->where('status', 'pending')->latest()->get();

        return view('admin.index', [
            'availableBooksCount' => $availableBooksCount,
            'borrowedBooksCount'  => $borrowedCount,
            'overdueBooksCount'   => $overdueCount,
            'pendingRequests'     => $pendingRequests,
        ]);
    }

    // Transactions Index View
    public function transactions()
    {
        $now = Carbon::now();

        $requests   = Borrow::with(['user', 'book'])->where('status', 'pending')->latest()->get();
        $unborrowed = Borrow::with(['user', 'book'])->whereIn('status', ['returned', 'rejected'])->latest()->get();
        $borrowed   = Borrow::with(['user', 'book'])->where('status', 'borrowed')->where('due_at', '>=', $now)->latest()->get();
        
        // Auto-compute dynamic fines (e.g. ₱10/day)
        $overdue    = Borrow::with(['user', 'book'])
            ->where('status', 'borrowed')
            ->where('due_at', '<', $now)
            ->get()
            ->map(function ($item) use ($now) {
                $days = max(1, $now->diffInDays($item->due_at));
                $item->fine_amount = $days * 10.00; // ₱10.00 per day rate
                return $item;
            });

        return view('admin.transactions', compact('requests', 'unborrowed', 'borrowed', 'overdue'));
    }

    // Accept Borrow Request
    public function approve(Borrow $borrow)
    {
        $borrow->update([
            'status'      => 'borrowed',
            'borrowed_at' => Carbon::now(),
            'due_at'      => Carbon::now()->addDays(7),
        ]);

        return redirect()->back()->with('success', 'Borrow request approved!');
    }

    // Deny Borrow Request
    public function deny(Borrow $borrow)
    {
        $borrow->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Borrow request denied.');
    }

    // Mark as Returned
    public function returnBook(Borrow $borrow)
    {
        $borrow->update([
            'status'      => 'returned',
            'returned_at' => Carbon::now(),
        ]);

        return redirect()->back()->with('success', 'Book successfully checked back into inventory.');
    }
}
