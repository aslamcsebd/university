<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use App\Models\BookRequest;
use App\Models\LibraryMember;
use Illuminate\Http\Request;

class BookRequestController extends Controller
{
    public function index(Request $request)
    {
        $requests = BookRequest::with('member')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()->paginate(20)->withQueryString();
        $members = LibraryMember::where('is_active', true)->orderBy('name')->get();
        return view('library-mgmt.book-requests', compact('requests', 'members'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'member_id'  => 'required|exists:library_members,id',
            'book_title' => 'required|string|max:500',
            'author'     => 'nullable|string|max:255',
            'reason'     => 'nullable|string|max:1000',
        ]);
        BookRequest::create($data);
        return back()->with('success', 'Request submitted.');
    }

    public function updateStatus(Request $request, BookRequest $bookRequest)
    {
        $request->validate(['status' => 'required|in:pending,approved,rejected']);
        $bookRequest->update(['status' => $request->status]);
        return back()->with('success', 'Status updated.');
    }
}
