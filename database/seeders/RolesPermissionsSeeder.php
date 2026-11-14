<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // Users
            'view.users', 'create.users', 'edit.users', 'delete.users',
            // Roles
            'manage.roles',
            // Settings
            'manage.settings',
            // University
            'manage.university',
            // Audit
            'view.audit-logs', 'export.audit-logs',
            // Academic
            'view.academic', 'manage.academic',
            // Students
            'view.students', 'create.students', 'edit.students', 'delete.students',
            // Admissions
            'view.admissions', 'create.admissions', 'edit.admissions', 'delete.admissions',
            // Teachers / Staff
            'view.staff', 'create.staff', 'edit.staff', 'delete.staff',
            // Attendance
            'view.attendance', 'manage.attendance',
            // Exams & Marks
            'view.exams', 'manage.exams',
            'view.marks', 'create.marks', 'publish.marks',
            // Results
            'view.results', 'publish.results',
            // Finance
            'view.fees', 'assign.fees', 'collect.fees',
            'view.payments', 'create.payments',
            'view.scholarships', 'manage.scholarships',
            // HR & Payroll
            'view.hr', 'manage.hr',
            'view.payroll', 'generate.payroll', 'approve.payroll',
            // Library
            'view.library', 'manage.library',
            // Hostel
            'view.hostel', 'manage.hostel',
            // Transport
            'view.transport', 'manage.transport',
            // Inventory
            'view.inventory', 'manage.inventory',
            // Front Desk
            'view.frontdesk', 'manage.frontdesk',
            // Reports
            'view.reports', 'export.reports',
            // Communication
            'view.communication', 'manage.communication',
            // Study Materials
            'view.study-materials', 'manage.study-materials',
            // Transcripts
            'view.transcripts', 'generate.transcripts',
            // Front Website
            'manage.frontweb',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Super Admin — all permissions
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $superAdmin->syncPermissions(Permission::all());

        // Admin — all except super-level
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin->syncPermissions(Permission::whereNotIn('name', ['manage.settings'])->get());

        // Academic Admin
        $academicAdmin = Role::firstOrCreate(['name' => 'academic_admin', 'guard_name' => 'web']);
        $academicAdmin->syncPermissions([
            'view.academic', 'manage.academic',
            'view.students', 'create.students', 'edit.students',
            'view.attendance', 'manage.attendance',
            'view.exams', 'manage.exams', 'view.marks', 'create.marks', 'publish.marks',
            'view.results', 'publish.results',
        ]);

        // Admission Admin
        $admissionAdmin = Role::firstOrCreate(['name' => 'admission_admin', 'guard_name' => 'web']);
        $admissionAdmin->syncPermissions([
            'view.admissions', 'create.admissions', 'edit.admissions', 'delete.admissions',
            'view.students', 'create.students', 'edit.students',
        ]);

        // Finance Admin
        $financeAdmin = Role::firstOrCreate(['name' => 'finance_admin', 'guard_name' => 'web']);
        $financeAdmin->syncPermissions([
            'view.fees', 'assign.fees', 'collect.fees',
            'view.payments', 'create.payments',
            'view.scholarships', 'manage.scholarships',
            'view.payroll', 'generate.payroll', 'approve.payroll',
            'view.reports', 'export.reports',
        ]);

        // HR Admin
        $hrAdmin = Role::firstOrCreate(['name' => 'hr_admin', 'guard_name' => 'web']);
        $hrAdmin->syncPermissions([
            'view.staff', 'create.staff', 'edit.staff', 'delete.staff',
            'view.hr', 'manage.hr',
            'view.payroll', 'generate.payroll',
        ]);

        // Librarian
        $librarian = Role::firstOrCreate(['name' => 'librarian', 'guard_name' => 'web']);
        $librarian->syncPermissions(['view.library', 'manage.library']);

        // Hostel Admin
        $hostelAdmin = Role::firstOrCreate(['name' => 'hostel_admin', 'guard_name' => 'web']);
        $hostelAdmin->syncPermissions(['view.hostel', 'manage.hostel']);

        // Transport Admin
        $transportAdmin = Role::firstOrCreate(['name' => 'transport_admin', 'guard_name' => 'web']);
        $transportAdmin->syncPermissions(['view.transport', 'manage.transport']);

        // Teacher
        $teacher = Role::firstOrCreate(['name' => 'teacher', 'guard_name' => 'web']);
        $teacher->syncPermissions([
            'view.attendance', 'manage.attendance',
            'view.marks', 'create.marks',
            'view.study-materials', 'manage.study-materials',
        ]);

        // Student
        Role::firstOrCreate(['name' => 'student', 'guard_name' => 'web']);

        // Front Desk
        $frontdesk = Role::firstOrCreate(['name' => 'frontdesk', 'guard_name' => 'web']);
        $frontdesk->syncPermissions(['view.frontdesk', 'manage.frontdesk']);

        $this->command->info('Roles and permissions seeded successfully.');
    }
}
