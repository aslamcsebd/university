<?php

namespace App\Http\Controllers;

use App\Models\AdmissionApplication;
use App\Models\Payment;
use App\Models\Staff;
use App\Models\Student;
use App\Models\User;
use App\Models\University;
use App\Support\PermissionCatalog;

class DashboardController extends Controller
{
    public function index()
    {
        $visibleCards = collect(config('authorization.dashboard_cards'))
            ->mapWithKeys(fn ($definition, $card) => [$card => PermissionCatalog::canSeeDashboardCard(auth()->user(), $card)])->all();
        $stats = [
            'students' => $visibleCards['students'] ? Student::count() : null,
            'staff' => $visibleCards['staff'] ? Staff::count() : null,
            'admissions' => $visibleCards['admissions'] ? AdmissionApplication::whereNull('reviewed_at')->count() : null,
            'payments' => $visibleCards['payments'] ? Payment::whereDate('paid_at', today())->count() : null,
        ];

        $recentUsers = $visibleCards['recent-users'] ? User::visibleTo(auth()->user())->latest()->take(5)->get() : collect();
        $university = $visibleCards['system-info'] ? University::current() : null;
        $userCount = $visibleCards['system-info'] && auth()->user()->can('view.users') ? User::visibleTo(auth()->user())->count() : null;
        $roleCount = $visibleCards['system-info'] && auth()->user()->can('view.roles') ? \App\Models\Role::visibleTo(auth()->user())->count() : null;

        return view('dashboard.index', compact('stats', 'recentUsers', 'visibleCards', 'university', 'userCount', 'roleCount'));
    }
}
