<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookCategory;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('category')->latest();
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('author', 'like', '%' . $request->search . '%')
                  ->orWhere('isbn', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        $books      = $query->paginate(20)->withQueryString();
        $categories = BookCategory::orderBy('name')->get();
        return view('library-mgmt.book-list', compact('books', 'categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:book_categories,id',
            'title'       => 'required|string|max:500',
            'author'      => 'nullable|string|max:255',
            'publisher'   => 'nullable|string|max:255',
            'isbn'        => 'nullable|string|max:50|unique:books,isbn',
            'edition'     => 'nullable|string|max:50',
            'quantity'    => 'required|integer|min:1',
            'shelf_no'    => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);
        $data['available'] = $data['quantity'];
        Book::create($data);
        return back()->with('success', 'Book added.');
    }

    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:book_categories,id',
            'title'       => 'required|string|max:500',
            'author'      => 'nullable|string|max:255',
            'publisher'   => 'nullable|string|max:255',
            'isbn'        => 'nullable|string|max:50|unique:books,isbn,' . $book->id,
            'edition'     => 'nullable|string|max:50',
            'quantity'    => 'required|integer|min:1',
            'shelf_no'    => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);
        $issued          = $book->quantity - $book->available;
        $data['available'] = max(0, $data['quantity'] - $issued);
        $book->update($data);
        return back()->with('success', 'Book updated.');
    }

    public function destroy(Book $book)
    {
        if ($book->issues()->where('status', 'issued')->exists()) {
            return back()->with('error', 'Cannot delete book with active issues.');
        }
        $book->delete();
        return back()->with('success', 'Book deleted.');
    }
}
