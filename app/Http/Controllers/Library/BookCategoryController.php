<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use App\Models\BookCategory;
use Illuminate\Http\Request;

class BookCategoryController extends Controller
{
    public function index()
    {
        $categories = BookCategory::withCount('books')->orderBy('name')->get();
        return view('library-mgmt.book-categories', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100|unique:book_categories,name',
            'description' => 'nullable|string|max:500',
        ]);
        BookCategory::create($data);
        return back()->with('success', 'Category added.');
    }

    public function update(Request $request, BookCategory $bookCategory)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100|unique:book_categories,name,' . $bookCategory->id,
            'description' => 'nullable|string|max:500',
        ]);
        $bookCategory->update($data);
        return back()->with('success', 'Category updated.');
    }

    public function destroy(BookCategory $bookCategory)
    {
        if ($bookCategory->books()->exists()) {
            return back()->with('error', 'Cannot delete category with books.');
        }
        $bookCategory->delete();
        return back()->with('success', 'Category deleted.');
    }
}
