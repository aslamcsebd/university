<x-app-layout>
    <x-slot name="title">Roles & Permissions</x-slot>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Roles & Permissions</h1>
            <p class="text-sm text-gray-500 mt-1">Manage roles and their access permissions</p>
        </div>
        @can('manage.roles')
        <a href="{{ route('roles.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Role
        </a>
        @endcan
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
        @foreach($roles as $role)
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <h3 class="font-semibold text-gray-900">{{ ucfirst(str_replace('_', ' ', $role->name)) }}</h3>
                    <p class="text-xs text-gray-500 mt-0.5">{{ $role->users_count }} user{{ $role->users_count != 1 ? 's' : '' }}</p>
                </div>
                @if($role->name !== 'super_admin')
                <div class="flex gap-1">
                    @can('manage.roles')
                    <a href="{{ route('roles.edit', $role) }}"
                       class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </a>
                    @if($role->users_count === 0)
                    <form method="POST" action="{{ route('roles.destroy', $role) }}"
                          onsubmit="return confirm('Delete this role?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>
                    @endif
                    @endcan
                </div>
                @else
                <span class="text-xs px-2 py-0.5 bg-purple-100 text-purple-700 rounded-full">System</span>
                @endif
            </div>
            <div class="flex flex-wrap gap-1">
                @foreach($role->permissions->take(6) as $perm)
                    <span class="px-1.5 py-0.5 bg-gray-100 text-gray-600 rounded text-xs">{{ $perm->name }}</span>
                @endforeach
                @if($role->permissions->count() > 6)
                    <span class="px-1.5 py-0.5 bg-gray-100 text-gray-500 rounded text-xs">+{{ $role->permissions->count() - 6 }} more</span>
                @endif
                @if($role->permissions->isEmpty())
                    <span class="text-xs text-gray-400">No permissions assigned</span>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</x-app-layout>
