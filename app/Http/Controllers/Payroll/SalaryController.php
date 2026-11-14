<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Models\SalaryStructure;
use App\Models\Staff;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function index(Request $request)
    {
        $query = Staff::with(['department', 'designation', 'salaryStructure'])
                      ->where('is_active', true);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%'.$request->search.'%')
                  ->orWhere('last_name', 'like', '%'.$request->search.'%')
                  ->orWhere('employee_id', 'like', '%'.$request->search.'%');
            });
        }

        $staff = $query->paginate(20)->withQueryString();
        return view('payroll.salary.index', compact('staff'));
    }

    public function edit(Staff $staff)
    {
        $salary = $staff->salaryStructure ?? new SalaryStructure(['effective_from' => now()->format('Y-m-d')]);
        return view('payroll.salary.edit', compact('staff', 'salary'));
    }

    public function update(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'basic_salary'        => 'required|numeric|min:0',
            'house_allowance'     => 'nullable|numeric|min:0',
            'transport_allowance' => 'nullable|numeric|min:0',
            'medical_allowance'   => 'nullable|numeric|min:0',
            'provident_fund_pct'  => 'nullable|numeric|min:0|max:100',
            'loan_deduction'      => 'nullable|numeric|min:0',
            'effective_from'      => 'required|date',
        ]);

        $validated['house_allowance']     = $validated['house_allowance'] ?? 0;
        $validated['transport_allowance'] = $validated['transport_allowance'] ?? 0;
        $validated['medical_allowance']   = $validated['medical_allowance'] ?? 0;
        $validated['provident_fund_pct']  = $validated['provident_fund_pct'] ?? 0;
        $validated['loan_deduction']      = $validated['loan_deduction'] ?? 0;
        $validated['staff_id']            = $staff->id;

        SalaryStructure::updateOrCreate(
            ['staff_id' => $staff->id],
            $validated
        );

        return redirect()->route('salary.index')->with('success', 'Salary structure saved for '.$staff->full_name);
    }
}
