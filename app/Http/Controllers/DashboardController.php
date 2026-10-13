<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        // Gather summary counts for the student dashboard
        $totalBooks = Book::count();
        $totalAuthors = Author::count();
        $totalCategories = Category::count();

        $availableBooks = Book::where('status', 'available')->count();
        $borrowedBooks = Book::where('status', 'borrowed')->count();
        $lostBooks = Book::where('status', 'lost')->count();
        
        $totalPhysicalInventory = Book::sum('quantity');
        $categories = Category::all();

        // Start building the book query with relationships
        $query = Book::with(['author', 'category']);

        // Use the global request() helper directly here
        if (request()->has('category') && request()->category != '') {
            $query->where('category_id', request()->category);
        }

        $books = $query->latest()->get();
        $latestBooks = Book::with('author')->latest()->take(4)->get();

        // Render the student dashboard view with filtered data
        return view('dashboard', compact(
            'totalBooks', 
            'totalAuthors', 
            'totalCategories', 
            'availableBooks', 
            'borrowedBooks', 
            'lostBooks',
            'totalPhysicalInventory',
            'books',
            'latestBooks',
            'categories'
        ));
    }
}