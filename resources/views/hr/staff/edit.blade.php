<x-app-layout>
    <x-slot name="title">Edit Staff</x-slot>
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('staff.index') }}" class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></a>
        <div><h1 class="text-2xl font-bold text-gray-900">Edit Staff</h1><p class="text-sm text-gray-500">{{ $staff->full_name }}</p></div>
    </div>
    <form method="POST" action="{{ route('staff.update', $staff) }}" enctype="multipart/form-data" class="space-y-5 max-w-4xl">
        @csrf @method('PUT')
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Personal Information</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div><label class="block text-sm font-medium text-gray-700 mb-1">First Name <span class="text-red-500">*</span></label><input type="text" name="first_name" value="{{ old('first_name', $staff->first_name) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Last Name <span class="text-red-500">*</span></label><input type="text" name="last_name" value="{{ old('last_name', $staff->last_name) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Employee ID <span class="text-red-500">*</span></label><input type="text" name="employee_id" value="{{ old('employee_id', $staff->employee_id) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">@error('employee_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Gender <span class="text-red-500">*</span></label><select name="gender" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"><option value="">—</option><option value="male" {{ old('gender',$staff->gender)=='male'?'selected':'' }}>Male</option><option value="female" {{ old('gender',$staff->gender)=='female'?'selected':'' }}>Female</option><option value="other" {{ old('gender',$staff->gender)=='other'?'selected':'' }}>Other</option></select></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label><input type="date" name="dob" value="{{ old('dob', $staff->dob?->format('Y-m-d')) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Phone</label><input type="text" name="phone" value="{{ old('phone', $staff->phone) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Personal Email</label><input type="email" name="personal_email" value="{{ old('personal_email', $staff->personal_email) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Photo</label>
                    @if($staff->photo)<img src="{{ $staff->photo_url }}" class="w-12 h-12 rounded-full object-cover mb-2">@endif
                    <input type="file" name="photo" accept="image/*" class="w-full text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700">
                </div>
                <div class="sm:col-span-2 lg:col-span-3"><label class="block text-sm font-medium text-gray-700 mb-1">Address</label><textarea name="address" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('address', $staff->address) }}</textarea></div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Employment Details</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Department <span class="text-red-500">*</span></label><select name="department_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"><option value="">—</option>@foreach($departments as $d)<option value="{{ $d->id }}" {{ old('department_id',$staff->department_id)==$d->id?'selected':'' }}>{{ $d->name }}</option>@endforeach</select></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Designation <span class="text-red-500">*</span></label><select name="designation_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"><option value="">—</option>@foreach($designations as $d)<option value="{{ $d->id }}" {{ old('designation_id',$staff->designation_id)==$d->id?'selected':'' }}>{{ $d->name }}</option>@endforeach</select></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Work Shift</label><select name="work_shift_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"><option value="">—</option>@foreach($workShifts as $s)<option value="{{ $s->id }}" {{ old('work_shift_id',$staff->work_shift_id)==$s->id?'selected':'' }}>{{ $s->name }}</option>@endforeach</select></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Employment Type <span class="text-red-500">*</span></label><select name="employment_type" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"><option value="permanent" {{ old('employment_type',$staff->employment_type)=='permanent'?'selected':'' }}>Permanent</option><option value="contract" {{ old('employment_type',$staff->employment_type)=='contract'?'selected':'' }}>Contract</option><option value="part_time" {{ old('employment_type',$staff->employment_type)=='part_time'?'selected':'' }}>Part Time</option><option value="visiting" {{ old('employment_type',$staff->employment_type)=='visiting'?'selected':'' }}>Visiting</option></select></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Join Date <span class="text-red-500">*</span></label><input type="date" name="join_date" value="{{ old('join_date', $staff->join_date?->format('Y-m-d')) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Experience (Years)</label><input type="number" name="experience_years" value="{{ old('experience_years', $staff->experience_years) }}" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Highest Degree</label><input type="text" name="highest_degree" value="{{ old('highest_degree', $staff->highest_degree) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Institution</label><input type="text" name="institution" value="{{ old('institution', $staff->institution) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
            </div>
        </div>
        <div class="flex items-center gap-2"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $staff->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600"><label class="text-sm text-gray-700">Active</label></div>
        <div class="flex gap-3">
            <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Update Staff</button>
            <a href="{{ route('staff.index') }}" class="px-5 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">Cancel</a>
        </div>
    </form>
</x-app-layout>
