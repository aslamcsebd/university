<x-app-layout>
    <x-slot name="title">{{ $role ? 'Edit Role' : 'Create Role' }}</x-slot>
    <div class="mb-6 flex items-center justify-between">
        <div><h1 class="text-2xl font-bold text-gray-900">{{ $role ? 'Edit Role: '.($role->label ?? $role->name) : 'Create Role' }}</h1><p class="mt-1 text-sm text-gray-500">Choose the actions this role can perform in each module.</p></div>
        <a href="{{ route('roles.index') }}" class="text-sm text-blue-600">Back to roles</a>
    </div>
    <form method="POST" action="{{ $role ? route('roles.update', $role) : route('roles.store') }}" class="space-y-5" x-data="{ search: '' }">
        @csrf
        @if($role) @method('PUT') @endif
        <input type="hidden" name="permissions_present" value="1">
        @if($errors->any())
            <div role="alert" class="rounded-lg bg-red-50 p-4 text-sm text-red-700">@foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>
        @endif
        <div class="grid gap-4 rounded-xl border border-gray-200 bg-white p-5 md:grid-cols-2">
            <label class="text-sm font-medium text-gray-700">Display name
                <input name="label" value="{{ old('label', $role?->label ?? $role?->name) }}" required maxlength="255" class="mt-1 w-full rounded-lg border-gray-300">
            </label>
            <label class="text-sm font-medium text-gray-700">Role key
                <input name="name" value="{{ old('name', $role?->name) }}" required @if(!$role) pattern="[a-z][a-z0-9_]*" @endif maxlength="100" @readonly($role !== null) class="mt-1 w-full rounded-lg border-gray-300">
                <span class="mt-1 block text-xs text-gray-500">Lowercase letters, numbers and underscores, for example examination_officer.</span>
            </label>
            <label class="text-sm font-medium text-gray-700 md:col-span-2">Description
                <textarea name="description" maxlength="2000" class="mt-1 w-full rounded-lg border-gray-300">{{ old('description', $role?->description) }}</textarea>
            </label>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-5">
            <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
                <h2 class="font-semibold text-gray-900">Module permissions</h2>
                <label class="text-sm text-gray-600">Search modules or actions<input type="search" x-model="search" placeholder="Search permissions" class="ml-2 rounded-lg border-gray-300 text-sm"></label>
            </div>
            @php $selected = old('permissions', old('permissions_present') ? [] : $rolePermissions); @endphp
            <div class="space-y-4">
                @foreach($categories as $category)
                    @php $searchText = strtolower($category->name.' '.$category->permissions->pluck('name')->implode(' ').' '.$category->permissions->pluck('label')->implode(' ')); @endphp
                    <fieldset class="rounded-lg border border-gray-200 p-4" x-show="!search || @js($searchText).includes(search.toLowerCase())">
                        <legend class="px-2 text-sm font-semibold text-gray-800">{{ $category->name }}</legend>
                        <label class="mb-3 inline-flex items-center gap-2 text-xs text-gray-600">
                            <input type="checkbox" class="rounded border-gray-300" @change="$el.closest('fieldset').querySelectorAll('input[name=\'permissions[]\']:not(:disabled)').forEach(input => input.checked = $event.target.checked)"> Select all in this module
                        </label>
                        <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
                            @forelse($category->permissions as $permission)
                                <label class="flex items-start gap-2 rounded-lg p-2 {{ in_array($permission->name, $allowed) ? 'cursor-pointer hover:bg-gray-50' : 'opacity-50' }}">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" @checked(in_array($permission->name, $selected)) @disabled(!in_array($permission->name, $allowed)) class="mt-1 rounded border-gray-300 text-blue-600">
                                    <span><span class="block text-sm text-gray-800">{{ $permission->label }}</span><span class="block text-xs text-gray-500">{{ $permission->name }}</span></span>
                                </label>
                            @empty <p class="text-sm text-gray-500">No permissions registered in this module.</p> @endforelse
                        </div>
                    </fieldset>
                @endforeach
            </div>
        </div>
        <button class="rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white">{{ $role ? 'Save Changes' : 'Create Role' }}</button>
    </form>
</x-app-layout>
