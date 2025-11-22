<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;

class BookController extends Controller
{
    // Display dashboard (list of books)
    public function index()
    {
        // Get all books with their category
        $books = Book::with('category')->get();

        // Count statistics for dashboard cards
        $totalBooks = Book::count();
        $totalCategories = Category::count();

        // Get all categories for the <select> dropdown
        $categories = Category::all();

        // Pass variables to the view
        return view('dashboard', compact('books', 'totalBooks', 'totalCategories', 'categories'));
    }

    // Store a new book
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',             // added author
            'published_year' => 'nullable|integer',           // optional
            'category_id' => 'nullable|exists:categories,id',
        ]);

        Book::create([
            'title' => $request->title,
            'author' => $request->author,                     // added author
            'published_year' => $request->published_year,     // optional
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('dashboard')->with('success', 'Book added successfully.');
    }

    // Update an existing book
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',             // added author
            'published_year' => 'nullable|integer',           // optional
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $book->update([
            'title' => $request->title,
            'author' => $request->author,                     // added author
            'published_year' => $request->published_year,     // optional
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('dashboard')->with('success', 'Book updated successfully.');
    }

    // Delete a book
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('dashboard')->with('success', 'Book deleted successfully.');
    }
}

