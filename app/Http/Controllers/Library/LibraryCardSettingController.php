<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use App\Models\LibrarySetting;
use Illuminate\Http\Request;

class LibraryCardSettingController extends Controller
{
    public function index()
    {
        $setting = LibrarySetting::current();
        return view('library-mgmt.card-setting', compact('setting'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'student_issue_days' => 'required|integer|min:1|max:365',
            'staff_issue_days'   => 'required|integer|min:1|max:365',
            'max_books_student'  => 'required|integer|min:1|max:20',
            'max_books_staff'    => 'required|integer|min:1|max:20',
            'fine_per_day'       => 'required|numeric|min:0',
            'max_fine_per_book'  => 'required|numeric|min:0',
        ]);
        LibrarySetting::current()->update($data);
        return back()->with('success', 'Library settings updated.');
    }
}
