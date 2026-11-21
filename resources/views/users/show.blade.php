<x-app-layout>
    <x-slot name="title">{{ $user->name }}</x-slot>

    <div class="flex items-center gap-3 mb-6">
        @access('users.index')
        <a href="{{ route('users.index') }}" class="text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        @endaccess
        <h1 class="text-2xl font-bold text-gray-900">User Profile</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        {{-- Profile Card --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6 text-center">
            <img src="{{ $user->avatar_url }}" class="w-20 h-20 rounded-full mx-auto mb-4 object-cover" alt="">
            <h2 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h2>
            <p class="text-sm text-gray-500">{{ $user->email }}</p>
            <div class="flex flex-wrap justify-center gap-1 mt-3">
                @foreach($user->roles as $role)
                    <span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full text-xs">
                        {{ str_replace('_', ' ', $role->name) }}
                    </span>
                @endforeach
            </div>
            <span class="mt-3 inline-block px-3 py-1 rounded-full text-xs font-medium {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                {{ $user->is_active ? 'Active' : 'Inactive' }}
            </span>
            <div class="mt-4 flex gap-2 justify-center">
                @can('update', $user)
@access('users.edit')
<a href="{{ route('users.edit', $user) }}"
                   class="px-3 py-1.5 bg-blue-600 text-white rounded-lg text-xs font-medium hover:bg-blue-700 transition-colors">
                    Edit
                </a>
@endaccess

@endcan
            </div>
        </div>

        {{-- Details --}}
        <div class="lg:col-span-2 space-y-5">
            <section class="rounded-xl border border-gray-200 bg-white p-5">
                <h3 class="mb-3 font-semibold text-gray-900">Effective Permissions</h3>
                @if($user->isSuperAdmin())<p class="mb-3 text-sm text-purple-700">The system role grants all registered application permissions.</p>@endif
                @forelse($effectivePermissions->groupBy(fn ($permission) => $permission->category->name) as $category => $permissions)
                    <div class="mb-3"><h4 class="text-sm font-medium text-gray-800">{{ $category }}</h4>
                    @foreach($permissions as $permission)
                        @php
                            $sources = $user->roles->filter(fn ($role) => $role->permissions->contains('id', $permission->id))->map(fn ($role) => $role->label ?? $role->name)->all();
                            if ($user->permissions->contains('id', $permission->id)) $sources[] = 'Direct grant';
                            if ($user->isSuperAdmin()) $sources = ['Super administrator'];
                            if (!$sources) $sources = ['Assigned role'];
                        @endphp
                        <p class="mt-1 text-xs text-gray-600">{{ $permission->label }} <span class="text-gray-400">({{ $permission->name }})</span> — {{ implode(', ', $sources) }}</p>
                    @endforeach</div>
                @empty <p class="text-sm text-gray-500">No module permissions assigned.</p> @endforelse
            </section>
            @can('assign.roles')
                @can('update', $user)
                    @if(!$user->hasRole('super_admin'))
                        @access('users.permissions')
<form method="POST" action="{{ route('users.permissions', $user) }}" class="rounded-xl border border-gray-200 bg-white p-5">
                            @csrf @method('PUT')
                            <h3 class="mb-2 font-semibold text-gray-900">Direct Permission Exceptions</h3>
                            <p class="mb-3 text-sm text-gray-500">Role permissions still apply. These selections add access for this user.</p>
                            @if($errors->any())<p role="alert" class="mb-3 text-sm text-red-600">{{ $errors->first() }}</p>@endif
                            <div class="grid max-h-80 gap-2 overflow-y-auto sm:grid-cols-2">
                                @foreach($grantablePermissions as $permission)
                                    <label class="flex items-center gap-2 text-sm text-gray-700"><input type="checkbox" name="permissions[]" value="{{ $permission->name }}" @checked($user->permissions->contains('id', $permission->id)) class="rounded border-gray-300 text-blue-600">{{ $permission->label }}</label>
                                @endforeach
                            </div>
                            <button class="mt-4 rounded-lg bg-blue-600 px-4 py-2 text-sm text-white">Save Direct Permissions</button>
                        </form>
@endaccess

                    @endif
                @endcan
            @endcan
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-900 mb-4">Account Details</h3>
                <dl class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="text-gray-500">Joined</dt>
                        <dd class="font-medium text-gray-900">{{ $user->created_at->format('d M Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Last Login</dt>
                        <dd class="font-medium text-gray-900">{{ $user->last_login_at ? $user->last_login_at->format('d M Y H:i') : 'Never' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Last Login IP</dt>
                        <dd class="font-medium text-gray-900">{{ $user->last_login_ip ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">2FA</dt>
                        <dd class="font-medium text-gray-900">{{ $user->two_fa_enabled ? 'Enabled' : 'Disabled' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Email Verified</dt>
                        <dd class="font-medium text-gray-900">{{ $user->email_verified_at ? $user->email_verified_at->format('d M Y') : 'Not verified' }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Login Audit --}}
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900">Recent Login Activity</h3>
                </div>
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left px-5 py-2 text-gray-500 font-medium">Status</th>
                            <th class="text-left px-5 py-2 text-gray-500 font-medium">IP Address</th>
                            <th class="text-left px-5 py-2 text-gray-500 font-medium">Time</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($loginAudits as $audit)
                        <tr>
                            <td class="px-5 py-2">
                                <span class="px-2 py-0.5 rounded-full text-xs {{ $audit->status === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $audit->status }}
                                </span>
                            </td>
                            <td class="px-5 py-2 text-gray-600">{{ $audit->ip_address ?? '—' }}</td>
                            <td class="px-5 py-2 text-gray-500">{{ $audit->created_at->diffForHumans() }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="px-5 py-6 text-center text-gray-400">No login records</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
