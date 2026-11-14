<?php

namespace App\Http\Controllers\Communication;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use App\Models\NoticeCategory;
use App\Models\Event;
use App\Models\Notification;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function noticesIndex(Request $request)
    {
        $query = Notice::with(['category', 'creator'])->latest();
        if ($request->filled('audience')) { $query->where('audience', $request->audience); }
        if ($request->filled('category')) { $query->where('category_id', $request->category); }
        $notices    = $query->paginate(20)->withQueryString();
        $categories = NoticeCategory::orderBy('name')->get();
        return view('communication.notices', compact('notices', 'categories'));
    }

    public function storeNotice(Request $request)
    {
        $validated = $request->validate([
            'category_id'  => 'nullable|exists:notice_categories,id',
            'title'        => 'required|string|max:500',
            'content'      => 'required|string',
            'audience'     => 'required|in:all,students,staff,teachers,parents',
            'published_at' => 'nullable|date',
            'expires_at'   => 'nullable|date|after:published_at',
            'is_pinned'    => 'boolean',
        ]);
        $validated['created_by']  = auth()->id();
        $validated['is_pinned']   = $request->boolean('is_pinned');
        $validated['published_at'] = $validated['published_at'] ?? now();
        Notice::create($validated);
        return back()->with('success', 'Notice published.');
    }

    public function destroyNotice(Notice $notice)
    {
        $notice->delete();
        return back()->with('success', 'Notice deleted.');
    }

    public function storeCat(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100|unique:notice_categories,name']);
        NoticeCategory::create(['name' => $request->name, 'color' => $request->color ?? '#3b82f6']);
        return back()->with('success', 'Category added.');
    }

    // Events
    public function eventsIndex()
    {
        $events = Event::latest()->paginate(20);
        return view('communication.events', compact('events'));
    }

    public function storeEvent(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:500',
            'description'  => 'nullable|string',
            'start_at'     => 'required|date',
            'end_at'       => 'required|date|after_or_equal:start_at',
            'location'     => 'nullable|string|max:500',
            'audience'     => 'required|in:all,students,staff,public',
            'is_published' => 'boolean',
        ]);
        $validated['created_by']  = auth()->id();
        $validated['is_published'] = $request->boolean('is_published', true);
        Event::create($validated);
        return back()->with('success', 'Event created.');
    }

    public function destroyEvent(Event $event)
    {
        $event->delete();
        return back()->with('success', 'Event deleted.');
    }

    // Notifications
    public function notificationsIndex()
    {
        $notifications = Notification::where('user_id', auth()->id())->latest('created_at')->paginate(20);
        // Mark all as read
        Notification::where('user_id', auth()->id())->whereNull('read_at')->update(['read_at' => now()]);
        return view('communication.notifications', compact('notifications'));
    }
}
