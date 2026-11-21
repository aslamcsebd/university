<x-app-layout>
    <x-slot name="title">Categories & Permissions</x-slot>
    <div class="mb-6 flex items-center justify-between"><div><h1 class="text-2xl font-bold text-gray-900">Categories & Permissions</h1><p class="mt-1 text-sm text-gray-500">Organize university actions by module. Labels can change while permission keys stay stable.</p></div><a href="{{ route('roles.index') }}" class="text-sm text-blue-600">Back to roles</a></div>
    @if($errors->any())<div role="alert" class="mb-4 rounded bg-red-50 p-3 text-sm text-red-700">@foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>@endif
    <div class="mb-6 grid gap-5 lg:grid-cols-2">
        <form method="POST" action="{{ route('permission-categories.store') }}" class="space-y-3 rounded-xl border border-gray-200 bg-white p-5">@csrf<h2 class="font-semibold">Add Category</h2>
            <label class="block text-sm">Name<input name="name" value="{{ old('name') }}" required maxlength="255" class="mt-1 w-full rounded border-gray-300"></label>
            <label class="block text-sm">Category key<input name="slug" value="{{ old('slug') }}" required pattern="[a-z][a-z0-9-]*" placeholder="student-services" class="mt-1 w-full rounded border-gray-300"></label>
            <label class="block text-sm">Description<textarea name="description" maxlength="2000" class="mt-1 w-full rounded border-gray-300"></textarea></label><button class="rounded bg-blue-600 px-4 py-2 text-sm text-white">Create Category</button>
        </form>
        <form method="POST" action="{{ route('permissions.store') }}" class="space-y-3 rounded-xl border border-gray-200 bg-white p-5">@csrf<h2 class="font-semibold">Add Permission</h2>
            <label class="block text-sm">Label<input name="label" value="{{ old('label') }}" required maxlength="255" class="mt-1 w-full rounded border-gray-300"></label>
            <label class="block text-sm">Permission key<input name="name" required placeholder="approve.student-services" maxlength="150" class="mt-1 w-full rounded border-gray-300"></label>
            <label class="block text-sm">Category<select name="permission_category_id" required class="mt-1 w-full rounded border-gray-300">@foreach($categories as $category)<option value="{{ $category->id }}">{{ $category->name }}</option>@endforeach</select></label>
            <button class="rounded bg-blue-600 px-4 py-2 text-sm text-white">Create Permission</button>
        </form>
    </div>
    <div x-data="{ search: '' }" class="space-y-5">
        <label class="block text-sm">Search categories or permissions<input type="search" x-model="search" class="ml-2 rounded border-gray-300" placeholder="Search"></label>
        @foreach($categories as $category)
            @php $searchText = strtolower($category->name.' '.$category->permissions->pluck('name')->implode(' ').' '.$category->permissions->pluck('label')->implode(' ')); @endphp
            <section x-show="!search || @js($searchText).includes(search.toLowerCase())" class="rounded-xl border border-gray-200 bg-white p-5">
                <div class="mb-4 flex flex-wrap items-start justify-between gap-3"><div><h2 class="font-semibold">{{ $category->name }}</h2><p class="text-xs text-gray-500">{{ $category->slug }} · {{ $category->permissions->count() }} permissions</p>@if($category->description)<p class="mt-1 text-sm text-gray-600">{{ $category->description }}</p>@endif</div>
                <details><summary class="cursor-pointer text-sm text-blue-600">Edit Category</summary><form method="POST" action="{{ route('permission-categories.update', $category) }}" class="mt-2 space-y-2">@csrf @method('PUT')<label class="block text-sm">Name<input name="name" value="{{ $category->name }}" required class="mt-1 w-full rounded border-gray-300 text-sm"></label><label class="block text-sm">Description<textarea name="description" class="mt-1 w-full rounded border-gray-300 text-sm">{{ $category->description }}</textarea></label><button class="rounded bg-blue-600 px-3 py-1 text-sm text-white">Save Category</button></form>
                @if($category->permissions->isEmpty() && !array_key_exists($category->slug, config('authorization.categories')))<form method="POST" action="{{ route('permission-categories.destroy', $category) }}" class="mt-2" onsubmit="return confirm('Delete this category?')">@csrf @method('DELETE')<button class="text-sm text-red-600">Delete Category</button></form>@endif</details></div>
                <div class="divide-y divide-gray-100">
                    @forelse($category->permissions as $permission)
                        <div class="flex flex-wrap items-center justify-between gap-3 py-3"><div><p class="text-sm font-medium">{{ $permission->label }}</p><p class="text-xs text-gray-500">{{ $permission->name }} · {{ $permission->roles_count }} roles · {{ $permission->users_count }} direct grants</p></div>
                            <details><summary class="cursor-pointer text-sm text-blue-600">Edit Permission</summary><form method="POST" action="{{ route('permissions.update', $permission) }}" class="mt-2 space-y-2">@csrf @method('PUT')<label class="block text-sm">Label<input name="label" value="{{ $permission->label }}" required class="mt-1 w-full rounded border-gray-300 text-sm"></label><label class="block text-sm">Category<select name="permission_category_id" class="mt-1 w-full rounded border-gray-300 text-sm">@foreach($categories as $target)<option value="{{ $target->id }}" @selected($permission->permission_category_id === $target->id)>{{ $target->name }}</option>@endforeach</select></label><button class="rounded bg-blue-600 px-3 py-1 text-sm text-white">Save Permission</button></form>
                            @if(!array_key_exists($permission->name, config('authorization.permissions')) && !$permission->roles_count && !$permission->users_count)<form method="POST" action="{{ route('permissions.destroy', $permission) }}" class="mt-2" onsubmit="return confirm('Delete this permission?')">@csrf @method('DELETE')<button class="text-sm text-red-600">Delete Permission</button></form>@endif</details>
                        </div>
                    @empty <p class="text-sm text-gray-500">No permissions registered.</p> @endforelse
                </div>
            </section>
        @endforeach
    </div>
</x-app-layout>
