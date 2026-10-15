<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['author', 'category'])->get();
        $books = Book::paginate(10);
        return view('admin.books.index', [
            'books' => $books
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $authors = Author::all();
        $categories = Category::all();
        return view('admin.books.create', compact('authors', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'author_id'   => 'required|exists:authors,id',
            'title'       => 'required|string|max:255',
            'isbn'        => 'nullable|string|unique:books,isbn',
            'quantity'    => 'required|integer|min:1',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'nullable',
        ]);

        $validated['status'] = match ($request->input('status')) {
            'borrowed' => 'borrowed',
            'lost'     => 'lost',
            default    => 'available', // Safely catches 'available', missing inputs, or invalid text
        };


        if ($request->hasFile('image')) {
        // Saves file to storage/app/public/books and gets path
        $validated['image'] = $request->file('image')->store('books', 'public');
        }

        Book::create($validated);

        return redirect('/books')->with('status', 'Book Created Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $authors = Author::all();
        $categories = Category::all();
        return view('admin.books.show', compact('book', 'authors', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $authors = Author::all();
        $categories = Category::all();
        return view('admin.books.edit', compact('book', 'authors', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'author_id'   => 'required|exists:authors,id',
            'title'       => 'required|string|max:255',
            'isbn'        => 'nullable|string|unique:books,isbn,' . $book->id,
            'quantity'    => 'required|integer|min:1',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'nullable',
        ]);

        $validated['status'] = match ($request->input('status')) {
            'borrowed' => 'borrowed',
            'lost'     => 'lost',
            default    => 'available', // Safely catches 'available', missing inputs, or invalid text
        };

        if ($request->hasFile('image')) {
        // Saves file to storage/app/public/books and gets path
        $validated['image'] = $request->file('image')->store('books', 'public');
        }

        $book->update($validated);

        return redirect('/books')->with('status', 'Book updated Successfully!');

    }

    public function publicShow(Book $book)
    {
        // 1. Preload author and category relationships
        $book->load(['author', 'category']);

        // 2. Fetch the latest borrow record for this book & current user
        $transaction = Borrow::where('book_id', $book->id)
            ->where('user_id', Auth::id())
            ->latest()
            ->first();

        // 3. Pass both $book and $transaction to the view
        return view('books.show', compact('book', 'transaction'));
    }

    public function userIndex()
    {
        $userId = Auth::id();

        // 1. Unborrowed / Available Books
        $unborrowedBooks = Book::with('author')
            ->where('status', 'available')
            ->latest()
            ->get();

        // 2. Borrow Requests (Pending / Approved)
        $requests = Borrow::with('book.author')
            ->where('user_id', $userId)
            ->whereIn('status', ['pending', 'approved'])
            ->latest()
            ->get();

        // 3. Currently Borrowed Books
        $borrowedBooksList = Borrow::with('book.author')
            ->where('user_id', $userId)
            ->where('status', 'borrowed')
            ->latest()
            ->get();

        // 4. Past History Records
        $historyBooks = Borrow::with('book.author')
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        return view('books.index', compact('unborrowedBooks', 'requests', 'borrowedBooksList', 'historyBooks'));
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect('/books')->with('status', 'Category deleted successfully!');
    }
}
