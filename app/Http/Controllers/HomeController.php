<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function welcome(): View
    {
        return view('welcome', [
            'availableBooksCount' => Book::where('status', 'available')->count(),
            'authorsCount'        => Author::count(),
            'categoriesCount'     => Category::count(),
            'latestBooks'         => Book::with('author')->latest()->take(4)->get(),
        ]);
    }
}
