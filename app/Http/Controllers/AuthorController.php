<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = Author::paginate(10);
        return view('admin.authors.index', [
            'authors' => $authors
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.authors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'required|string',
            'status' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $validated['status'] = $request->has('status') ? 'Visible' : 'notVisible';

        if ($request->hasFile('image')) {
        // Saves file to storage/app/public/books and gets path
        $validated['image'] = $request->file('image')->store('authors', 'public');
        }

        Author::create($validated);

        return redirect('/authors')->with('status', 'Author Created Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        return view('admin.authors.show', compact('author'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        return view('admin.authors.edit', compact('author'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'required|string',
            'status' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $validated['status'] = $request->has('status') ? 'Visible' : 'notVisible';

        if ($request->hasFile('image')) {
        $validated['image'] = $request->file('image')->store('covers', 'public');
        } else {
            // Remove 'image' from the validated array so it doesn't overwrite your existing DB image path with null
            unset($validated['image']);
        }

        $author->update($validated);

        return redirect('/authors')->with('status', 'Author updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $author->delete();
        return redirect('/authors')->with('status', 'Author deleted successfully!');
    }
}
