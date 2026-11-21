<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ProjectStatus extends Command
{
    protected $signature = 'ums:status';
    protected $description = 'Show UMS project phase completion status';

    public function handle(): void
    {
        $this->newLine();
        $this->line('  <fg=blue;options=bold>╔══════════════════════════════════════════════════════════════╗</>');
        $this->line('  <fg=blue;options=bold>║        University Management System — Build Status           ║</>');
        $this->line('  <fg=blue;options=bold>╚══════════════════════════════════════════════════════════════╝</>');
        $this->newLine();

        $phases = [
            [
                'phase'   => 'Phase 1',
                'title'   => 'Core Foundation',
                'done'    => true,
                'modules' => [
                    ['Auth & Authorization',      $this->tableExists('users') && $this->tableExists('login_audits')],
                    ['User Management',           $this->classExists('App\Http\Controllers\Users\UserController')],
                    ['Roles & Permissions',       $this->tableExists('roles') && $this->tableExists('permissions')],
                    ['University Configuration',  $this->tableExists('universities')],
                    ['System Settings',           $this->tableExists('settings')],
                    ['Audit Logging',             $this->tableExists('activity_log')],
                ],
            ],
            [
                'phase'   => 'Phase 2',
                'title'   => 'University Structure',
                'done'    => true,
                'modules' => [
                    ['Campus Management',         $this->tableExists('campuses') && $this->viewExists('academic/campuses/index')],
                    ['Faculty Management',        $this->tableExists('faculties') && $this->viewExists('academic/faculties/index')],
                    ['Department Management',     $this->tableExists('departments') && $this->viewExists('academic/departments/index')],
                    ['Academic Sessions',         $this->tableExists('academic_sessions') && $this->viewExists('academic/sessions/index')],
                    ['Program Management',        $this->tableExists('programs') && $this->viewExists('academic/programs/index')],
                    ['Course Management',         $this->tableExists('courses') && $this->viewExists('academic/courses/index')],
                    ['Buildings & Rooms',         $this->tableExists('buildings') && $this->tableExists('rooms')],
                    ['Batches & Sections',        $this->tableExists('batches') && $this->tableExists('sections')],
                ],
            ],
            [
                'phase'   => 'Phase 3',
                'title'   => 'HR, Teachers & Payroll',
                'done'    => false,
                'modules' => [
                    ['HR / Staff Management',     $this->tableExists('staff')],
                    ['Designations & Shifts',     $this->tableExists('designations')],
                    ['Leave Management',          $this->tableExists('leave_applications')],
                    ['Teacher Management',        $this->classExists('App\Http\Controllers\HR\TeacherController')],
                    ['Payroll Management',        $this->tableExists('payrolls')],
                    ['Salary Structures',         $this->tableExists('salary_structures')],
                ],
            ],
            [
                'phase'   => 'Phase 4',
                'title'   => 'Admission & Students',
                'done'    => false,
                'modules' => [
                    ['Admission Management',      $this->tableExists('admission_applications')],
                    ['Student Management',        $this->tableExists('students')],
                    ['Student Enrollment',        $this->tableExists('student_enrollments')],
                ],
            ],
            [
                'phase'   => 'Phase 5',
                'title'   => 'Academic Operations',
                'done'    => false,
                'modules' => [
                    ['Grading System',            $this->tableExists('grading_systems')],
                    ['Class Scheduling',          $this->tableExists('class_schedules')],
                    ['Exam Timetable',            $this->tableExists('exam_schedules')],
                    ['Attendance Management',     $this->tableExists('student_attendances')],
                    ['Examination & Marks',       $this->tableExists('student_marks')],
                    ['Result Management',         $this->tableExists('student_results')],
                ],
            ],
            [
                'phase'   => 'Phase 6',
                'title'   => 'Finance',
                'done'    => false,
                'modules' => [
                    ['Fee Management',            $this->tableExists('fee_assignments')],
                    ['Payment Management',        $this->tableExists('payments')],
                    ['Scholarship Management',    $this->tableExists('scholarships')],
                ],
            ],
            [
                'phase'   => 'Phase 7',
                'title'   => 'University Services',
                'done'    => false,
                'modules' => [
                    ['Library Management',        $this->tableExists('books')],
                    ['Hostel Management',         $this->tableExists('hostels')],
                    ['Transport Management',      $this->tableExists('vehicles')],
                    ['Inventory Management',      $this->tableExists('items')],
                    ['Study Materials',           $this->tableExists('study_contents')],
                ],
            ],
            [
                'phase'   => 'Phase 8',
                'title'   => 'Communication & Admin',
                'done'    => false,
                'modules' => [
                    ['Notifications',             $this->tableExists('notifications')],
                    ['Communication',             $this->tableExists('notices')],
                    ['Front Desk',                $this->tableExists('visitor_logs')],
                    ['Transcripts & Certs',       $this->tableExists('document_generations')],
                    ['Reporting & Analytics',     $this->classExists('App\Http\Controllers\Reports\ReportController')],
                    ['Front Website CMS',         $this->tableExists('sliders')],
                ],
            ],
        ];

        $totalModules = 0;
        $doneModules  = 0;

        foreach ($phases as $phase) {
            $phaseDone  = collect($phase['modules'])->every(fn($m) => $m[1]);
            $phaseCount = count($phase['modules']);
            $phaseDoneCount = collect($phase['modules'])->filter(fn($m) => $m[1])->count();

            $totalModules += $phaseCount;
            $doneModules  += $phaseDoneCount;

            $statusIcon  = $phaseDone ? '<fg=green>✅</>' : ($phaseDoneCount > 0 ? '<fg=yellow>🔄</>' : '<fg=gray>⏳</>');
            $statusLabel = $phaseDone ? '<fg=green>DONE</>'  : ($phaseDoneCount > 0 ? '<fg=yellow>IN PROGRESS</>' : '<fg=gray>PENDING</>');
            $bar         = $this->progressBar($phaseDoneCount, $phaseCount);

            $this->line("  {$statusIcon}  <options=bold>{$phase['phase']}</> — {$phase['title']}  {$statusLabel}  {$bar} {$phaseDoneCount}/{$phaseCount}");

            foreach ($phase['modules'] as [$name, $done]) {
                $icon = $done ? '<fg=green>  ✓</>' : '<fg=gray>  ○</>';
                $color = $done ? 'white' : 'gray';
                $this->line("      {$icon}  <fg={$color}>{$name}</>");
            }
            $this->newLine();
        }

        // Summary
        $pct = round(($doneModules / $totalModules) * 100);
        $overallBar = $this->progressBar($doneModules, $totalModules, 40);
        $this->line('  <options=bold>Overall Progress</>');
        $this->line("  {$overallBar}  <fg=blue;options=bold>{$pct}%</> ({$doneModules}/{$totalModules} modules)");
        $this->newLine();

        // DB Stats
        $this->line('  <fg=blue>Database Stats</>');
        $stats = [
            'Users'       => \App\Models\User::count(),
            'Roles'       => \App\Models\Role::count(),
            'Permissions' => \App\Models\Permission::count(),
            'Faculties'   => $this->safeCount('faculties'),
            'Departments' => $this->safeCount('departments'),
            'Programs'    => $this->safeCount('programs'),
            'Courses'     => $this->safeCount('courses'),
            'Campuses'    => $this->safeCount('campuses'),
        ];
        foreach ($stats as $label => $count) {
            $this->line("  <fg=gray>  {$label}:</> <fg=white>{$count}</>");
        }
        $this->newLine();
    }

    private function tableExists(string $table): bool
    {
        try {
            return \Illuminate\Support\Facades\Schema::hasTable($table);
        } catch (\Exception $e) {
            return false;
        }
    }

    private function classExists(string $class): bool
    {
        return class_exists($class);
    }

    private function viewExists(string $view): bool
    {
        return file_exists(resource_path('views/' . $view . '.blade.php'));
    }

    private function safeCount(string $table): int
    {
        try {
            return \Illuminate\Support\Facades\DB::table($table)->count();
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function progressBar(int $done, int $total, int $width = 20): string
    {
        $pct   = $total > 0 ? round(($done / $total) * $width) : 0;
        $empty = $width - $pct;
        $bar   = str_repeat('█', $pct) . str_repeat('░', $empty);
        return $pct === $width
            ? "<fg=green>{$bar}</>"
            : ($pct > 0 ? "<fg=yellow>{$bar}</>" : "<fg=gray>{$bar}</>");
    }
}
