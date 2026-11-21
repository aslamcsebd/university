<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Support\PermissionCatalog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CustomAuthorizationSeeder extends Seeder
{
    public function run(): void
    {
        PermissionCatalog::register();
        $defaults = [
            'student_manager' => ['collect.fees', 'create.academic', 'create.enrollments', 'create.finance', 'create.grading', 'create.marks', 'create.payments', 'create.schedules', 'create.students', 'create.study-materials', 'delete.academic', 'delete.grading', 'delete.schedules', 'delete.students', 'delete.study-materials', 'edit.academic', 'edit.grading', 'edit.students', 'generate.transcripts', 'manage.academic', 'manage.attendance', 'manage.enrollments', 'manage.finance', 'manage.grading', 'manage.schedules', 'manage.staff-attendance', 'manage.student-attendance', 'manage.study-materials', 'view.academic', 'view.attendance', 'view.enrollments', 'view.fees', 'view.finance', 'view.grading', 'view.marks', 'view.payments', 'view.reports', 'view.results', 'view.schedules', 'view.staff-attendance', 'view.student-attendance', 'view.students', 'view.study-materials', 'view.transcripts'],
            'admission_manager' => ['assign.fees', 'collect.fees', 'convert.admissions', 'create.admissions', 'create.fees', 'create.finance', 'create.payments', 'create.students', 'delete.admissions', 'delete.fees', 'edit.admissions', 'edit.fees', 'edit.students', 'manage.fees', 'manage.finance', 'view.academic', 'view.admissions', 'view.enrollments', 'view.fees', 'view.finance', 'view.grading', 'view.payments', 'view.reports', 'view.schedules', 'view.students'],
            'accounting_manager' => ['apply.scholarships', 'approve.payroll', 'approve.scholarships', 'assign.fees', 'collect.fees', 'create.fees', 'create.finance', 'create.payments', 'create.scholarships', 'delete.fees', 'delete.payroll', 'delete.scholarships', 'edit.fees', 'export.reports', 'generate.payroll', 'manage.fees', 'manage.finance', 'manage.scholarships', 'pay.payroll', 'view.fees', 'view.finance', 'view.payments', 'view.payroll', 'view.reports', 'view.scholarships', 'view.students'],
            'examination_manager' => ['create.exams', 'create.grading', 'create.marks', 'create.schedules', 'delete.exams', 'delete.grading', 'delete.schedules', 'edit.grading', 'export.reports', 'generate.transcripts', 'manage.attendance', 'manage.exams', 'manage.grading', 'manage.schedules', 'manage.staff-attendance', 'manage.student-attendance', 'process.results', 'publish.exams', 'publish.marks', 'publish.results', 'view.academic', 'view.attendance', 'view.enrollments', 'view.exams', 'view.grading', 'view.marks', 'view.reports', 'view.results', 'view.schedules', 'view.staff-attendance', 'view.student-attendance', 'view.students', 'view.transcripts'],
            'library_manager' => ['create.library', 'delete.library', 'issue.library', 'manage.library', 'return.library', 'view.library', 'view.reports', 'view.students'],
            'academic_admin' => ['create.academic', 'create.enrollments', 'create.exams', 'create.grading', 'create.marks', 'create.schedules', 'create.students', 'delete.academic', 'delete.exams', 'delete.grading', 'delete.schedules', 'edit.academic', 'edit.grading', 'edit.students', 'manage.academic', 'manage.attendance', 'manage.enrollments', 'manage.exams', 'manage.grading', 'manage.schedules', 'manage.staff-attendance', 'manage.student-attendance', 'process.results', 'publish.exams', 'publish.marks', 'publish.results', 'view.academic', 'view.attendance', 'view.enrollments', 'view.exams', 'view.grading', 'view.marks', 'view.results', 'view.schedules', 'view.staff-attendance', 'view.student-attendance', 'view.students'],
            'finance_admin' => ['apply.scholarships', 'approve.payroll', 'approve.scholarships', 'assign.fees', 'collect.fees', 'create.fees', 'create.finance', 'create.payments', 'create.scholarships', 'delete.fees', 'delete.payroll', 'delete.scholarships', 'edit.fees', 'export.reports', 'generate.payroll', 'manage.fees', 'manage.finance', 'manage.scholarships', 'pay.payroll', 'view.fees', 'view.finance', 'view.payments', 'view.payroll', 'view.reports', 'view.scholarships'],
            'hr_admin' => ['approve.hr', 'create.hr', 'create.staff', 'delete.hr', 'delete.payroll', 'delete.staff', 'edit.hr', 'edit.salary', 'edit.staff', 'generate.payroll', 'manage.hr', 'manage.salary', 'view.hr', 'view.payroll', 'view.salary', 'view.staff'],
            'librarian' => ['create.library', 'delete.library', 'issue.library', 'manage.library', 'return.library', 'view.library'],
            'hostel_admin' => ['allocate.hostel', 'create.hostel', 'manage.hostel', 'vacate.hostel', 'view.hostel'],
            'transport_admin' => ['allocate.transport', 'create.transport', 'deallocate.transport', 'manage.transport', 'view.transport'],
            'teacher' => ['create.marks', 'create.study-materials', 'delete.study-materials', 'manage.student-attendance', 'manage.study-materials', 'view.marks', 'view.student-attendance', 'view.study-materials'],
            'frontdesk' => ['create.frontdesk', 'manage.frontdesk', 'view.frontdesk'],
            'student' => [],
        ];
        $defaults['super_admin'] = Permission::pluck('name')->all();
        $defaults['admin'] = array_values(array_diff(array_keys(config('authorization.permissions')), ['manage.settings']));

        foreach ($defaults as $name => $keys) {
            $role = Role::firstOrCreate(['name' => $name], ['label' => Str::headline($name)]);
            if ($role->wasRecentlyCreated) {
                $role->syncPermissions(PermissionCatalog::initialGrants($keys));
            }
        }

        $this->command?->info('Custom roles and permission catalog ready; existing role grants preserved.');
    }
}
