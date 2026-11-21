<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\PermissionCategory;
use App\Support\PermissionCatalog;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $categories = PermissionCategory::with(['permissions' => fn ($query) => $query->withCount(['roles', 'users'])->orderBy('name')])->orderBy('name')->get();

        return view('permissions.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150', 'regex:/^[a-z][a-z0-9_-]*\.[a-z][a-z0-9_-]*$/', 'unique:permissions,name'],
            'label' => ['required', 'string', 'max:255'],
            'permission_category_id' => ['required', 'integer', 'exists:permission_categories,id'],
        ]);
        $permission = Permission::create($validated);
        activity('authorization')->performedOn($permission)->causedBy($request->user())->withProperties($validated)->log('Permission created');

        return back()->with('success', 'Permission created.');
    }

    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'permission_category_id' => ['required', 'integer', 'exists:permission_categories,id'],
        ]);
        $before = $permission->only(['label', 'permission_category_id']);
        $permission->update($validated);
        activity('authorization')->performedOn($permission)->causedBy($request->user())
            ->withProperties(['before' => $before, 'after' => $validated])->log('Permission updated');

        return back()->with('success', 'Permission updated; existing grants preserved.');
    }

    public function destroy(Request $request, Permission $permission)
    {
        abort_if(array_key_exists($permission->name, PermissionCatalog::definitions()), 422, 'An application permission cannot be deleted.');
        abort_if($permission->roles()->exists() || $permission->users()->exists(), 422, 'Remove this permission from roles and users before deleting it.');
        activity('authorization')->performedOn($permission)->causedBy($request->user())->withProperties(['name' => $permission->name])->log('Permission deleted');
        $permission->delete();

        return back()->with('success', 'Permission deleted.');
    }
}
