<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Carbon\Carbon;

class InventoryController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        $books = Book::withCount([
            'borrows as borrowed_count' => function ($query) use ($now) {
                $query->where('status', 'borrowed');
            }
        ])->get();

        return view('admin.inventory', compact('books'));
    }
}