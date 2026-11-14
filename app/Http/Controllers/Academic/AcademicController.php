<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\Department;
use App\Models\Program;
use App\Models\Course;
use App\Models\AcademicSession;
use App\Models\Campus;

class AcademicController extends Controller
{
    public function index()
    {
        $stats = [
            'faculties'   => Faculty::where('is_active', true)->count(),
            'departments' => Department::where('is_active', true)->count(),
            'programs'    => Program::where('is_active', true)->count(),
            'courses'     => Course::where('is_active', true)->count(),
            'campuses'    => Campus::where('is_active', true)->count(),
            'sessions'    => AcademicSession::count(),
        ];

        $faculties       = Faculty::withCount(['departments', 'programs'])->where('is_active', true)->get();
        $currentSession  = AcademicSession::current();

        return view('academic.index', compact('stats', 'faculties', 'currentSession'));
    }
}
