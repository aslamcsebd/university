<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use App\Models\Staff;
use App\Models\SalaryStructure;
use App\Models\TaxSetting;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year  = $request->get('year',  now()->year);

        $query = Payroll::with(['staff.department', 'staff.designation'])
                        ->where('month', $month)->where('year', $year);

        if ($request->filled('status')) { $query->where('status', $request->status); }

        $payrolls = $query->paginate(20)->withQueryString();
        $months   = range(1, 12);
        $years    = range(now()->year - 2, now()->year + 1);

        return view('payroll.index', compact('payrolls', 'month', 'year', 'months', 'years'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'month' => 'required|integer|between:1,12',
            'year'  => 'required|integer|min:2020',
        ]);

        $month    = $request->month;
        $year     = $request->year;
        $tax      = TaxSetting::where('is_default', true)->first();
        $staff    = Staff::with('salaryStructure')->where('is_active', true)->get();
        $generated = 0;
        $skipped   = 0;

        foreach ($staff as $member) {
            // Skip if already generated
            if (Payroll::where('staff_id', $member->id)->where('month', $month)->where('year', $year)->exists()) {
                $skipped++;
                continue;
            }

            $salary = $member->salaryStructure;
            if (!$salary) { $skipped++; continue; }

            $gross = $salary->grossSalary();
            $taxAmount = $tax ? $tax->calculateMonthlyTax($gross) : 0;
            $pf        = round($gross * ($salary->provident_fund_pct / 100), 2);
            $netSalary = $gross - $taxAmount - $pf - $salary->loan_deduction;

            Payroll::create([
                'staff_id'     => $member->id,
                'month'        => $month,
                'year'         => $year,
                'basic'        => $salary->basic_salary,
                'gross'        => $gross,
                'allowances'   => [
                    'house'     => $salary->house_allowance,
                    'transport' => $salary->transport_allowance,
                    'medical'   => $salary->medical_allowance,
                ],
                'deductions'   => [
                    'tax' => $taxAmount,
                    'pf'  => $pf,
                    'loan'=> $salary->loan_deduction,
                ],
                'tax'          => $taxAmount,
                'net_salary'   => max(0, $netSalary),
                'working_days' => 26,
                'status'       => 'draft',
                'generated_by' => auth()->id(),
            ]);
            $generated++;
        }

        return redirect()->route('payroll.index', ['month' => $month, 'year' => $year])
            ->with('success', "Generated {$generated} payrolls. Skipped {$skipped} (already exist or no salary structure).");
    }

    public function approve(Payroll $payroll)
    {
        if ($payroll->status !== 'draft') {
            return back()->with('error', 'Only draft payrolls can be approved.');
        }
        $payroll->update(['status' => 'approved', 'approved_by' => auth()->id()]);
        return back()->with('success', 'Payroll approved.');
    }

    public function markPaid(Payroll $payroll)
    {
        if ($payroll->status !== 'approved') {
            return back()->with('error', 'Only approved payrolls can be marked as paid.');
        }
        $payroll->update(['status' => 'paid', 'paid_at' => now()]);
        return back()->with('success', 'Payroll marked as paid.');
    }

    public function destroy(Payroll $payroll)
    {
        if ($payroll->status !== 'draft') {
            return back()->with('error', 'Only draft payrolls can be deleted.');
        }
        $payroll->delete();
        return back()->with('success', 'Payroll deleted.');
    }
}
