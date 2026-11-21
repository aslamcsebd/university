<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Services\AccessManagement;
use App\Support\PermissionCatalog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class CreatorPermissionTest extends TestCase
{
    use RefreshDatabase;

    private function manager(array $keys): User
    {
        $actor = User::factory()->create();
        $role = Role::create(['name' => 'manager_'.$actor->id]);
        $role->syncPermissions($keys);
        $actor->assignRole($role->name);

        return $actor;
    }

    private function roleFor(User $creator, array $keys = [], string $label = 'Owned role'): Role
    {
        $previous = Auth::user();
        Auth::setUser($creator);
        $role = Role::create(['name' => 'owned_'.bin2hex(random_bytes(4)), 'label' => $label]);
        $role->syncPermissions($keys);
        $previous ? Auth::setUser($previous) : Auth::forgetUser();

        return $role;
    }

    private function userFor(User $creator, Role $role): User
    {
        $previous = Auth::user();
        Auth::setUser($creator);
        $user = User::factory()->create();
        $user->assignRole($role->name);
        $previous ? Auth::setUser($previous) : Auth::forgetUser();

        return $user;
    }

    public function test_a_manager_with_100_permissions_can_only_delegate_a_subset_of_those_keys(): void
    {
        $required = ['view.roles', 'create.roles', 'edit.roles', 'view.users', 'create.users', 'edit.users', 'assign.roles'];
        $keys = collect(PermissionCatalog::activeKeys())->reject(fn ($key) => PermissionCatalog::isPrivileged($key))
            ->merge($required)->unique()->values();
        $owned = array_values(array_unique([...$required, ...$keys->diff($required)->take(100 - count($required))->all()]));
        $actor = $this->manager($owned);
        $this->assertCount(100, $actor->getAllPermissions());
        $unowned = $keys->diff($owned)->first();
        $this->assertNotNull($unowned);
        $delegated = collect($owned)->reject(fn ($key) => PermissionCatalog::isPrivileged($key))->take(20)->values()->all();
        $this->actingAs($actor)->postJson('/roles', [
            'name' => 'valid_subset', 'label' => 'Valid subset', 'permissions' => $delegated,
        ])->assertCreated()->assertJsonPath('role.created_by', $actor->id);
        $childRole = Role::where('name', 'valid_subset')->firstOrFail();
        $this->putJson('/roles/'.$childRole->id, [
            'name' => $childRole->name, 'label' => $childRole->label, 'permissions' => [$unowned],
        ])->assertUnprocessable()->assertJsonValidationErrors('permissions');
        $this->assertEqualsCanonicalizing($delegated, $childRole->fresh()->permissions->pluck('name')->all());
        $child = $this->userFor($actor, $childRole);
        $this->put('/users/'.$child->id.'/permissions', ['permissions' => [$unowned]])->assertSessionHasErrors('permissions');
        $this->assertCount(0, $child->fresh()->permissions);
        $this->put('/users/'.$child->id.'/permissions', ['permissions' => [$delegated[0]]])->assertRedirect();
        $this->assertSame([$delegated[0]], $child->fresh()->permissions->pluck('name')->all());
    }

    public function test_role_workspace_only_sends_the_managers_own_permissions_and_grantable_limit(): void
    {
        $assignable = collect(PermissionCatalog::activeKeys())->reject(fn ($key) => PermissionCatalog::isPrivileged($key))->take(17)->values()->all();
        $ownKeys = [...$assignable, 'view.roles', 'create.roles', 'edit.roles'];
        $actor = $this->manager($ownKeys);
        $this->roleFor($actor, $assignable, 'Library subset');
        $this->actingAs($actor)->get('/roles')->assertOk()->assertSee('My permissions')
            ->assertViewHas('grantablePermissionKeys', fn ($keys) => collect($keys)->sort()->values()->all() === collect($assignable)->sort()->values()->all())
            ->assertViewHas('workspaceModules', function ($modules) use ($ownKeys) {
                $sent = collect($modules)->flatMap(fn ($module) => $module['permissions'])->pluck('key')->sort()->values()->all();
                $this->assertSame(collect($ownKeys)->sort()->values()->all(), $sent);
                foreach ($modules as $module) {
                    foreach ($module['pages'] as $page) {
                        $this->assertNotEmpty($page['permissions']);
                        $this->assertEmpty(array_diff(array_column($page['permissions'], 'key'), $ownKeys));
                    }
                }
                return true;
            });
    }

    public function test_lists_and_role_dropdowns_only_include_directly_created_records(): void
    {
        $actor = $this->manager(['view.users', 'view.roles', 'create.users', 'assign.roles', 'view.students']);
        $other = $this->manager(['view.students']);
        $ownRole = $this->roleFor($actor, ['view.students'], 'Own role only');
        $foreignRole = $this->roleFor($other, ['view.students'], 'Foreign role hidden');
        $ownUser = $this->userFor($actor, $ownRole);
        $foreignUser = $this->userFor($other, $foreignRole);
        $this->actingAs($actor)->get('/users')->assertOk()->assertSee($ownUser->email)->assertDontSee($foreignUser->email)
            ->assertDontSee('Foreign role hidden')->assertViewHas('users', fn ($users) => $users->total() === 1);
        $this->get('/roles')->assertOk()->assertSee('Own role only')->assertDontSee('Foreign role hidden')
            ->assertViewHas('workspaceRoles', fn ($roles) => count($roles) === 1);
        $this->get('/users/create')->assertOk()->assertViewHas('roles', fn ($roles) => $roles->modelKeys() === [$ownRole->id]);
    }

    public function test_foreign_record_urls_and_mutations_are_denied_even_with_management_permissions(): void
    {
        $actor = $this->manager(['view.users', 'edit.users', 'delete.users', 'assign.roles', 'view.roles', 'edit.roles', 'delete.roles', 'duplicate.roles', 'view.students']);
        $other = $this->manager(['view.students']);
        $foreignRole = $this->roleFor($other, ['view.students']);
        $foreignUser = $this->userFor($other, $foreignRole);
        $this->actingAs($actor)->get('/users/'.$foreignUser->id)->assertForbidden();
        $this->get('/users/'.$foreignUser->id.'/edit')->assertForbidden();
        $this->put('/users/'.$foreignUser->id, [])->assertForbidden();
        $this->put('/users/'.$foreignUser->id.'/permissions', ['permissions' => ['view.students']])->assertForbidden();
        $this->patch('/users/'.$foreignUser->id.'/toggle')->assertForbidden();
        $this->delete('/users/'.$foreignUser->id)->assertForbidden();
        $this->get('/roles/'.$foreignRole->id.'/edit')->assertForbidden();
        $this->putJson('/roles/'.$foreignRole->id, [])->assertForbidden();
        $this->post('/roles/'.$foreignRole->id.'/duplicate', ['name' => 'forged_copy', 'label' => 'Forged'])->assertForbidden();
        $this->delete('/roles/'.$foreignRole->id)->assertForbidden();
        $this->assertDatabaseHas('roles', ['id' => $foreignRole->id]);
        $this->assertDatabaseHas('users', ['id' => $foreignUser->id, 'deleted_at' => null]);
    }

    public function test_creator_is_stamped_server_side_and_foreign_roles_cannot_be_assigned(): void
    {
        $actor = $this->manager(['create.roles', 'create.users', 'assign.roles', 'view.students']);
        $other = $this->manager(['view.students']);
        $foreign = $this->roleFor($other, ['view.students']);
        $this->actingAs($actor)->postJson('/roles', [
            'name' => 'stamped_role', 'label' => 'Stamped', 'permissions' => ['view.students'], 'created_by' => $other->id,
        ])->assertCreated()->assertJsonPath('role.created_by', $actor->id);
        $data = ['name' => 'Child account', 'email' => 'owned-child@example.test', 'password' => 'SecurePass123', 'is_active' => true, 'created_by' => $other->id];
        $this->post('/users', $data + ['roles' => [$foreign->name]])->assertSessionHasErrors('roles');
        $this->assertDatabaseMissing('users', ['email' => $data['email']]);
        $role = Role::where('name', 'stamped_role')->firstOrFail();
        $this->post('/users', $data + ['roles' => [$role->name]])->assertRedirect();
        $this->assertDatabaseHas('users', ['email' => $data['email'], 'created_by' => $actor->id]);
    }

    public function test_ownership_does_not_replace_module_permission_or_grant_ceiling(): void
    {
        $actor = $this->manager(['view.users', 'edit.users']);
        $ownedRole = $this->roleFor($actor, ['approve.payroll']);
        $child = $this->userFor($actor, $ownedRole);
        $this->actingAs($actor)->get('/users/'.$child->id)->assertOk();
        $this->put('/users/'.$child->id, [])->assertForbidden();
        $actor->roles()->first()->syncPermissions([]);
        $this->get('/users/'.$child->id)->assertForbidden();
    }

    public function test_super_admin_can_see_records_with_other_or_unknown_creators(): void
    {
        $super = User::factory()->create();
        $super->assignRole('super_admin');
        $legacy = User::factory()->create();
        $legacyRole = Role::create(['name' => 'unknown_creator_role', 'label' => 'Unknown creator']);
        $this->actingAs($super)->get('/users/'.$legacy->id)->assertOk();
        $this->get('/roles')->assertOk()->assertSee('Unknown creator');
        $this->get('/roles/'.$legacyRole->id.'/edit')->assertOk();
    }

    public function test_dashboard_user_and_role_records_and_counts_use_creator_scope(): void
    {
        $actor = $this->manager(['view.users', 'view.roles', 'view.students', 'view.dashboard-recent-users', 'view.dashboard-system-info']);
        $other = $this->manager([]);
        $role = $this->roleFor($actor, ['view.students']);
        $own = $this->userFor($actor, $role);
        $foreignRole = $this->roleFor($other);
        $foreign = $this->userFor($other, $foreignRole);
        $this->actingAs($actor)->get('/dashboard')->assertOk()->assertSee($own->email)->assertDontSee($foreign->email)
            ->assertViewHas('userCount', 1)->assertViewHas('roleCount', 1);
    }

    public function test_legacy_creator_backfill_uses_creation_events_not_edit_events(): void
    {
        $actor = $this->manager([]);
        $knownRole = $this->roleFor($actor);
        $knownUser = $this->userFor($actor, $knownRole);
        DB::table('roles')->where('id', $knownRole->id)->update(['created_by' => null]);
        DB::table('users')->where('id', $knownUser->id)->update(['created_by' => null]);
        $unknown = Role::create(['name' => 'edited_not_created']);
        $this->actingAs($actor);
        $unknown->syncPermissions([]);
        $migration = require database_path('migrations/2026_11_21_000003_add_user_role_creators.php');
        $migration->up();
        $this->assertDatabaseHas('roles', ['id' => $knownRole->id, 'created_by' => $actor->id]);
        $this->assertDatabaseHas('users', ['id' => $knownUser->id, 'created_by' => $actor->id]);
        $this->assertDatabaseHas('roles', ['id' => $unknown->id, 'created_by' => null]);
    }

    public function test_creator_cannot_be_changed_and_authenticated_factory_creation_records_creator(): void
    {
        $actor = $this->manager([]);
        $role = $this->roleFor($actor);
        $this->expectException(ValidationException::class);
        $role->forceFill(['created_by' => null])->save();
    }

    public function test_teacher_default_role_cannot_add_permissions_the_creator_does_not_have(): void
    {
        $actor = $this->manager(['create.teachers']);
        $this->expectException(ValidationException::class);
        app(AccessManagement::class)->validateDefaultRole($actor, 'teacher');
    }

    public function test_foreign_existing_roles_are_hidden_and_preserved_when_updating_an_owned_user(): void
    {
        $actor = $this->manager(['view.users', 'edit.users', 'assign.roles', 'view.students']);
        $other = $this->manager([]);
        $foreignRole = $this->roleFor($other, ['view.students'], 'Existing foreign role');
        $child = $this->userFor($actor, $foreignRole);
        $this->actingAs($actor)->get('/users/'.$child->id.'/edit')->assertOk()->assertDontSee('Existing foreign role');
        $this->put('/users/'.$child->id, ['name' => 'Updated owned account', 'email' => $child->email, 'is_active' => true])->assertRedirect();
        $this->assertSame([$foreignRole->name], $child->fresh()->getRoleNames()->all());
        $this->assertDatabaseHas('users', ['id' => $child->id, 'name' => 'Updated owned account', 'created_by' => $actor->id]);
    }
}
