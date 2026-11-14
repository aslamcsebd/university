<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\FeeType;
use App\Models\FeeAssignment;
use App\Models\Student;
use App\Models\Semester;
use App\Models\Batch;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    // Fee Types
    public function typesIndex()
    {
        $feeTypes = FeeType::withCount('assignments')->orderBy('name')->get();
        return view('finance.fee-types', compact('feeTypes'));
    }

    public function storeType(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100|unique:fee_types,name',
            'description' => 'nullable|string',
            'frequency'   => 'required|in:one_time,monthly,semester,annual',
        ]);
        FeeType::create($validated);
        return back()->with('success', 'Fee type added.');
    }

    public function updateType(Request $request, FeeType $feeType)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:100|unique:fee_types,name,'.$feeType->id,
            'frequency' => 'required|in:one_time,monthly,semester,annual',
        ]);
        $feeType->update($validated);
        return back()->with('success', 'Fee type updated.');
    }

    public function destroyType(FeeType $feeType)
    {
        if ($feeType->assignments()->count()) {
            return back()->with('error', 'Cannot delete fee type with existing assignments.');
        }
        $feeType->delete();
        return back()->with('success', 'Fee type deleted.');
    }

    // Fee Assignments
    public function assignmentsIndex(Request $request)
    {
        $query = FeeAssignment::with(['student', 'feeType', 'semester'])->latest();
        if ($request->filled('status'))   { $query->where('status', $request->status); }
        if ($request->filled('fee_type')) { $query->where('fee_type_id', $request->fee_type); }
        if ($request->filled('search'))   {
            $query->whereHas('student', fn($q) => $q->where('first_name','like','%'.$request->search.'%')
                ->orWhere('last_name','like','%'.$request->search.'%')
                ->orWhere('student_id','like','%'.$request->search.'%'));
        }
        $assignments = $query->paginate(20)->withQueryString();
        $feeTypes    = FeeType::where('is_active', true)->get();
        return view('finance.assignments', compact('assignments', 'feeTypes'));
    }

    public function createAssignment()
    {
        $students  = Student::active()->with('program')->orderBy('first_name')->get();
        $feeTypes  = FeeType::where('is_active', true)->orderBy('name')->get();
        $semesters = Semester::with('academicSession')->orderByDesc('created_at')->get();
        return view('finance.assign', compact('students', 'feeTypes', 'semesters'));
    }

    public function storeAssignment(Request $request)
    {
        $validated = $request->validate([
            'student_id'  => 'required|exists:students,id',
            'fee_type_id' => 'required|exists:fee_types,id',
            'semester_id' => 'nullable|exists:semesters,id',
            'amount'      => 'required|numeric|min:0',
            'due_date'    => 'nullable|date',
            'notes'       => 'nullable|string',
        ]);
        $validated['net_amount'] = $validated['amount'];
        $assignment = FeeAssignment::create($validated);
        return redirect()->route('fee-assignments.index')->with('success', 'Fee assigned to student.');
    }

    public function bulkAssign(Request $request)
    {
        $request->validate([
            'batch_id'    => 'required|exists:batches,id',
            'fee_type_id' => 'required|exists:fee_types,id',
            'semester_id' => 'nullable|exists:semesters,id',
            'amount'      => 'required|numeric|min:0',
            'due_date'    => 'nullable|date',
        ]);

        $students = Student::where('batch_id', $request->batch_id)->where('status', 'active')->get();
        $assigned = 0;
        foreach ($students as $student) {
            FeeAssignment::firstOrCreate(
                ['student_id' => $student->id, 'fee_type_id' => $request->fee_type_id, 'semester_id' => $request->semester_id],
                ['amount' => $request->amount, 'net_amount' => $request->amount, 'due_date' => $request->due_date]
            ) ? $assigned++ : null;
        }
        return redirect()->route('fee-assignments.index')->with('success', "Assigned fee to {$assigned} students.");
    }

    public function waive(Request $request, FeeAssignment $assignment)
    {
        $request->validate(['notes' => 'nullable|string']);
        $assignment->update(['status' => 'waived', 'notes' => $request->notes]);
        return back()->with('success', 'Fee waived.');
    }

    public function dueIndex(Request $request)
    {
        $assignments = FeeAssignment::with(['student', 'feeType'])
            ->whereIn('status', ['pending', 'partial'])
            ->where('due_date', '<', now())
            ->orderBy('due_date')
            ->paginate(20)->withQueryString();
        return view('finance.due', compact('assignments'));
    }
}
