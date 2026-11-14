<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\FeeAssignment;
use App\Models\Income;
use App\Models\Expense;
use App\Models\IncomeCategory;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['student', 'feeAssignment.feeType'])->latest();
        if ($request->filled('search')) {
            $query->whereHas('student', fn($q) => $q->where('first_name','like','%'.$request->search.'%')
                ->orWhere('student_id','like','%'.$request->search.'%'));
        }
        if ($request->filled('method')) { $query->where('payment_method', $request->method); }
        $payments = $query->paginate(20)->withQueryString();
        $totalToday = Payment::whereDate('paid_at', today())->sum('amount');
        return view('finance.payments', compact('payments', 'totalToday'));
    }

    public function create()
    {
        $assignments = FeeAssignment::with(['student', 'feeType'])
            ->whereIn('status', ['pending', 'partial'])
            ->get();
        return view('finance.collect', compact('assignments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fee_assignment_id' => 'required|exists:fee_assignments,id',
            'amount'            => 'required|numeric|min:0.01',
            'payment_method'    => 'required|in:cash,bank_transfer,online,cheque',
            'transaction_ref'   => 'nullable|string|unique:payments,transaction_ref',
        ]);

        $assignment  = FeeAssignment::findOrFail($validated['fee_assignment_id']);
        $outstanding = $assignment->outstanding;

        if ($validated['amount'] > $outstanding) {
            return back()->with('error', "Amount cannot exceed outstanding balance ({$outstanding}).")->withInput();
        }

        $payment = Payment::create([
            'student_id'        => $assignment->student_id,
            'fee_assignment_id' => $assignment->id,
            'amount'            => $validated['amount'],
            'payment_method'    => $validated['payment_method'],
            'transaction_ref'   => $validated['transaction_ref'],
            'received_by'       => auth()->id(),
            'paid_at'           => now(),
            'receipt_no'        => Payment::generateReceiptNo(),
        ]);

        $assignment->recalculate();

        return redirect()->route('payments.index')->with('success', "Payment collected. Receipt: {$payment->receipt_no}");
    }

    // Income & Expense
    public function overviewIndex()
    {
        $incomeCategories  = IncomeCategory::withCount('incomes')->get();
        $expenseCategories = ExpenseCategory::withCount('expenses')->get();
        $totalIncome       = Income::whereMonth('date', now()->month)->sum('amount');
        $totalExpense      = Expense::whereMonth('date', now()->month)->sum('amount');
        $recentIncomes     = Income::with('category')->latest()->take(5)->get();
        $recentExpenses    = Expense::with('category')->latest()->take(5)->get();
        return view('finance.overview', compact('incomeCategories','expenseCategories','totalIncome','totalExpense','recentIncomes','recentExpenses'));
    }

    public function incomeIndex(Request $request)
    {
        $incomes     = Income::with('category')->latest()->paginate(20)->withQueryString();
        $categories  = IncomeCategory::orderBy('name')->get();
        return view('finance.incomes', compact('incomes', 'categories'));
    }

    public function storeIncome(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:income_categories,id',
            'title'       => 'required|string|max:255',
            'amount'      => 'required|numeric|min:0.01',
            'date'        => 'required|date',
            'reference'   => 'nullable|string',
            'notes'       => 'nullable|string',
        ]);
        $validated['created_by'] = auth()->id();
        Income::create($validated);
        return back()->with('success', 'Income recorded.');
    }

    public function expenseIndex(Request $request)
    {
        $expenses    = Expense::with('category')->latest()->paginate(20)->withQueryString();
        $categories  = ExpenseCategory::orderBy('name')->get();
        return view('finance.expenses', compact('expenses', 'categories'));
    }

    public function storeExpense(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:expense_categories,id',
            'title'       => 'required|string|max:255',
            'amount'      => 'required|numeric|min:0.01',
            'date'        => 'required|date',
            'reference'   => 'nullable|string',
            'notes'       => 'nullable|string',
        ]);
        $validated['created_by'] = auth()->id();
        Expense::create($validated);
        return back()->with('success', 'Expense recorded.');
    }

    public function storeCategoryIncome(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100|unique:income_categories,name']);
        IncomeCategory::create(['name' => $request->name]);
        return back()->with('success', 'Category added.');
    }

    public function storeCategoryExpense(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100|unique:expense_categories,name']);
        ExpenseCategory::create(['name' => $request->name]);
        return back()->with('success', 'Category added.');
    }
}
