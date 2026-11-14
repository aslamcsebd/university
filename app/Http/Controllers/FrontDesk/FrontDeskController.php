<?php

namespace App\Http\Controllers\FrontDesk;

use App\Http\Controllers\Controller;
use App\Models\VisitorLog;
use App\Models\VisitPurpose;
use App\Models\Enquiry;
use App\Models\EnquirySource;
use App\Models\Complaint;
use App\Models\ComplaintType;
use App\Models\Program;
use Illuminate\Http\Request;

class FrontDeskController extends Controller
{
    // Visitors
    public function visitorsIndex(Request $request)
    {
        $visitors = VisitorLog::with('purpose')->latest('check_in')->paginate(20)->withQueryString();
        $purposes = VisitPurpose::orderBy('name')->get();
        return view('frontdesk.visitors', compact('visitors', 'purposes'));
    }

    public function storeVisitor(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'phone'      => 'nullable|string|max:30',
            'purpose_id' => 'nullable|exists:visit_purposes,id',
            'notes'      => 'nullable|string',
        ]);
        $validated['check_in'] = now();
        VisitorLog::create($validated);
        return back()->with('success', 'Visitor logged.');
    }

    public function checkoutVisitor(VisitorLog $visitor)
    {
        $visitor->update(['check_out' => now()]);
        return back()->with('success', 'Visitor checked out.');
    }

    public function storePurpose(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100|unique:visit_purposes,name']);
        VisitPurpose::create(['name' => $request->name]);
        return back()->with('success', 'Purpose added.');
    }

    // Enquiries
    public function enquiriesIndex(Request $request)
    {
        $query = Enquiry::with(['program', 'source'])->latest();
        if ($request->filled('status')) { $query->where('status', $request->status); }
        $enquiries = $query->paginate(20)->withQueryString();
        $sources   = EnquirySource::orderBy('name')->get();
        $programs  = Program::where('is_active', true)->orderBy('name')->get();
        return view('frontdesk.enquiries', compact('enquiries', 'sources', 'programs'));
    }

    public function storeEnquiry(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'phone'      => 'nullable|string|max:30',
            'email'      => 'nullable|email',
            'program_id' => 'nullable|exists:programs,id',
            'source_id'  => 'nullable|exists:enquiry_sources,id',
            'notes'      => 'nullable|string',
        ]);
        Enquiry::create($validated);
        return back()->with('success', 'Enquiry logged.');
    }

    public function updateEnquiryStatus(Request $request, Enquiry $enquiry)
    {
        $request->validate(['status' => 'required|in:new,in_progress,converted,closed']);
        $enquiry->update(['status' => $request->status]);
        return back()->with('success', 'Enquiry status updated.');
    }

    public function storeSource(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100|unique:enquiry_sources,name']);
        EnquirySource::create(['name' => $request->name]);
        return back()->with('success', 'Source added.');
    }

    // Complaints
    public function complaintsIndex(Request $request)
    {
        $query = Complaint::with('type')->latest();
        if ($request->filled('status')) { $query->where('status', $request->status); }
        $complaints = $query->paginate(20)->withQueryString();
        $types      = ComplaintType::orderBy('name')->get();
        return view('frontdesk.complaints', compact('complaints', 'types'));
    }

    public function storeComplaint(Request $request)
    {
        $validated = $request->validate([
            'complainant_name' => 'required|string|max:255',
            'phone'            => 'nullable|string|max:30',
            'type_id'          => 'nullable|exists:complaint_types,id',
            'description'      => 'required|string',
        ]);
        Complaint::create($validated);
        return back()->with('success', 'Complaint logged.');
    }

    public function updateComplaintStatus(Request $request, Complaint $complaint)
    {
        $request->validate(['status' => 'required|in:open,in_progress,resolved,closed', 'resolution_notes' => 'nullable|string']);
        $complaint->update(['status' => $request->status, 'resolution_notes' => $request->resolution_notes]);
        return back()->with('success', 'Complaint status updated.');
    }

    public function storeComplaintType(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100|unique:complaint_types,name']);
        ComplaintType::create(['name' => $request->name]);
        return back()->with('success', 'Type added.');
    }
}
