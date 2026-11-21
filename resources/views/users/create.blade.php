<x-app-layout>
    <x-slot name="title">Add User</x-slot>

    <div class="flex items-center gap-3 mb-6">
        @access('users.index')
        <a href="{{ route('users.index') }}" class="text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        @endaccess
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Add User</h1>
            <p class="text-sm text-gray-500">Create a new system user</p>
        </div>
    </div>

    <div class="max-w-2xl">
        @access('users.store')
        <form method="POST" action="{{ route('users.store') }}" class="bg-white rounded-xl border border-gray-200 p-6 space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-400 @enderror">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-400 @enderror">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password <span class="text-red-500">*</span></label>
                <input type="password" name="password" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-400 @enderror">
                <p class="text-xs text-gray-400 mt-1">Min 8 characters, must include uppercase, lowercase, and number.</p>
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Roles <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-2 gap-2">
                    @foreach($roles as $role)
                    <label class="flex items-center gap-2 p-2 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                        <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                               {{ in_array($role->name, old('roles', [])) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-blue-600">
                        <span class="text-sm text-gray-700">{{ ucfirst(str_replace('_', ' ', $role->name)) }}</span>
                    </label>
                    @endforeach
                </div>
                @error('roles') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-2">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" id="is_active" value="1" checked
                       class="rounded border-gray-300 text-blue-600">
                <label for="is_active" class="text-sm text-gray-700">Active (user can login)</label>
            </div>

            <div class="flex items-center gap-3 pt-2 border-t border-gray-100">
                <button type="submit"
                        class="px-5 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                    Create User
                </button>
                @access('users.index')
                <a href="{{ route('users.index') }}"
                   class="px-5 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                @endaccess
            </div>
        </form>
                @endaccess
    </div>
</x-app-layout>
