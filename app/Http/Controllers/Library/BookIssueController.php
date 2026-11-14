<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookIssue;
use App\Models\LibraryMember;
use App\Models\LibrarySetting;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookIssueController extends Controller
{
    public function issueIndex(Request $request)
    {
        $books   = Book::where('available', '>', 0)->orderBy('title')->get();
        $members = LibraryMember::where('is_active', true)->orderBy('name')->get();
        $recent  = BookIssue::with(['book', 'member'])->where('status', 'issued')->latest()->take(10)->get();
        return view('library-mgmt.issue-book', compact('books', 'members', 'recent'));
    }

    public function issue(Request $request)
    {
        $data = $request->validate([
            'book_id'   => 'required|exists:books,id',
            'member_id' => 'required|exists:library_members,id',
        ]);

        $book    = Book::findOrFail($data['book_id']);
        $member  = LibraryMember::findOrFail($data['member_id']);
        $setting = LibrarySetting::current();

        if ($book->available <= 0) {
            return back()->with('error', 'No copies available.');
        }
        if (!$member->is_active || $member->valid_until->isPast()) {
            return back()->with('error', 'Member membership expired or inactive.');
        }
        $activeCount = $member->activeIssues()->count();
        if ($activeCount >= $member->max_books) {
            return back()->with('error', "Member has reached the maximum issue limit ({$member->max_books}).");
        }
        $unpaidFine = BookIssue::where('member_id', $member->id)
            ->where('fine_amount', '>', 0)->where('fine_paid', false)->exists();
        if ($unpaidFine) {
            return back()->with('error', 'Member has unpaid fines.');
        }

        $days     = $member->person_type === 'staff' ? $setting->staff_issue_days : $setting->student_issue_days;
        $dueDate  = Carbon::today()->addDays($days);

        BookIssue::create([
            'book_id'    => $book->id,
            'member_id'  => $member->id,
            'issued_by'  => auth()->id(),
            'issue_date' => today(),
            'due_date'   => $dueDate,
            'status'     => 'issued',
        ]);

        $book->decrement('available');
        return back()->with('success', 'Book issued successfully. Due: ' . $dueDate->format('d M Y'));
    }

    public function returnIndex(Request $request)
    {
        $issues = BookIssue::with(['book', 'member'])
            ->whereIn('status', ['issued', 'overdue'])
            ->when($request->search, fn($q) => $q->whereHas('member', fn($m) => $m->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('member_no', 'like', '%' . $request->search . '%')))
            ->latest()->paginate(20)->withQueryString();
        $setting = LibrarySetting::current();
        return view('library-mgmt.issue-return', compact('issues', 'setting'));
    }

    public function processReturn(Request $request, BookIssue $issue)
    {
        if ($issue->status === 'returned') {
            return back()->with('error', 'Book already returned.');
        }

        $setting    = LibrarySetting::current();
        $returnDate = Carbon::today();
        $fine       = 0;

        if ($returnDate->gt($issue->due_date)) {
            $overdueDays = $returnDate->diffInDays($issue->due_date);
            $fine        = min($overdueDays * $setting->fine_per_day, $setting->max_fine_per_book);
        }

        $issue->update([
            'return_date'  => $returnDate,
            'fine_amount'  => $fine,
            'fine_paid'    => $fine == 0,
            'status'       => 'returned',
        ]);

        $issue->book->increment('available');
        $msg = 'Book returned.' . ($fine > 0 ? " Fine: ৳{$fine}" : '');
        return back()->with('success', $msg);
    }

    public function overdueIndex()
    {
        $issues = BookIssue::with(['book', 'member'])
            ->where('status', 'issued')
            ->where('due_date', '<', today())
            ->orderBy('due_date')
            ->paginate(20);
        return view('library-mgmt.book-return-due', compact('issues'));
    }
}
