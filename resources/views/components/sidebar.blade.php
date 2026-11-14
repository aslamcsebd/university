{{-- Sidebar --}}
<aside
    :class="sidebarOpen ? 'w-64' : 'w-16'"
    class="hidden lg:flex flex-col bg-slate-900 text-white transition-all duration-300 overflow-hidden shrink-0">

    {{-- Logo --}}
    <div class="flex items-center h-16 px-4 border-b border-slate-700 shrink-0">
        <div class="flex items-center gap-3 overflow-hidden">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                </svg>
            </div>
            <span x-show="sidebarOpen" class="font-bold text-sm truncate">
                {{ \App\Models\Setting::get('general.university_name', 'UMS') }}
            </span>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto py-4 space-y-1 px-2 scrollbar-hide">

        {{-- Dashboard --}}
        <x-sidebar-item href="{{ route('dashboard') }}" icon="home" :active="request()->routeIs('dashboard')">
            Dashboard
        </x-sidebar-item>

        {{-- ACADEMIC --}}
        <x-sidebar-group label="Academic" icon="academic-cap">
            <x-sidebar-item href="{{ route('academic.index') }}" icon="chart-bar" :active="request()->routeIs('academic.*')">Overview</x-sidebar-item>
            <x-sidebar-item href="{{ route('faculties.index') }}" icon="office-building" :active="request()->routeIs('faculties.*')">Faculties</x-sidebar-item>
            <x-sidebar-item href="{{ route('departments.index') }}" icon="collection" :active="request()->routeIs('departments.*')">Departments</x-sidebar-item>
            <x-sidebar-item href="{{ route('programs.index') }}" icon="book-open" :active="request()->routeIs('programs.*')">Programs</x-sidebar-item>
            <x-sidebar-item href="{{ route('batches.index') }}" icon="user-group" :active="request()->routeIs('batches.*')">Batches & Sections</x-sidebar-item>
            <x-sidebar-item href="{{ route('courses.index') }}" icon="clipboard-list" :active="request()->routeIs('courses.*')">Courses & Subjects</x-sidebar-item>
            <x-sidebar-item href="{{ route('sessions.index') }}" icon="calendar" :active="request()->routeIs('sessions.*')">Semesters</x-sidebar-item>
            <x-sidebar-item href="{{ route('buildings.index') }}" icon="library" :active="request()->routeIs('buildings.*')">Buildings & Rooms</x-sidebar-item>
        </x-sidebar-group>

        {{-- ADMISSION --}}
        <x-sidebar-group label="Admission" icon="document-add">
            <x-sidebar-item href="{{ route('admissions.index') }}" icon="document-text" :active="request()->routeIs('admissions.index')">Applications</x-sidebar-item>
            <x-sidebar-item href="{{ route('admissions.create') }}" icon="plus-circle" :active="request()->routeIs('admissions.create')">New Registration</x-sidebar-item>
            <x-sidebar-item href="{{ route('students.index') }}" icon="users" :active="request()->routeIs('students.*')">Student List</x-sidebar-item>
            <x-sidebar-item href="#" icon="switch-horizontal">Transfer In/Out</x-sidebar-item>
            <x-sidebar-item href="#" icon="identification">ID Cards</x-sidebar-item>
        </x-sidebar-group>

        {{-- STUDENTS --}}
        <x-sidebar-group label="Students" icon="academic-cap">
            <x-sidebar-item href="{{ route('enrollments.index') }}" icon="clipboard-check" :active="request()->routeIs('enrollments.*')">Enrollments</x-sidebar-item>
            <x-sidebar-item href="{{ route('attendance.students.index') }}" icon="check-circle" :active="request()->routeIs('attendance.students.*')">Attendance</x-sidebar-item>
            <x-sidebar-item href="{{ route('leave.index') }}" icon="calendar" :active="request()->routeIs('leave.*')">Leave Management</x-sidebar-item>
            <x-sidebar-item href="#" icon="star">Alumni</x-sidebar-item>
        </x-sidebar-group>

        {{-- TIMETABLE --}}
        <x-sidebar-group label="Timetable" icon="clock">
            <x-sidebar-item href="{{ route('schedules.index') }}" icon="table" :active="request()->routeIs('schedules.*')">Class Schedules</x-sidebar-item>
            <x-sidebar-item href="{{ route('exam-schedules.index') }}" icon="calendar" :active="request()->routeIs('exam-schedules.*')">Exam Schedules</x-sidebar-item>
            <x-sidebar-item href="{{ route('timetable.index') }}" icon="view-grid" :active="request()->routeIs('timetable.*')">Timetables</x-sidebar-item>
        </x-sidebar-group>

        {{-- EXAMINATIONS --}}
        <x-sidebar-group label="Examinations" icon="pencil-alt">
            <x-sidebar-item href="{{ route('exam-types.index') }}" icon="tag" :active="request()->routeIs('exam-types.*')">Exam Types</x-sidebar-item>
            <x-sidebar-item href="{{ route('mark-distributions.index') }}" icon="adjustments" :active="request()->routeIs('mark-distributions.*')">Mark Distribution</x-sidebar-item>
            <x-sidebar-item href="{{ route('marks.index') }}" icon="pencil" :active="request()->routeIs('marks.*')">Mark Entry</x-sidebar-item>
            <x-sidebar-item href="#" icon="document">Admit Cards</x-sidebar-item>
            <x-sidebar-item href="{{ route('results.index') }}" icon="chart-bar" :active="request()->routeIs('results.*')">Process Results</x-sidebar-item>
            <x-sidebar-item href="#" icon="book-open">Mark Ledger</x-sidebar-item>
            <x-sidebar-item href="{{ route('grading.index') }}" icon="star" :active="request()->routeIs('grading.*')">Grading System</x-sidebar-item>
        </x-sidebar-group>

        {{-- STAFF --}}
        <x-sidebar-group label="Staff" icon="users">
            <x-sidebar-item href="{{ route('staff.index') }}" icon="identification" :active="request()->routeIs('staff.*')">Staff List</x-sidebar-item>
            <x-sidebar-item href="{{ route('teachers.index') }}" icon="academic-cap" :active="request()->routeIs('teachers.*')">Teachers</x-sidebar-item>
            <x-sidebar-item href="{{ route('attendance.staff.index') }}" icon="check-circle" :active="request()->routeIs('attendance.staff.*')">Attendance</x-sidebar-item>
            <x-sidebar-item href="{{ route('staff-leave.index') }}" icon="calendar" :active="request()->routeIs('staff-leave.*')">Leave</x-sidebar-item>
            <x-sidebar-item href="{{ route('designations.index') }}" icon="badge-check" :active="request()->routeIs('designations.*')">Designations & Shifts</x-sidebar-item>
        </x-sidebar-group>

        {{-- FACILITIES --}}
        <x-sidebar-group label="Facilities" icon="office-building">
            <x-sidebar-item href="{{ route('library.index') }}" icon="book-open" :active="request()->routeIs('library.*')">Library</x-sidebar-item>
            <x-sidebar-item href="{{ route('hostel.index') }}" icon="home" :active="request()->routeIs('hostel.*')">Hostel</x-sidebar-item>
            <x-sidebar-item href="{{ route('transport.index') }}" icon="truck" :active="request()->routeIs('transport.*')">Transport</x-sidebar-item>
        </x-sidebar-group>

        {{-- FINANCE --}}
        <x-sidebar-group label="Finance" icon="currency-dollar">
            <x-sidebar-item href="{{ route('fee-types.index') }}" icon="tag" :active="request()->routeIs('fee-types.*')">Fee Types</x-sidebar-item>
            <x-sidebar-item href="{{ route('fee-assignments.index') }}" icon="clipboard-list" :active="request()->routeIs('fee-assignments.*')">Fee Assignments</x-sidebar-item>
            <x-sidebar-item href="{{ route('payments.index') }}" icon="cash" :active="request()->routeIs('payments.*')">Payments</x-sidebar-item>
            <x-sidebar-item href="#" icon="receipt-tax">Discounts</x-sidebar-item>
            <x-sidebar-item href="{{ route('scholarships.index') }}" icon="gift" :active="request()->routeIs('scholarships.*')">Scholarships</x-sidebar-item>
            <x-sidebar-item href="#" icon="trending-up">Income & Expense</x-sidebar-item>
        </x-sidebar-group>

        {{-- HR & PAYROLL --}}
        <x-sidebar-group label="HR & Payroll" icon="briefcase">
            <x-sidebar-item href="{{ route('hr.index') }}" icon="users" :active="request()->routeIs('hr.*')">HR Management</x-sidebar-item>
            <x-sidebar-item href="{{ route('salary.index') }}" icon="currency-dollar" :active="request()->routeIs('salary.*')">Salary Structures</x-sidebar-item>
            <x-sidebar-item href="{{ route('payroll.index') }}" icon="calculator" :active="request()->routeIs('payroll.*')">Payroll</x-sidebar-item>
        </x-sidebar-group>

        {{-- INVENTORY --}}
        <x-sidebar-group label="Inventory" icon="cube">
            <x-sidebar-item href="{{ route('inventory.index') }}" icon="archive" :active="request()->routeIs('inventory.*')">Items & Stock</x-sidebar-item>
            <x-sidebar-item href="{{ route('suppliers.index') }}" icon="truck" :active="request()->routeIs('suppliers.*')">Suppliers</x-sidebar-item>
        </x-sidebar-group>

        {{-- FRONT DESK --}}
        <x-sidebar-group label="Front Desk" icon="phone">
            <x-sidebar-item href="{{ route('visitors.index') }}" icon="eye" :active="request()->routeIs('visitors.*')">Visitor Log</x-sidebar-item>
            <x-sidebar-item href="{{ route('enquiries.index') }}" icon="question-mark-circle" :active="request()->routeIs('enquiries.*')">Enquiries</x-sidebar-item>
            <x-sidebar-item href="{{ route('complaints.index') }}" icon="exclamation" :active="request()->routeIs('complaints.*')">Complaints</x-sidebar-item>
        </x-sidebar-group>

        {{-- STUDY MATERIALS --}}
        <x-sidebar-group label="Study Materials" icon="book-open">
            <x-sidebar-item href="{{ route('study-materials.index') }}" icon="document-text" :active="request()->routeIs('study-materials.*')">Materials</x-sidebar-item>
        </x-sidebar-group>

        {{-- TRANSCRIPTS --}}
        <x-sidebar-group label="Transcripts" icon="document">
            <x-sidebar-item href="{{ route('transcripts.index') }}" icon="document-text" :active="request()->routeIs('transcripts.*')">Transcripts</x-sidebar-item>
            <x-sidebar-item href="#" icon="badge-check">Certificates</x-sidebar-item>
        </x-sidebar-group>

        {{-- REPORTS --}}
        <x-sidebar-group label="Reports" icon="chart-bar">
            <x-sidebar-item href="{{ route('reports.index') }}" icon="chart-pie" :active="request()->routeIs('reports.*')">All Reports</x-sidebar-item>
        </x-sidebar-group>

        {{-- COMMUNICATE --}}
        <x-sidebar-group label="Communicate" icon="bell">
            <x-sidebar-item href="{{ route('notices.index') }}" icon="speakerphone" :active="request()->routeIs('notices.*')">Notices</x-sidebar-item>
            <x-sidebar-item href="{{ route('events.index') }}" icon="calendar" :active="request()->routeIs('events.*')">Events</x-sidebar-item>
            <x-sidebar-item href="{{ route('notifications.index') }}" icon="bell" :active="request()->routeIs('notifications.*')">Notifications</x-sidebar-item>
        </x-sidebar-group>

        {{-- FRONT WEBSITE --}}
        <x-sidebar-group label="Front Website" icon="globe">
            <x-sidebar-item href="{{ route('frontweb.pages.index') }}" icon="document-text" :active="request()->routeIs('frontweb.pages.*')">Pages</x-sidebar-item>
            <x-sidebar-item href="{{ route('frontweb.news.index') }}" icon="newspaper" :active="request()->routeIs('frontweb.news.*')">News</x-sidebar-item>
            <x-sidebar-item href="{{ route('frontweb.sliders.index') }}" icon="photograph" :active="request()->routeIs('frontweb.sliders.*')">Sliders</x-sidebar-item>
        </x-sidebar-group>

        {{-- SETTINGS --}}
        <div class="pt-2 border-t border-slate-700 mt-2">
            <x-sidebar-item href="{{ route('settings.general') }}" icon="cog" :active="request()->routeIs('settings.*')">
                Settings
            </x-sidebar-item>
            <x-sidebar-item href="{{ route('users.index') }}" icon="user-group" :active="request()->routeIs('users.*')">
                Users
            </x-sidebar-item>
            <x-sidebar-item href="{{ route('roles.index') }}" icon="shield-check" :active="request()->routeIs('roles.*')">
                Roles & Permissions
            </x-sidebar-item>
            <x-sidebar-item href="{{ route('audit.index') }}" icon="clipboard-list" :active="request()->routeIs('audit.*')">
                Audit Logs
            </x-sidebar-item>
        </div>

    </nav>

    {{-- Sidebar Footer --}}
    <div class="border-t border-slate-700 p-3 shrink-0">
        <div class="flex items-center gap-3">
            <img src="{{ auth()->user()->avatar_url }}" class="w-8 h-8 rounded-full object-cover shrink-0" alt="Avatar">
            <div x-show="sidebarOpen" class="overflow-hidden">
                <p class="text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-slate-400 truncate">{{ auth()->user()->getRoleNames()->first() }}</p>
            </div>
        </div>
    </div>
</aside>
