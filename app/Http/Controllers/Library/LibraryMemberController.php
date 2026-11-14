<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use App\Models\LibraryMember;
use App\Models\Student;
use App\Models\Staff;
use Illuminate\Http\Request;

class LibraryMemberController extends Controller
{
    public function studentMembers(Request $request)
    {
        $members = LibraryMember::where('person_type', 'student')
            ->when($request->search, fn($q) => $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('member_no', 'like', '%' . $request->search . '%'))
            ->latest()->paginate(20)->withQueryString();
        $students = Student::orderBy('first_name')->get();
        return view('library-mgmt.student-members', compact('members', 'students'));
    }

    public function staffMembers(Request $request)
    {
        $members = LibraryMember::where('person_type', 'staff')
            ->when($request->search, fn($q) => $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('member_no', 'like', '%' . $request->search . '%'))
            ->latest()->paginate(20)->withQueryString();
        $staffList = Staff::where('is_active', true)->orderBy('first_name')->get();
        return view('library-mgmt.staff-members', compact('members', 'staffList'));
    }

    public function outsiderMembers(Request $request)
    {
        $members = LibraryMember::where('person_type', 'outsider')
            ->when($request->search, fn($q) => $q->where('name', 'like', '%' . $request->search . '%'))
            ->latest()->paginate(20)->withQueryString();
        return view('library-mgmt.outsider-members', compact('members'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'person_id'   => 'nullable|integer',
            'person_type' => 'required|in:student,staff,outsider',
            'name'        => 'required|string|max:200',
            'email'       => 'nullable|email|max:200',
            'phone'       => 'nullable|string|max:30',
            'valid_until' => 'required|date|after:today',
            'max_books'   => 'required|integer|min:1|max:20',
        ]);
        $data['member_no'] = LibraryMember::generateMemberNo($data['person_type']);
        LibraryMember::create($data);
        return back()->with('success', 'Member added.');
    }

    public function update(Request $request, LibraryMember $member)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:200',
            'email'       => 'nullable|email|max:200',
            'phone'       => 'nullable|string|max:30',
            'valid_until' => 'required|date',
            'max_books'   => 'required|integer|min:1|max:20',
            'is_active'   => 'boolean',
        ]);
        $member->update($data);
        return back()->with('success', 'Member updated.');
    }

    public function destroy(LibraryMember $member)
    {
        if ($member->activeIssues()->exists()) {
            return back()->with('error', 'Member has active book issues.');
        }
        $member->delete();
        return back()->with('success', 'Member removed.');
    }
}
