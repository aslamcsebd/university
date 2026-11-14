<x-app-layout>
    <x-slot name="title">Edit Role</x-slot>

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('roles.index') }}" class="text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Edit Role: {{ ucfirst(str_replace('_', ' ', $role->name)) }}</h1>
    </div>

    <div class="max-w-3xl">
        <form method="POST" action="{{ route('roles.update', $role) }}" class="bg-white rounded-xl border border-gray-200 p-6 space-y-6">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Role Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $role->name) }}" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <div class="flex items-center justify-between mb-3">
                    <label class="block text-sm font-medium text-gray-700">Permissions</label>
                    <label class="flex items-center gap-1.5 cursor-pointer text-xs text-blue-600">
                        <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-blue-600">
                        Select All
                    </label>
                </div>
                <div class="space-y-4">
                    @foreach($permissions as $resource => $perms)
                    <div class="border border-gray-100 rounded-lg p-3">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">{{ str_replace('-', ' ', $resource) }}</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($perms as $perm)
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="checkbox" name="permissions[]" value="{{ $perm->name }}"
                                       {{ in_array($perm->name, old('permissions', $rolePermissions)) ? 'checked' : '' }}
                                       class="perm-checkbox rounded border-gray-300 text-blue-600">
                                <span class="text-xs text-gray-700">{{ explode('.', $perm->name)[0] }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2 border-t border-gray-100">
                <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                    Update Role
                </button>
                <a href="{{ route('roles.index') }}" class="px-5 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        document.getElementById('selectAll').addEventListener('change', function () {
            document.querySelectorAll('.perm-checkbox').forEach(cb => cb.checked = this.checked);
        });
    </script>
    @endpush
</x-app-layout>
