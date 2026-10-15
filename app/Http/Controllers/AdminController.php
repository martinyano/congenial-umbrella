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
        // Gather live data counts straight from the database
        $totalBooks = Book::count();
        $totalAuthors = Author::count();
        $totalCategories = Category::count();

        // Inventory status metrics (assuming your statuses are strings: 'available', 'borrowed', 'lost')
        $availableBooks = Book::where('status', 'available')->count();
        $borrowedBooks = Book::where('status', 'borrowed')->count();
        $lostBooks = Book::where('status', 'lost')->count();

        // Sum of the total physical inventory quantity column
        $totalPhysicalInventory = Book::sum('quantity');

        $books = Book::all();
        $availableBooksCount = Book::where('status', 'available')->count();
        $authorsCount        = Author::count();
        $categoriesCount     = Category::count();
        $latestBooks         = Book::with('author')->latest()->take(4)->get();

        // Fetch categories with an optional count of books
        $categories = Category::all();

        // Query books, with optional category filtering
        $query = Book::with(['author', 'category']);

        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        $latestBooks = $query->latest()->get();

        $user = Auth::user();

        // If the user is an admin, render the admin dashboard/transactions view
        if ($user && $user->usertype === 'admin') {
            $now = Carbon::now();

            $totalPhysical = Book::sum('quantity');
            $borrowedCount = Borrow::where('status', 'borrowed')->where('due_at', '>=', $now)->count();
            $overdueCount  = Borrow::where('status', 'borrowed')->where('due_at', '<', $now)->count();

            $availableBooksCount = max(0, $totalPhysical - ($borrowedCount + $overdueCount));
            $pendingRequests = Borrow::with(['user', 'book'])->where('status', 'pending')->latest()->get();

            // Renders your admin/index.blade.php view
            return view('admin.index', compact(
                'availableBooksCount', 
                'borrowedCount', 
                'overdueCount', 
                'pendingRequests'
            ));
        }

        // Otherwise, it's a regular student — send them to their catalog/dashboard view
        return redirect()->route('books.index'); // Or your student dashboard view

        return view('dashboard', compact(
            'totalBooks', 
            'totalAuthors', 
            'totalCategories', 
            'availableBooks', 
            'borrowedBooks', 
            'lostBooks',
            'totalPhysicalInventory',
            'books',
            'availableBooksCount',
            'authorsCount',
            'categoriesCount',
            'latestBooks',
            'categories'
        ));
    }
}
