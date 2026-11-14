<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\ItemIssue;
use App\Models\ItemReturn;
use Illuminate\Http\Request;

class ItemIssueController extends Controller
{
    public function issueIndex(Request $request)
    {
        $items  = Item::where('quantity', '>', 0)->orderBy('name')->get();
        $recent = ItemIssue::with('item')->latest()->take(10)->get();
        return view('inventory.issue-item', compact('items', 'recent'));
    }

    public function issue(Request $request)
    {
        $data = $request->validate([
            'item_id'              => 'required|exists:items,id',
            'quantity'             => 'required|numeric|min:0.01',
            'issued_to_id'         => 'nullable|integer',
            'issued_to_type'       => 'nullable|in:staff,student,dept',
            'purpose'              => 'nullable|string|max:500',
            'expected_return_date' => 'nullable|date|after:today',
        ]);

        $item = Item::findOrFail($data['item_id']);
        if ($item->quantity < $data['quantity']) {
            return back()->with('error', "Insufficient stock. Available: {$item->quantity} {$item->unit}");
        }

        $data['issued_by'] = auth()->id();
        $data['issued_at'] = now();
        ItemIssue::create($data);
        $item->decrement('quantity', $data['quantity']);
        return back()->with('success', 'Item issued.');
    }

    public function returnIndex(Request $request)
    {
        $issues = ItemIssue::with('item')
            ->when($request->search, fn($q) => $q->whereHas('item', fn($i) => $i->where('name', 'like', '%' . $request->search . '%')))
            ->latest()->paginate(20)->withQueryString();
        return view('inventory.issue-return', compact('issues'));
    }

    public function processReturn(Request $request, ItemIssue $issue)
    {
        $data = $request->validate([
            'quantity_returned' => 'required|numeric|min:0.01|max:' . $issue->quantity,
            'condition'         => 'nullable|string|max:50',
        ]);
        $data['item_issue_id'] = $issue->id;
        $data['returned_at']   = now();
        $data['received_by']   = auth()->id();

        ItemReturn::create($data);
        $issue->item->increment('quantity', $data['quantity_returned']);
        return back()->with('success', 'Return processed.');
    }
}
