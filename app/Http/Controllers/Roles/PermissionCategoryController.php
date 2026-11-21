<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Models\PermissionCategory;
use Illuminate\Http\Request;

class PermissionCategoryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:100', 'regex:/^[a-z][a-z0-9-]*$/', 'unique:permission_categories,slug'],
            'description' => ['nullable', 'string', 'max:2000'],
        ]);
        $category = PermissionCategory::create($validated);
        activity('authorization')->performedOn($category)->causedBy($request->user())->withProperties($validated)->log('Permission category created');

        return back()->with('success', 'Permission category created.');
    }

    public function update(Request $request, PermissionCategory $permissionCategory)
    {
        $validated = $request->validate(['name' => ['required', 'string', 'max:255'], 'description' => ['nullable', 'string', 'max:2000']]);
        $before = $permissionCategory->only(['name', 'description']);
        $permissionCategory->update($validated);
        activity('authorization')->performedOn($permissionCategory)->causedBy($request->user())
            ->withProperties(['before' => $before, 'after' => $validated])->log('Permission category updated');

        return back()->with('success', 'Permission category updated.');
    }

    public function destroy(Request $request, PermissionCategory $permissionCategory)
    {
        abort_if($permissionCategory->permissions()->exists(), 422, 'Move or remove permissions before deleting this category.');
        abort_if($permissionCategory->pages()->exists(), 422, 'Move or remove permission pages before deleting this category.');
        abort_if(array_key_exists($permissionCategory->slug, config('authorization.categories')), 422, 'An application category cannot be deleted.');
        activity('authorization')->performedOn($permissionCategory)->causedBy($request->user())->withProperties(['name' => $permissionCategory->name])->log('Permission category deleted');
        $permissionCategory->delete();

        return back()->with('success', 'Permission category deleted.');
    }
}
