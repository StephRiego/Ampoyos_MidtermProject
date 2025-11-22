<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Display the dashboard with all books and categories
    public function index()
    {
        $books = Book::with('category')->get();
        $categories = Category::all();
        return view('dashboard', compact('books', 'categories'));
    }

    // Store a new book
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'published_year' => 'nullable|integer',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'published_year' => $request->published_year,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('dashboard')->with('success', 'Book added successfully.');
    }

    // Update an existing book
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'published_year' => 'nullable|integer',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $book->update([
            'title' => $request->title,
            'author' => $request->author,
            'published_year' => $request->published_year,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('dashboard')->with('success', 'Book updated successfully.');
    }

    // Delete a book
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('dashboard')->with('success', 'Book removed successfully.');
    }
}
