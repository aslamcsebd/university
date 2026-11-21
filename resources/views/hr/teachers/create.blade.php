<x-app-layout>
    <x-slot name="title">Add Teacher</x-slot>
    <div class="flex items-center gap-3 mb-6">
        @access('teachers.index')
        <a href="{{ route('teachers.index') }}" class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></a>
        @endaccess
        <h1 class="text-2xl font-bold text-gray-900">Add Teacher</h1>
    </div>
    @access('teachers.store')
    <form method="POST" action="{{ route('teachers.store') }}" enctype="multipart/form-data" class="space-y-5 max-w-4xl">
        @csrf
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Personal Information</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div><label class="block text-sm font-medium text-gray-700 mb-1">First Name <span class="text-red-500">*</span></label><input type="text" name="first_name" value="{{ old('first_name') }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">@error('first_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Last Name <span class="text-red-500">*</span></label><input type="text" name="last_name" value="{{ old('last_name') }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Employee ID <span class="text-red-500">*</span></label><input type="text" name="employee_id" value="{{ old('employee_id', $employeeId) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">@error('employee_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Gender <span class="text-red-500">*</span></label><select name="gender" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"><option value="">—</option><option value="male">Male</option><option value="female">Female</option><option value="other">Other</option></select></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label><input type="date" name="dob" value="{{ old('dob') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Phone</label><input type="text" name="phone" value="{{ old('phone') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Academic & Employment</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Department <span class="text-red-500">*</span></label><select name="department_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"><option value="">—</option>@foreach($departments as $d)<option value="{{ $d->id }}" {{ old('department_id')==$d->id?'selected':'' }}>{{ $d->name }}</option>@endforeach</select>@error('department_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Designation <span class="text-red-500">*</span></label><select name="designation_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"><option value="">—</option>@foreach($designations as $d)<option value="{{ $d->id }}" {{ old('designation_id')==$d->id?'selected':'' }}>{{ $d->name }}</option>@endforeach</select>@error('designation_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Work Shift</label><select name="work_shift_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"><option value="">—</option>@foreach($workShifts as $s)<option value="{{ $s->id }}">{{ $s->name }}</option>@endforeach</select></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Employment Type <span class="text-red-500">*</span></label><select name="employment_type" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"><option value="permanent">Permanent</option><option value="contract">Contract</option><option value="part_time">Part Time</option><option value="visiting">Visiting</option></select></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Join Date <span class="text-red-500">*</span></label><input type="date" name="join_date" value="{{ old('join_date') }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Specialization</label><input type="text" name="specialization" value="{{ old('specialization') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Highest Degree</label><input type="text" name="highest_degree" value="{{ old('highest_degree') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Institution</label><input type="text" name="institution" value="{{ old('institution') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Experience (Years)</label><input type="number" name="experience_years" value="{{ old('experience_years', 0) }}" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Login Account <span class="text-red-500 text-xs">(Required for teachers)</span></h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label><input type="email" name="email" value="{{ old('email') }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">@error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Password <span class="text-red-500">*</span></label><input type="password" name="password" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"><p class="text-xs text-gray-400 mt-1">Min 8 characters</p>@error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
            </div>
        </div>
        <div class="flex items-center gap-2"><input type="checkbox" name="is_active" value="1" checked class="rounded border-gray-300 text-blue-600"><label class="text-sm text-gray-700">Active</label></div>
        <div class="flex gap-3">
            <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Create Teacher</button>
            @access('teachers.index')
            <a href="{{ route('teachers.index') }}" class="px-5 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">Cancel</a>
            @endaccess
        </div>
    </form>
            @endaccess
</x-app-layout>
