<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\PermissionCategory;
use App\Models\Role;
use App\Models\User;
use App\Services\AccessManagement;
use App\Support\PermissionCatalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::visibleTo($request->user())->with('permissions')
            ->withCount(['users' => fn ($query) => $query->visibleTo($request->user())])->get()
            ->sortBy(fn (Role $role) => [
                match ($role->name) {
                    'super_admin' => 0,
                    'admin' => 1,
                    default => 2,
                },
                strtolower($role->label ?? $role->name),
            ])->values();
        $categoryOrder = array_flip(array_keys(config('authorization.categories')));
        $activeKeys = PermissionCatalog::activeKeys();
        $catalogKeys = array_keys(PermissionCatalog::definitions());
        $ownKeys = $request->user()->isSuperAdmin() ? null : $request->user()->getAllPermissions()->pluck('name')->all();
        $categories = PermissionCategory::with(['permissions' => fn ($query) => $query->with('page')
            ->where(fn ($query) => $query->whereIn('name', $activeKeys)->orWhereNotIn('name', $catalogKeys))
            ->when($ownKeys !== null, fn ($query) => $query->whereIn('name', $ownKeys))
            ->orderBy('sort_order')->orderBy('name')])
            ->get()->sortBy(fn ($category) => [$categoryOrder[$category->slug] ?? 999, $category->id])->values();

        $workspaceRoles = $roles->map(fn (Role $role) => $this->workspaceRole($role, $request->user()))->all();
        $workspaceModules = $categories->map(function (PermissionCategory $category) {
            $format = fn (Permission $permission) => [
                'key' => $permission->name, 'label' => $permission->label,
                'action' => Str::headline($permission->action ?? Str::before($permission->name, '.')),
            ];
            $pages = $category->permissions->groupBy(fn ($permission) => $permission->page
                && (int) $permission->page->permission_category_id === (int) $category->id ? $permission->page->id : 'general')
                ->map(function ($permissions, $id) use ($category, $format) {
                    $page = $id === 'general' ? null : $permissions->first()->page;

                    return [
                        'id' => $page?->id ?? 'general-'.$category->id,
                        'key' => $page?->key ?? 'general',
                        'label' => $page?->name ?? 'General permissions',
                        'sort_order' => $page?->sort_order ?? 999,
                        'permissions' => $permissions->map($format)->values()->all(),
                    ];
                })->sortBy('sort_order')->values()->all();

            return [
                'id' => $category->id, 'key' => $category->slug, 'label' => $category->name,
                'pages' => $pages, 'permissions' => $category->permissions->map($format)->all(),
            ];
        })->filter(fn ($module) => count($module['permissions']) > 0)->values()->all();
        $grantablePermissionKeys = $this->grantablePermissions($request->user());
        $canCreateRole = $request->user()->can('create.roles');
        $initialRoleId = (string) ($roles->firstWhere('name', 'admin')?->id ?? $roles->first()?->id ?? '');
        $workspaceEndpoints = ['storeUrl' => route('roles.store', [], false)];

        return view('roles.index', compact('workspaceRoles', 'workspaceModules', 'grantablePermissionKeys', 'canCreateRole', 'initialRoleId', 'workspaceEndpoints'));
    }

    private function workspaceRole(Role $role, User $actor): array
    {
        $role->loadMissing('permissions');
        if (! isset($role->users_count)) {
            $role->loadCount(['users' => fn ($query) => $query->visibleTo($actor)]);
        }

        return [
            'id' => (string) $role->id,
            'created_by' => $role->created_by,
            'key' => $role->name,
            'label' => $role->label ?? Str::headline($role->name),
            'description' => $role->description ?? '',
            'users_count' => (int) $role->users_count,
            'permissions' => $role->permissions->pluck('name')->all(),
            'editable' => $actor->can('update', $role),
            'is_system' => $role->isSystem(),
            'is_super' => $role->name === 'super_admin',
            'update_url' => route('roles.update', $role, false),
        ];
    }

    private function grantablePermissions(User $actor): array
    {
        return Permission::all()
            ->filter(fn (Permission $permission) => app(AccessManagement::class)->canGrant($actor, [$permission->name]))
            ->pluck('name')->values()->all();
    }

    private function savedResponse(Request $request, Role $role, string $message, int $status = 200)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
                'role' => $this->workspaceRole($role, $request->user()),
                'allowed_keys' => $this->grantablePermissions($request->user()),
                'can_create' => $request->user()->can('create.roles'),
            ], $status);
        }

        return redirect()->route('roles.index')->with('success', $message);
    }

    private function editor(Request $request, ?Role $role = null)
    {
        $categories = PermissionCategory::with(['permissions' => fn ($query) => $query->orderBy('name')])->orderBy('name')->get();
        $allowed = Permission::all()->filter(fn ($permission) => app(AccessManagement::class)->canGrant($request->user(), [$permission->name]))->pluck('name')->all();
        $rolePermissions = $role?->permissions()->pluck('name')->all() ?? [];

        return view('roles.form', compact('categories', 'allowed', 'role', 'rolePermissions'));
    }

    public function create(Request $request)
    {
        return $this->editor($request);
    }

    public function edit(Request $request, Role $role)
    {
        Gate::authorize('update', $role);

        return $this->editor($request, $role);
    }

    private function validated(Request $request, ?Role $role = null): array
    {
        $validated = $request->validate([
            'name' => array_filter(['required', 'string', 'max:100', $role ? null : 'regex:/^[a-z][a-z0-9_]*$/', Rule::unique('roles', 'name')->ignore($role?->id)]),
            'label' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'permissions' => ['sometimes', 'array'],
            'permissions.*' => ['string', 'distinct', 'exists:permissions,name'],
        ]);
        if ($role) {
            abort_unless($validated['name'] === $role->name, 422, 'Role keys stay stable; change the display name instead.');
        } else {
            abort_if(in_array($validated['name'], ['super_admin', 'teacher', 'student'], true), 422, 'This key is reserved for a system role.');
        }
        app(AccessManagement::class)->validatePermissions($request->user(), $validated['permissions'] ?? []);

        return $validated;
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);
        $role = DB::transaction(function () use ($validated) {
            $role = Role::create(collect($validated)->except('permissions')->all());
            $role->syncPermissions($validated['permissions'] ?? []);

            return $role;
        });

        return $this->savedResponse($request, $role, 'Role created successfully.', 201);
    }

    public function update(Request $request, Role $role)
    {
        Gate::authorize('update', $role);
        $validated = $this->validated($request, $role);
        DB::transaction(function () use ($role, $validated) {
            $role->update(collect($validated)->except('permissions')->all());
            $role->syncPermissions($validated['permissions'] ?? []);
        });

        return $this->savedResponse($request, $role, 'Permissions saved successfully.');
    }

    public function destroy(Role $role)
    {
        Gate::authorize('delete', $role);
        activity('authorization')->performedOn($role)->causedBy(auth()->user())->withProperties(['name' => $role->name])->log('Role deleted');
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }

    public function duplicate(Request $request, Role $role)
    {
        Gate::authorize('duplicate', $role);
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'regex:/^[a-z][a-z0-9_]*$/', 'unique:roles,name', Rule::notIn(['super_admin', 'teacher', 'student'])],
            'label' => ['required', 'string', 'max:255'],
        ]);
        $copy = DB::transaction(function () use ($role, $validated) {
            $copy = Role::create($validated + ['description' => $role->description]);
            $copy->syncPermissions($role->permissions);

            return $copy;
        });

        return redirect()->route('roles.edit', $copy)->with('success', 'Role copied.');
    }
}
