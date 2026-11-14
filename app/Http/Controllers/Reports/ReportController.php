<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Staff;
use App\Models\Payment;
use App\Models\Income;
use App\Models\Expense;
use App\Models\BookIssue;
use App\Models\StudentAttendance;
use App\Models\LeaveApplication;
use App\Models\Payroll;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // Dashboard summary stats
        $stats = [
            'total_students'   => Student::where('status', 'active')->count(),
            'total_staff'      => Staff::where('is_active', true)->count(),
            'fees_this_month'  => Payment::whereMonth('paid_at', now()->month)->sum('amount'),
            'expenses_month'   => Expense::whereMonth('date', now()->month)->sum('amount'),
            'overdue_books'    => BookIssue::where('status', 'overdue')->count(),
            'pending_leaves'   => LeaveApplication::where('status', 'pending')->count(),
        ];
        return view('reports.index', compact('stats'));
    }

    public function students(Request $request)
    {
        $query = Student::with(['program', 'batch'])->latest();
        if ($request->filled('status'))  { $query->where('status', $request->status); }
        if ($request->filled('program')) { $query->where('program_id', $request->program); }
        $students = $query->paginate(20)->withQueryString();
        $programs = \App\Models\Program::where('is_active', true)->orderBy('name')->get();
        return view('reports.students', compact('students', 'programs'));
    }

    public function fees(Request $request)
    {
        $query = Payment::with(['student', 'feeAssignment.feeType'])->latest();
        if ($request->filled('date_from')) { $query->whereDate('paid_at', '>=', $request->date_from); }
        if ($request->filled('date_to'))   { $query->whereDate('paid_at', '<=', $request->date_to); }
        $payments = $query->paginate(20)->withQueryString();
        $total    = $query->sum('amount');
        return view('reports.fees', compact('payments', 'total'));
    }

    public function salary(Request $request)
    {
        $month    = $request->get('month', now()->month);
        $year     = $request->get('year', now()->year);
        $payrolls = Payroll::with(['staff.department'])->where('month', $month)->where('year', $year)->paginate(20);
        $total    = $payrolls->sum('net_salary');
        return view('reports.salary', compact('payrolls', 'total', 'month', 'year'));
    }

    public function finance(Request $request)
    {
        $month    = $request->get('month', now()->month);
        $year     = $request->get('year', now()->year);
        $incomes  = Income::with('category')->whereMonth('date', $month)->whereYear('date', $year)->get();
        $expenses = Expense::with('category')->whereMonth('date', $month)->whereYear('date', $year)->get();
        $totalIncome  = $incomes->sum('amount');
        $totalExpense = $expenses->sum('amount');
        return view('reports.finance', compact('incomes', 'expenses', 'totalIncome', 'totalExpense', 'month', 'year'));
    }

    public function library(Request $request)
    {
        $issues = BookIssue::with(['book', 'member'])
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->status))
            ->latest()->paginate(20)->withQueryString();
        return view('reports.library', compact('issues'));
    }
}
