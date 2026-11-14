<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'students'   => 0,
            'staff'      => 0,
            'admissions' => 0,
            'payments'   => 0,
        ];

        $recentUsers = User::latest()->take(5)->get();

        return view('dashboard.index', compact('stats', 'recentUsers'));
    }
}
