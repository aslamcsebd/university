{{-- Sidebar --}}
<aside :class="sidebarOpen ? 'w-64' : 'w-16'"
       class="hidden lg:flex flex-col bg-slate-900 text-white transition-all duration-300 shrink-0 h-screen">

    {{-- Logo --}}
    <div class="flex items-center h-16 px-4 border-b border-slate-700 shrink-0">
        <div class="flex items-center gap-3 overflow-hidden">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                </svg>
            </div>
            <span x-show="sidebarOpen" x-cloak class="font-bold text-sm truncate leading-tight">
                {{ \App\Models\Setting::get('general.university_name', 'My University') }}
            </span>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto py-3 px-2 space-y-0.5"
         style="scrollbar-width: thin; scrollbar-color: #334155 transparent;">

        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors
                  {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span x-show="sidebarOpen" x-cloak>Dashboard</span>
        </a>

        {{-- Academic --}}
        @include('components.sidebar-group-item', [
            'label'  => 'Academic',
            'active' => request()->routeIs('academic.*','faculties.*','departments.*','programs.*','courses.*','sessions.*','batches.*','buildings.*','rooms.*','campuses.*'),
            'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055"/>',
            'items'  => [
                ['label'=>'Overview',          'route'=>'academic.index'],
                ['label'=>'Faculties',         'route'=>'faculties.index'],
                ['label'=>'Departments',       'route'=>'departments.index'],
                ['label'=>'Programs',          'route'=>'programs.index'],
                ['label'=>'Batches & Sections','route'=>'batches.index'],
                ['label'=>'Courses',           'route'=>'courses.index'],
                ['label'=>'Academic Sessions', 'route'=>'sessions.index'],
                ['label'=>'Buildings & Rooms', 'route'=>'buildings.index'],
                ['label'=>'Campuses',          'route'=>'campuses.index'],
            ]
        ])

        {{-- Admission --}}
        @include('components.sidebar-group-item', [
            'label'  => 'Admission',
            'active' => request()->routeIs('admissions.*','students.*'),
            'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
            'items'  => [
                ['label'=>'Applications',     'route'=>'admissions.index'],
                ['label'=>'New Registration', 'route'=>'admissions.create'],
                ['label'=>'Student List',     'route'=>'students.index'],
                ['label'=>'Transfer In/Out',  'route'=>'admissions.index'],
                ['label'=>'ID Cards',         'route'=>'admissions.index'],
            ]
        ])

        {{-- Students --}}
        @include('components.sidebar-group-item', [
            'label'  => 'Students',
            'active' => request()->routeIs('enrollments.*','attendance.students.*','leave.*'),
            'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>',
            'items'  => [
                ['label'=>'Enrollments',      'route'=>'enrollments.index'],
                ['label'=>'Attendance',       'route'=>'attendance.students.index'],
                ['label'=>'Leave Management', 'route'=>'leave.index'],
                ['label'=>'Alumni',           'route'=>'enrollments.index'],
            ]
        ])

        {{-- Timetable --}}
        @include('components.sidebar-group-item', [
            'label'  => 'Timetable',
            'active' => request()->routeIs('schedules.*','exam-schedules.*','timetable.*'),
            'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>',
            'items'  => [
                ['label'=>'Class Schedules', 'route'=>'schedules.index'],
                ['label'=>'Exam Schedules',  'route'=>'exam-schedules.index'],
                ['label'=>'Timetables',      'route'=>'timetable.index'],
            ]
        ])

        {{-- Examinations --}}
        @include('components.sidebar-group-item', [
            'label'  => 'Examinations',
            'active' => request()->routeIs('exam-types.*','mark-distributions.*','marks.*','results.*','grading.*'),
            'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>',
            'items'  => [
                ['label'=>'Exam Types',       'route'=>'exam-types.index'],
                ['label'=>'Mark Distribution','route'=>'mark-distributions.index'],
                ['label'=>'Mark Entry',       'route'=>'marks.index'],
                ['label'=>'Admit Cards',      'route'=>'marks.index'],
                ['label'=>'Process Results',  'route'=>'results.index'],
                ['label'=>'Mark Ledger',      'route'=>'results.index'],
                ['label'=>'Grading System',   'route'=>'grading.index'],
            ]
        ])

        {{-- Staff --}}
        @include('components.sidebar-group-item', [
            'label'  => 'Staff',
            'active' => request()->routeIs('staff.*','teachers.*','attendance.staff.*','staff-leave.*','designations.*'),
            'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>',
            'items'  => [
                ['label'=>'Staff List',          'route'=>'staff.index'],
                ['label'=>'Teachers',            'route'=>'teachers.index'],
                ['label'=>'Attendance',          'route'=>'attendance.staff.index'],
                ['label'=>'Leave',               'route'=>'staff-leave.index'],
                ['label'=>'Designations',        'route'=>'designations.index'],
            ]
        ])

        {{-- Facilities --}}
        @include('components.sidebar-group-item', [
            'label'  => 'Facilities',
            'active' => request()->routeIs('library.*','hostel.*','transport.*'),
            'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>',
            'items'  => [
                ['label'=>'Book List',          'route'=>'library.index'],
                ['label'=>'Issue Book',         'route'=>'library.issue'],
                ['label'=>'Book Return Due',    'route'=>'library.overdue'],
                ['label'=>'Library Members',    'route'=>'library.members'],
                ['label'=>'Hostel List',        'route'=>'hostel.index'],
                ['label'=>'Hostel Allocations', 'route'=>'hostel.allocations'],
                ['label'=>'Vehicles & Routes',  'route'=>'transport.index'],
                ['label'=>'Transport Alloc.',   'route'=>'transport.allocations'],
            ]
        ])

        {{-- Finance --}}
        @include('components.sidebar-group-item', [
            'label'  => 'Finance',
            'active' => request()->routeIs('fee-types.*','fee-assignments.*','payments.*','scholarships.*'),
            'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
            'items'  => [
                ['label'=>'Fee Types',       'route'=>'fee-types.index'],
                ['label'=>'Fee Assignments', 'route'=>'fee-assignments.index'],
                ['label'=>'Payments',        'route'=>'payments.index'],
                ['label'=>'Scholarships',    'route'=>'scholarships.index'],
            ]
        ])

        {{-- HR & Payroll --}}
        @include('components.sidebar-group-item', [
            'label'  => 'HR & Payroll',
            'active' => request()->routeIs('hr.*','salary.*','payroll.*'),
            'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>',
            'items'  => [
                ['label'=>'HR Management',     'route'=>'hr.index'],
                ['label'=>'Salary Structures', 'route'=>'salary.index'],
                ['label'=>'Payroll',           'route'=>'payroll.index'],
            ]
        ])

        {{-- Inventory --}}
        @include('components.sidebar-group-item', [
            'label'  => 'Inventory',
            'active' => request()->routeIs('inventory.*','suppliers.*'),
            'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>',
            'items'  => [
                ['label'=>'Items & Stock', 'route'=>'inventory.index'],
                ['label'=>'Suppliers',     'route'=>'suppliers.index'],
            ]
        ])

        {{-- Front Desk --}}
        @include('components.sidebar-group-item', [
            'label'  => 'Front Desk',
            'active' => request()->routeIs('visitors.*','enquiries.*','complaints.*'),
            'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>',
            'items'  => [
                ['label'=>'Visitor Log',  'route'=>'visitors.index'],
                ['label'=>'Enquiries',    'route'=>'enquiries.index'],
                ['label'=>'Complaints',   'route'=>'complaints.index'],
            ]
        ])

        {{-- Study Materials --}}
        @include('components.sidebar-group-item', [
            'label'  => 'Study Materials',
            'active' => request()->routeIs('study-materials.*'),
            'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>',
            'items'  => [
                ['label'=>'Materials', 'route'=>'study-materials.index'],
            ]
        ])

        {{-- Transcripts --}}
        @include('components.sidebar-group-item', [
            'label'  => 'Transcripts',
            'active' => request()->routeIs('transcripts.*'),
            'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
            'items'  => [
                ['label'=>'Transcripts',  'route'=>'transcripts.index'],
                ['label'=>'Certificates', 'route'=>'transcripts.index'],
            ]
        ])

        {{-- Reports --}}
        @include('components.sidebar-group-item', [
            'label'  => 'Reports',
            'active' => request()->routeIs('reports.*'),
            'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>',
            'items'  => [
                ['label'=>'All Reports', 'route'=>'reports.index'],
            ]
        ])

        {{-- Communicate --}}
        @include('components.sidebar-group-item', [
            'label'  => 'Communicate',
            'active' => request()->routeIs('notices.*','events.*','notifications.*'),
            'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>',
            'items'  => [
                ['label'=>'Notices',       'route'=>'notices.index'],
                ['label'=>'Events',        'route'=>'events.index'],
                ['label'=>'Notifications', 'route'=>'notifications.index'],
            ]
        ])

        {{-- Front Website --}}
        @include('components.sidebar-group-item', [
            'label'  => 'Front Website',
            'active' => request()->routeIs('frontweb.*'),
            'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
            'items'  => [
                ['label'=>'Pages',   'route'=>'frontweb.pages.index'],
                ['label'=>'News',    'route'=>'frontweb.news.index'],
                ['label'=>'Sliders', 'route'=>'frontweb.sliders.index'],
            ]
        ])

        {{-- Divider --}}
        <div class="border-t border-slate-700 my-2"></div>

        {{-- Settings --}}
        <a href="{{ route('settings.general') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors
                  {{ request()->routeIs('settings.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span x-show="sidebarOpen" x-cloak>Settings</span>
        </a>

        {{-- Users --}}
        <a href="{{ route('users.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors
                  {{ request()->routeIs('users.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <span x-show="sidebarOpen" x-cloak>Users</span>
        </a>

        {{-- Roles & Permissions --}}
        <a href="{{ route('roles.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors
                  {{ request()->routeIs('roles.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
            <span x-show="sidebarOpen" x-cloak>Roles & Permissions</span>
        </a>

        {{-- Audit Logs --}}
        <a href="{{ route('audit.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors
                  {{ request()->routeIs('audit.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <span x-show="sidebarOpen" x-cloak>Audit Logs</span>
        </a>

    </nav>

    {{-- User Footer --}}
    <div class="border-t border-slate-700 p-3 shrink-0">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-bold shrink-0">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
            <div x-show="sidebarOpen" x-cloak class="overflow-hidden min-w-0">
                <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-slate-400 truncate">{{ auth()->user()->getRoleNames()->first() }}</p>
            </div>
        </div>
    </div>
</aside>
