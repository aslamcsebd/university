<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Services\AccessManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::visibleTo($request->user())->with(['roles' => fn ($query) => $query->visibleTo($request->user())])->latest();
        if ($request->filled('search')) {
            $query->where(fn ($query) => $query->where('name', 'like', '%'.$request->search.'%')->orWhere('email', 'like', '%'.$request->search.'%'));
        }
        if ($request->filled('role')) {
            $query->whereHas('roles', fn ($query) => $query->visibleTo($request->user())->where('name', $request->role));
        }
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }
        $users = $query->paginate(20)->withQueryString();
        $roles = Role::visibleTo($request->user())->orderBy('name')->get();

        return view('users.index', compact('users', 'roles'));
    }

    public function create(Request $request)
    {
        $roles = app(AccessManagement::class)->assignableRoles($request->user());

        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', Password::min(8)->mixedCase()->numbers()],
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['string', 'distinct', 'exists:roles,name'],
            'is_active' => ['sometimes', 'boolean'],
        ]);
        app(AccessManagement::class)->validateRoles($request->user(), $validated['roles']);
        DB::transaction(function () use ($request, $validated) {
            $user = User::create([
                'name' => $validated['name'], 'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'is_active' => $request->boolean('is_active'), 'email_verified_at' => now(),
            ]);
            $user->syncRoles($validated['roles']);
        });

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function show(Request $request, User $user)
    {
        Gate::authorize('view', $user);
        $user->load(['roles' => fn ($query) => $query->visibleTo($request->user())->with('permissions'), 'permissions']);
        $effectivePermissions = $user->isSuperAdmin() ? Permission::with('category')->orderBy('name')->get() : $user->getAllPermissions();
        $grantablePermissions = Permission::with('category')->orderBy('name')->get()
            ->filter(fn ($permission) => app(AccessManagement::class)->canGrant($request->user(), [$permission->name]));
        $loginAudits = $user->loginAudits()->latest()->take(10)->get();

        return view('users.show', compact('user', 'loginAudits', 'effectivePermissions', 'grantablePermissions'));
    }

    public function edit(Request $request, User $user)
    {
        Gate::authorize('update', $user);
        $roles = app(AccessManagement::class)->assignableRoles($request->user())
            ->merge($user->roles()->visibleTo($request->user())->get())->unique('id')->sortBy('name');

        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        Gate::authorize('update', $user);
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', Password::min(8)->mixedCase()->numbers()],
            'roles' => ['sometimes', 'array'],
            'roles.*' => ['string', 'distinct', 'exists:roles,name'],
            'is_active' => ['sometimes', 'boolean'],
        ]);
        $currentRoles = $user->getRoleNames()->all();
        // Existing foreign/system roles stay intact without exposing their names.
        $foreignRoles = $request->user()->isSuperAdmin() ? [] : $user->roles()
            ->where(fn ($query) => $query->whereNull('roles.created_by')->orWhere('roles.created_by', '!=', $request->user()->id))
            ->pluck('name')->all();
        $validated['roles'] = array_values(array_unique([...($validated['roles'] ?? []), ...$foreignRoles]));
        if (! $validated['roles']) {
            throw ValidationException::withMessages(['roles' => 'Select at least one role.']);
        }
        $rolesChanged = collect($currentRoles)->sort()->values()->all() !== collect($validated['roles'])->sort()->values()->all();
        if ($rolesChanged) {
            abort_unless($request->user()->can('assign.roles'), 403);
            app(AccessManagement::class)->validateRoles($request->user(), array_values(array_diff($validated['roles'], $currentRoles)));
        }
        DB::transaction(function () use ($request, $user, $validated, $rolesChanged) {
            app(AccessManagement::class)->protectAdministrator($user, $validated['roles'], $request->boolean('is_active'));
            $data = ['name' => $validated['name'], 'email' => $validated['email'], 'is_active' => $request->boolean('is_active')];
            if (! empty($validated['password'])) {
                $data['password'] = Hash::make($validated['password']);
            }
            $user->update($data);
            if ($rolesChanged) {
                $user->syncRoles($validated['roles']);
            }
        });

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        Gate::authorize('delete', $user);
        DB::transaction(function () use ($user) {
            app(AccessManagement::class)->protectAdministrator($user, [], false);
            $user->delete();
        });

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function toggleStatus(Request $request, User $user)
    {
        Gate::authorize('update', $user);
        abort_if($request->user()->id === $user->id, 422, 'You cannot deactivate your own account.');
        DB::transaction(function () use ($user) {
            app(AccessManagement::class)->protectAdministrator($user, $user->getRoleNames()->all(), ! $user->is_active);
            $user->update(['is_active' => ! $user->is_active]);
        });

        return back()->with('success', 'User status updated.');
    }

    public function permissions(Request $request, User $user)
    {
        Gate::authorize('update', $user);
        abort_if($user->hasRole('super_admin'), 422, 'Super administrator access is managed through the system role.');
        $validated = $request->validate(['permissions' => ['sometimes', 'array'], 'permissions.*' => ['string', 'distinct', 'exists:permissions,name']]);
        $keys = $validated['permissions'] ?? [];
        app(AccessManagement::class)->validatePermissions($request->user(), $keys);
        DB::transaction(fn () => $user->syncPermissions($keys));

        return back()->with('success', 'Direct permissions updated.');
    }
}
