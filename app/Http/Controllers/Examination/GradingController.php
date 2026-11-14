<?php

namespace App\Http\Controllers\Examination;

use App\Http\Controllers\Controller;
use App\Models\GradingSystem;
use App\Models\GradeRule;
use Illuminate\Http\Request;

class GradingController extends Controller
{
    public function index()
    {
        $systems = GradingSystem::withCount('gradeRules')->orderByDesc('is_default')->get();
        return view('grading.index', compact('systems'));
    }

    public function create() { return view('grading.create'); }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100|unique:grading_systems,name',
            'description' => 'nullable|string',
            'max_gpa'     => 'required|numeric|min:1|max:5',
            'is_default'  => 'boolean',
        ]);
        if ($request->boolean('is_default')) {
            GradingSystem::query()->update(['is_default' => false]);
        }
        $validated['is_default'] = $request->boolean('is_default');
        $system = GradingSystem::create($validated);
        return redirect()->route('grading.edit', $system)->with('success', 'Grading system created. Now add grade rules.');
    }

    public function edit(GradingSystem $grading)
    {
        $grading->load('gradeRules');
        return view('grading.edit', compact('grading'));
    }

    public function update(Request $request, GradingSystem $grading)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100|unique:grading_systems,name,'.$grading->id,
            'description' => 'nullable|string',
            'max_gpa'     => 'required|numeric|min:1|max:5',
            'is_default'  => 'boolean',
        ]);
        if ($request->boolean('is_default')) {
            GradingSystem::where('id', '!=', $grading->id)->update(['is_default' => false]);
        }
        $validated['is_default'] = $request->boolean('is_default');
        $grading->update($validated);
        return back()->with('success', 'Grading system updated.');
    }

    public function destroy(GradingSystem $grading)
    {
        if (StudentResult::where('grade_rule_id', function($q) use ($grading) {
            $q->select('id')->from('grade_rules')->where('grading_system_id', $grading->id);
        })->exists()) {
            return back()->with('error', 'Cannot delete grading system with processed results.');
        }
        $grading->delete();
        return redirect()->route('grading.index')->with('success', 'Grading system deleted.');
    }

    public function seedDefault(GradingSystem $grading)
    {
        $defaultRules = [
            ['letter_grade'=>'A+','min_percentage'=>90,'max_percentage'=>100,'gpa_point'=>4.00,'is_pass'=>true,'sort_order'=>1],
            ['letter_grade'=>'A', 'min_percentage'=>80,'max_percentage'=>89.99,'gpa_point'=>3.70,'is_pass'=>true,'sort_order'=>2],
            ['letter_grade'=>'B+','min_percentage'=>75,'max_percentage'=>79.99,'gpa_point'=>3.30,'is_pass'=>true,'sort_order'=>3],
            ['letter_grade'=>'B', 'min_percentage'=>70,'max_percentage'=>74.99,'gpa_point'=>3.00,'is_pass'=>true,'sort_order'=>4],
            ['letter_grade'=>'C+','min_percentage'=>65,'max_percentage'=>69.99,'gpa_point'=>2.70,'is_pass'=>true,'sort_order'=>5],
            ['letter_grade'=>'C', 'min_percentage'=>60,'max_percentage'=>64.99,'gpa_point'=>2.30,'is_pass'=>true,'sort_order'=>6],
            ['letter_grade'=>'D', 'min_percentage'=>50,'max_percentage'=>59.99,'gpa_point'=>2.00,'is_pass'=>true,'sort_order'=>7],
            ['letter_grade'=>'F', 'min_percentage'=>0, 'max_percentage'=>49.99,'gpa_point'=>0.00,'is_pass'=>false,'sort_order'=>8],
        ];
        foreach ($defaultRules as $rule) {
            GradeRule::firstOrCreate(
                ['grading_system_id' => $grading->id, 'letter_grade' => $rule['letter_grade']],
                array_merge($rule, ['grading_system_id' => $grading->id])
            );
        }
        return back()->with('success', 'Standard 4.0 scale applied.');
    }
    public function storeRule(Request $request, GradingSystem $grading)
    {
        $validated = $request->validate([
            'letter_grade'   => 'required|string|max:5',
            'min_percentage' => 'required|numeric|min:0|max:100',
            'max_percentage' => 'required|numeric|min:0|max:100|gte:min_percentage',
            'gpa_point'      => 'required|numeric|min:0|max:5',
            'is_pass'        => 'boolean',
            'sort_order'     => 'nullable|integer',
        ]);
        $validated['grading_system_id'] = $grading->id;
        $validated['is_pass']           = $request->boolean('is_pass', true);
        $validated['sort_order']        = $validated['sort_order'] ?? GradeRule::where('grading_system_id', $grading->id)->max('sort_order') + 1;
        GradeRule::create($validated);
        return back()->with('success', 'Grade rule added.');
    }

    public function destroyRule(GradingSystem $grading, GradeRule $rule)
    {
        $rule->delete();
        return back()->with('success', 'Grade rule removed.');
    }
}
