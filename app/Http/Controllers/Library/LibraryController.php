<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\BookIssue;
use App\Models\LibraryMember;
use App\Models\Student;
use App\Models\Staff;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    // Books
    public function booksIndex(Request $request)
    {
        $query = Book::with('category')->latest();
        if ($request->filled('search'))   { $query->where(fn($q) => $q->where('title','like','%'.$request->search.'%')->orWhere('isbn','like','%'.$request->search.'%')->orWhere('author','like','%'.$request->search.'%')); }
        if ($request->filled('category')) { $query->where('category_id', $request->category); }
        $books      = $query->paginate(20)->withQueryString();
        $categories = BookCategory::orderBy('name')->get();
        return view('library.books', compact('books', 'categories'));
    }

    public function storeBook(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:book_categories,id',
            'title'       => 'required|string|max:500',
            'author'      => 'nullable|string|max:255',
            'publisher'   => 'nullable|string|max:255',
            'isbn'        => 'nullable|string|max:30',
            'edition'     => 'nullable|string|max:50',
            'quantity'    => 'required|integer|min:1',
            'shelf_no'    => 'nullable|string|max:50',
        ]);
        $validated['available'] = $validated['quantity'];
        Book::create($validated);
        return back()->with('success', 'Book added to catalogue.');
    }

    public function destroyBook(Book $book)
    {
        if ($book->issues()->where('status','issued')->count()) {
            return back()->with('error', 'Cannot delete book with active issues.');
        }
        $book->delete();
        return back()->with('success', 'Book deleted.');
    }

    // Categories
    public function storeCat(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100|unique:book_categories,name']);
        BookCategory::create(['name' => $request->name]);
        return back()->with('success', 'Category added.');
    }

    // Members
    public function membersIndex(Request $request)
    {
        $members = LibraryMember::latest()->paginate(20)->withQueryString();
        $students = Student::active()->orderBy('first_name')->get();
        $staff    = Staff::where('is_active', true)->orderBy('first_name')->get();
        return view('library.members', compact('members', 'students', 'staff'));
    }

    public function storeMember(Request $request)
    {
        $request->validate([
            'person_id'   => 'required|string',
            'person_type' => 'required|in:student,staff',
            'valid_until' => 'nullable|date|after:today',
            'max_books'   => 'nullable|integer|min:1|max:10',
        ]);
        LibraryMember::create([
            'person_id'   => $request->person_id,
            'person_type' => $request->person_type,
            'member_no'   => LibraryMember::generateMemberNo($request->person_type),
            'valid_until' => $request->valid_until,
            'max_books'   => $request->max_books ?? 3,
        ]);
        return back()->with('success', 'Library member added.');
    }

    // Issue & Return
    public function issueIndex()
    {
        $recentIssues = BookIssue::with(['book','member'])->latest()->take(10)->get();
        $books        = Book::where('available', '>', 0)->orderBy('title')->get();
        $members      = LibraryMember::where('is_active', true)->orderBy('member_no')->get();
        return view('library.issue', compact('recentIssues', 'books', 'members'));
    }

    public function issueBook(Request $request)
    {
        $validated = $request->validate([
            'book_id'   => 'required|exists:books,id',
            'member_id' => 'required|exists:library_members,id',
            'due_date'  => 'required|date|after:today',
        ]);

        $book   = Book::findOrFail($validated['book_id']);
        $member = LibraryMember::findOrFail($validated['member_id']);

        if ($book->available <= 0) return back()->with('error', 'No copies available.');
        if (!$member->canBorrow()) return back()->with('error', 'Member has reached maximum issue limit.');

        BookIssue::create([
            'book_id'    => $book->id,
            'member_id'  => $member->id,
            'issued_by'  => auth()->id(),
            'issue_date' => now(),
            'due_date'   => $validated['due_date'],
            'status'     => 'issued',
        ]);
        $book->decrement('available');

        return back()->with('success', "Book issued to {$member->member_no}.");
    }

    public function returnBook(Request $request, BookIssue $issue)
    {
        if ($issue->status !== 'issued') return back()->with('error', 'Book already returned.');

        $fine = $issue->calculateFine();
        $issue->update(['return_date' => now(), 'fine_amount' => $fine, 'status' => 'returned']);
        $issue->book->increment('available');

        return back()->with('success', 'Book returned.' . ($fine > 0 ? " Fine: {$fine}" : ''));
    }

    public function overdueIndex()
    {
        $overdue = BookIssue::with(['book','member'])
            ->whereIn('status', ['issued', 'overdue'])->where('due_date', '<', now())->get();
        // Update status
        BookIssue::where('status','issued')->where('due_date','<',now())->update(['status'=>'overdue']);
        return view('library.overdue', compact('overdue'));
    }
}
