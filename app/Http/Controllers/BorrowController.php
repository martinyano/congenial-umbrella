<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowController extends Controller
{
    public function storeByRfid(Request $request)
    {
        $request->validate([
            'rfid_uid' => 'required|string',
            'book_id' => 'required|exists:books,id',
        ]);

        // 1. Look up user by the registered RFID UID
        $user = User::where('rfid_uid', $request->rfid_uid)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'RFID card not recognized or registered by admin.');
        }

        // 2. Check book availability
        $book = Book::findOrFail($request->book_id);

        if ($book->quantity < 1 || $book->status !== 'available') {
            return redirect()->back()->with('error', 'Book is currently unavailable.');
        }

        // 3. Create Borrow Record
        $borrow = Borrow::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'rfid_uid' => $user->rfid_uid,
            'status' => 'borrowed',
            'borrowed_at' => Carbon::now(),
            'due_at' => Carbon::now()->addDays(7), // Default 7-day rental period
        ]);

        // 4. Decrement available physical stock
        $book->decrement('quantity');
        if ($book->quantity === 0) {
            $book->update(['status' => 'borrowed']);
        }

        return redirect()->back()->with('success', "Book '{$book->title}' borrowed successfully for {$user->name}!");
    }

    public function create(Request $request)
    {
        // Get all available books preloaded with authors
        $books = Book::with('author')
            ->where('status', 'available')
            ->where('quantity', '>', 0)
            ->get();

        return view('borrow.create', compact('books'));
    }

    // Process submission
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $user = Auth::user();
        $book = Book::findOrFail($request->book_id);

        if ($book->quantity < 1) {
            return redirect()->back()->with('error', 'This book is currently out of stock.');
        }

        // Create pending borrow request
        Borrow::create([
            'user_id'     => $user->id,
            'book_id'     => $book->id,
            'rfid_uid'    => $user->rfid_uid ?? 'N/A',
            'status'      => 'pending',
            'borrowed_at' => Carbon::now(),
            'due_at'      => Carbon::now()->addDays(7),
        ]);

        return redirect()->route('books.index')->with('success', 'Borrow request submitted successfully!');
    }
}
