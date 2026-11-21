<?php

namespace Tests\Feature;

use App\Http\Middleware\AuthorizeModule;
use App\Models\Designation;
use App\Models\Permission;
use App\Models\PermissionCategory;
use App\Models\Role;
use App\Models\User;
use App\Support\PermissionCatalog;
use Database\Seeders\CustomAuthorizationSeeder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CustomPermissionTest extends TestCase
{
    use RefreshDatabase;

    private function userWith(array $permissions): User
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'test_role_'.$user->id, 'label' => 'Test Role']);
        $role->syncPermissions($permissions);
        $user->assignRole($role->name);

        return $user;
    }

    private function superAdmin(): User
    {
        $this->seed(CustomAuthorizationSeeder::class);
        $user = User::factory()->create();
        $user->assignRole('super_admin');

        return $user;
    }

    public function test_schema_has_categories_and_explicit_foreign_keys(): void
    {
        $this->assertTrue(Schema::hasColumns('role_user', ['role_id', 'user_id']));
        $this->assertTrue(Schema::hasColumns('permission_role', ['permission_id', 'role_id']));
        $this->assertTrue(Schema::hasColumns('permission_user', ['permission_id', 'user_id']));
        $this->assertTrue(Schema::hasColumn('permissions', 'permission_category_id'));
        $this->assertSame(['role_id', 'user_id'], Schema::getColumnListing('role_user'));
        $this->assertSame(['id', 'name', 'label', 'description', 'created_at', 'updated_at', 'created_by'], Schema::getColumnListing('roles'));
    }

    public function test_every_application_route_has_a_registered_permission_rule(): void
    {
        foreach (Route::getRoutes() as $route) {
            if (! in_array(AuthorizeModule::class, $route->gatherMiddleware(), true)) {
                continue;
            }
            $required = PermissionCatalog::forRoute($route->getName());
            $this->assertNotNull($required, $route->getName().' needs an access rule');
            foreach ($required as $key) {
                $this->assertDatabaseHas('permissions', ['name' => $key]);
            }
        }
    }

    public function test_user_without_grants_can_use_personal_pages_but_not_modules(): void
    {
        $this->actingAs(User::factory()->create());
        $this->get('/dashboard')->assertOk()->assertDontSee('Total Users')->assertDontSee('Total Students');
        $this->get('/profile')->assertOk();
        foreach (['users', 'roles', 'permissions', 'students', 'admissions', 'library', 'marks', 'payroll', 'reports', 'settings/general'] as $path) {
            $this->get('/'.$path)->assertForbidden();
        }
    }

    public function test_read_permission_does_not_grant_create_or_delete_access(): void
    {
        $user = $this->userWith(['view.users']);
        $this->actingAs($user)->get('/users')->assertOk()->assertDontSee('Add User');
        $this->get('/users/create')->assertForbidden();
        $this->post('/users', ['name' => 'Forged User'])->assertForbidden();
        $this->delete('/users/'.$user->id)->assertForbidden();
    }

    public function test_multiple_roles_and_direct_grants_are_additive(): void
    {
        $user = $this->userWith(['view.users']);
        $other = Role::create(['name' => 'library_reader']);
        $other->syncPermissions(['view.library']);
        $user->assignRole('library_reader');
        $user->syncPermissions(['view.students']);
        $this->actingAs($user)->get('/users')->assertOk();
        $this->get('/library')->assertOk();
        $this->get('/students')->assertOk();
        $this->post('/library/books')->assertForbidden();
    }

    public function test_read_only_library_access_hides_complete_creation_cards(): void
    {
        $this->actingAs($this->userWith(['view.library']))->get('/library')->assertOk()
            ->assertDontSee('Add Book')->assertDontSee('Add Category');
    }

    public function test_read_only_hr_access_hides_inline_edit_forms_and_triggers(): void
    {
        $designation = Designation::create(['name' => 'Test Designation']);
        $this->actingAs($this->userWith(['view.designations']))->get('/designations')->assertOk()
            ->assertDontSee('edit-'.$designation->id)->assertDontSee('Add Designation');
    }

    public function test_revocation_takes_effect_on_the_next_request(): void
    {
        $user = $this->userWith(['view.users']);
        $this->actingAs($user)->get('/users')->assertOk();
        $user->roles()->first()->syncPermissions([]);
        $this->get('/users')->assertForbidden();
        $user->syncPermissions(['view.users']);
        $this->get('/users')->assertOk();
        $user->syncPermissions([]);
        $this->get('/users')->assertForbidden();
    }

    public function test_inactive_and_locked_accounts_cannot_use_existing_sessions(): void
    {
        $user = $this->userWith(['view.users']);
        $user->update(['is_active' => false]);
        $this->actingAs($user)->get('/dashboard')->assertForbidden();
        $this->get('/users')->assertForbidden();
        $user->update(['is_active' => true, 'locked_until' => now()->addHour()]);
        $this->get('/profile')->assertForbidden();
    }

    public function test_inactive_account_cannot_login(): void
    {
        $user = User::factory()->create(['is_active' => false]);
        $this->post('/login', ['email' => $user->email, 'password' => 'password'])->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_personal_theme_does_not_modify_global_settings(): void
    {
        $this->actingAs(User::factory()->create())->post('/theme', ['theme' => 'dark'])
            ->assertOk()->assertSessionHas('theme', 'dark');
        $this->assertDatabaseMissing('settings', ['key' => 'general.theme', 'value' => 'dark']);
    }

    public function test_even_super_admin_cannot_access_an_unregistered_route(): void
    {
        Route::middleware(['web', 'auth', AuthorizeModule::class])->get('/unregistered-test-action', fn () => 'allowed')->name('unregistered.test');
        $this->actingAs($this->superAdmin())->get('/unregistered-test-action')->assertForbidden();
    }

    public function test_assignment_cannot_promote_a_user_to_super_admin(): void
    {
        $this->seed(CustomAuthorizationSeeder::class);
        $actor = $this->userWith(['edit.users', 'assign.roles', 'view.students']);
        $target = $this->userWith(['view.students']);
        DB::table('users')->where('id', $target->id)->update(['created_by' => $actor->id]);
        $target->refresh();
        $this->actingAs($actor)->put('/users/'.$target->id, [
            'name' => $target->name, 'email' => $target->email,
            'roles' => ['super_admin'], 'is_active' => 1,
        ])->assertSessionHasErrors('roles');
        $this->assertFalse($target->hasRole('super_admin'));
    }

    public function test_role_editor_cannot_grant_permissions_the_actor_does_not_hold(): void
    {
        $actor = $this->userWith(['create.roles', 'edit.roles', 'view.roles', 'view.students']);
        $this->actingAs($actor)->post('/roles', [
            'name' => 'forged_role', 'label' => 'Forged Role', 'permissions' => ['approve.payroll'],
        ])->assertSessionHasErrors('permissions');
        $this->assertDatabaseMissing('roles', ['name' => 'forged_role']);
        $this->post('/roles', ['name' => 'legitimate_role', 'label' => 'Student Reader', 'permissions' => ['view.students']])->assertRedirect('/roles');
        $this->assertDatabaseHas('roles', ['name' => 'legitimate_role']);
    }

    public function test_privileged_permissions_require_super_admin_even_if_actor_holds_them(): void
    {
        $actor = $this->userWith(['create.roles', 'assign.roles']);
        $this->actingAs($actor)->post('/roles', [
            'name' => 'delegated_admin', 'label' => 'Delegated Admin', 'permissions' => ['assign.roles'],
        ])->assertSessionHasErrors('permissions');
    }

    public function test_non_super_admin_cannot_edit_a_super_admin_account(): void
    {
        $target = $this->superAdmin();
        $actor = $this->userWith(['edit.users', 'delete.users']);
        $this->actingAs($actor)->get('/users/'.$target->id.'/edit')->assertForbidden();
        $this->patch('/users/'.$target->id.'/toggle')->assertForbidden();
        $this->delete('/users/'.$target->id)->assertForbidden();
    }

    public function test_user_editor_cannot_reset_a_more_privileged_accounts_password(): void
    {
        $actor = $this->userWith(['edit.users']);
        $target = $this->userWith(['approve.payroll']);
        DB::table('users')->where('id', $target->id)->update(['created_by' => $actor->id]);
        $target->refresh();
        $this->actingAs($actor)->put('/users/'.$target->id, [
            'name' => $target->name, 'email' => $target->email,
            'password' => 'ForgedPassword123', 'roles' => $target->getRoleNames()->all(), 'is_active' => 1,
        ])->assertForbidden();
        $this->assertFalse(Hash::check('ForgedPassword123', $target->fresh()->password));
    }

    public function test_last_active_super_admin_cannot_be_demoted_or_deactivated(): void
    {
        $actor = $this->superAdmin();
        $this->actingAs($actor)->put('/users/'.$actor->id, [
            'name' => $actor->name, 'email' => $actor->email, 'roles' => ['student'], 'is_active' => 1,
        ])->assertSessionHasErrors('roles');
        $this->assertTrue($actor->fresh()->isSuperAdmin());
        $this->put('/users/'.$actor->id, [
            'name' => $actor->name, 'email' => $actor->email, 'roles' => ['super_admin'], 'is_active' => 0,
        ])->assertSessionHasErrors('roles');
        $this->assertTrue($actor->fresh()->is_active);
    }

    public function test_last_super_admin_cannot_delete_their_profile(): void
    {
        $actor = $this->superAdmin();
        $this->actingAs($actor)->delete('/profile', ['password' => 'password'])->assertSessionHasErrors('roles');
        $this->assertAuthenticatedAs($actor);
        $this->assertFalse($actor->fresh()->trashed());
    }

    public function test_system_roles_and_assigned_roles_cannot_be_deleted(): void
    {
        $actor = $this->superAdmin();
        $this->actingAs($actor);
        foreach (['super_admin', 'teacher', 'student'] as $name) {
            $role = Role::where('name', $name)->firstOrFail();
            $this->delete('/roles/'.$role->id)->assertForbidden();
        }
        $role = $this->userWith([])->roles()->first();
        $this->delete('/roles/'.$role->id)->assertForbidden();
    }

    public function test_system_role_key_cannot_be_renamed(): void
    {
        $actor = $this->superAdmin();
        $role = Role::where('name', 'teacher')->firstOrFail();
        $this->actingAs($actor)->put('/roles/'.$role->id, ['name' => 'renamed_teacher', 'label' => 'Teacher'])->assertUnprocessable();
        $this->assertDatabaseHas('roles', ['id' => $role->id, 'name' => 'teacher']);
    }

    public function test_legacy_role_keys_can_be_kept_while_their_display_names_change(): void
    {
        $actor = $this->superAdmin();
        $role = Role::create(['name' => 'Legacy Reader', 'label' => 'Old Label']);
        $this->actingAs($actor)->put('/roles/'.$role->id, ['name' => 'Legacy Reader', 'label' => 'New Label'])->assertRedirect();
        $this->assertDatabaseHas('roles', ['id' => $role->id, 'name' => 'Legacy Reader', 'label' => 'New Label']);
    }

    public function test_category_and_permission_labels_can_change_without_losing_access(): void
    {
        $actor = $this->superAdmin();
        $category = PermissionCategory::create(['name' => 'Student Services', 'slug' => 'student-services']);
        $permission = Permission::where('name', 'view.students')->firstOrFail();
        $reader = $this->userWith(['view.students']);
        $this->actingAs($actor)->put('/permissions/'.$permission->id, [
            'label' => 'Read Student Records', 'permission_category_id' => $category->id,
        ])->assertRedirect();
        $this->assertTrue($reader->can('view.students'));
        $this->assertDatabaseHas('permissions', ['id' => $permission->id, 'name' => 'view.students', 'permission_category_id' => $category->id]);
    }

    public function test_permissions_and_categories_have_complete_management_actions(): void
    {
        $this->actingAs($this->superAdmin());
        $this->post('/permission-categories', ['name' => 'Custom Module', 'slug' => 'custom-module'])->assertRedirect();
        $category = PermissionCategory::where('slug', 'custom-module')->firstOrFail();
        $this->post('/permissions', ['name' => 'view.custom-module', 'label' => 'View Custom Module', 'permission_category_id' => $category->id])->assertRedirect();
        $permission = Permission::where('name', 'view.custom-module')->firstOrFail();
        $this->delete('/permission-categories/'.$category->id)->assertUnprocessable();
        $this->put('/permission-categories/'.$category->id, ['name' => 'Renamed Module'])->assertRedirect();
        $this->delete('/permissions/'.$permission->id)->assertRedirect();
        $this->delete('/permission-categories/'.$category->id)->assertRedirect();
    }

    public function test_application_and_assigned_permissions_cannot_be_deleted(): void
    {
        $actor = $this->superAdmin();
        $permission = Permission::where('name', 'view.students')->firstOrFail();
        $this->actingAs($actor)->delete('/permissions/'.$permission->id)->assertUnprocessable();
        $category = PermissionCategory::first();
        $custom = Permission::create(['name' => 'view.custom-module', 'label' => 'Custom', 'permission_category_id' => $category->id]);
        $this->userWith(['view.custom-module']);
        $this->delete('/permissions/'.$custom->id)->assertUnprocessable();
    }

    public function test_permission_keys_cannot_shadow_policy_abilities(): void
    {
        $this->actingAs($this->superAdmin())->post('/permissions', [
            'name' => 'update', 'label' => 'Invalid Key', 'permission_category_id' => PermissionCategory::first()->id,
        ])->assertSessionHasErrors('name');
        $this->assertDatabaseMissing('permissions', ['name' => 'update']);
    }

    public function test_role_duplication_and_empty_permission_selection_work(): void
    {
        $actor = $this->superAdmin();
        $role = Role::create(['name' => 'source_role', 'label' => 'Source Role']);
        $role->syncPermissions(['view.students']);
        $this->actingAs($actor)->post('/roles/'.$role->id.'/duplicate', ['name' => 'copied_role', 'label' => 'Copied Role'])->assertRedirect();
        $copy = Role::where('name', 'copied_role')->firstOrFail();
        $this->assertTrue($copy->permissions->contains('name', 'view.students'));
        $this->put('/roles/'.$copy->id, ['name' => 'copied_role', 'label' => 'Copied Role'])->assertRedirect();
        $this->assertCount(0, $copy->fresh()->permissions);
    }

    public function test_workspace_creates_an_empty_role_then_saves_its_permissions(): void
    {
        $this->actingAs($this->superAdmin());
        $created = $this->postJson('/roles', ['name' => 'workspace_manager', 'label' => 'Workspace Manager', 'permissions' => []])
            ->assertCreated()->assertJsonPath('role.permissions', [])->assertJsonPath('role.editable', true);
        $role = Role::where('name', 'workspace_manager')->firstOrFail();
        $created->assertJsonPath('role.id', (string) $role->id)->assertJsonPath('role.users_count', 0);
        $this->assertCount(0, $role->permissions);
        $this->putJson('/roles/'.$role->id, [
            'name' => $role->name, 'label' => $role->label, 'permissions' => ['view.students', 'view.library'],
        ])->assertOk()->assertJsonCount(2, 'role.permissions')->assertJsonPath('role.update_url', '/roles/'.$role->id);
        $this->assertEqualsCanonicalizing(['view.students', 'view.library'], $role->fresh()->permissions->pluck('name')->all());
        $this->get('/roles')->assertOk()->assertSee('Workspace Manager');
    }

    public function test_workspace_can_clear_all_permissions_and_revoke_access(): void
    {
        $actor = $this->superAdmin();
        $reader = $this->userWith(['view.students']);
        $role = $reader->roles()->first();
        $this->actingAs($actor)->putJson('/roles/'.$role->id, [
            'name' => $role->name, 'label' => $role->label, 'permissions' => [],
        ])->assertOk()->assertJsonPath('role.permissions', []);
        $this->assertCount(0, $role->fresh()->permissions);
        $this->actingAs($reader)->get('/students')->assertForbidden();
    }

    public function test_workspace_json_requests_cannot_grant_unowned_permissions_or_change_super_admin(): void
    {
        $super = $this->superAdmin();
        $actor = $this->userWith(['create.roles', 'edit.roles', 'view.roles', 'view.students']);
        $this->actingAs($actor)->postJson('/roles', [
            'name' => 'workspace_forged', 'label' => 'Forged', 'permissions' => ['approve.payroll'],
        ])->assertUnprocessable()->assertJsonValidationErrors('permissions');
        $this->assertDatabaseMissing('roles', ['name' => 'workspace_forged']);
        $role = Role::where('name', 'super_admin')->firstOrFail();
        $this->actingAs($super)->putJson('/roles/'.$role->id, [
            'name' => $role->name, 'label' => $role->label, 'permissions' => [],
        ])->assertForbidden();
    }

    public function test_workspace_view_only_user_cannot_create_or_save_roles(): void
    {
        $viewer = $this->userWith(['view.roles']);
        $role = $viewer->roles()->first();
        $this->actingAs($viewer)->get('/roles')->assertOk();
        $this->postJson('/roles', ['name' => 'workspace_denied', 'label' => 'Denied'])->assertForbidden();
        $this->putJson('/roles/'.$role->id, [
            'name' => $role->name, 'label' => $role->label, 'permissions' => [],
        ])->assertForbidden();
        $this->assertSame(['view.roles'], $role->fresh()->permissions->pluck('name')->all());
    }

    public function test_direct_permission_editor_updates_effective_access_and_audit_log(): void
    {
        $actor = $this->superAdmin();
        $target = $this->userWith([]);
        $this->actingAs($actor)->put('/users/'.$target->id.'/permissions', ['permissions' => ['view.students']])->assertRedirect();
        $this->assertTrue($target->can('view.students'));
        $this->get('/users/'.$target->id)->assertOk()->assertSee('Direct grant');
        $this->put('/users/'.$target->id.'/permissions', [])->assertRedirect();
        $this->assertFalse($target->can('view.students'));
        $this->assertDatabaseHas('activity_log', ['log_name' => 'authorization', 'description' => 'User direct permissions updated']);
    }

    public function test_reports_require_report_and_subject_module_permissions(): void
    {
        $user = $this->userWith(['view.reports-students']);
        $this->actingAs($user)->get('/reports/students')->assertForbidden();
        $user->syncPermissions(['view.students']);
        $this->get('/reports/students')->assertOk();
    }

    public function test_seeders_preserve_customized_role_grants_and_labels(): void
    {
        $this->seed(CustomAuthorizationSeeder::class);
        $role = Role::where('name', 'library_manager')->firstOrFail();
        $role->syncPermissions(['view.library']);
        $role->update(['label' => 'Custom Library Reader']);
        $this->seed(CustomAuthorizationSeeder::class);
        $this->assertSame(['view.library'], $role->fresh()->permissions->pluck('name')->all());
        $this->assertSame('Custom Library Reader', $role->fresh()->label);
    }

    public function test_permission_backup_contains_authorization_data_without_passwords(): void
    {
        Storage::fake('local');
        $this->userWith(['view.students']);
        $this->artisan('permissions:backup')->assertSuccessful();
        $disk = Storage::disk('local');
        $files = $disk->files('authorization-backups');
        $this->assertCount(1, $files);
        $backup = json_decode($disk->get($files[0]), true, flags: JSON_THROW_ON_ERROR);
        $this->assertNotEmpty($backup['tables']['role_user']);
        $this->assertArrayNotHasKey('users', $backup['tables']);
        $this->assertStringNotContainsString('password', $disk->get($files[0]));
    }

    public function test_user_and_role_editors_render_for_authorized_users(): void
    {
        $actor = $this->superAdmin();
        $role = Role::where('name', 'teacher')->firstOrFail();
        $this->actingAs($actor)->get('/roles/create')->assertOk()->assertSee('Module permissions');
        $this->get('/roles/'.$role->id.'/edit')->assertOk();
        $this->get('/permissions')->assertOk()->assertSee('Add Category');
        $this->get('/users/'.$actor->id)->assertOk()->assertSee('Effective Permissions');
    }

    public function test_custom_schema_setup_preserves_existing_ids_and_grants(): void
    {
        $user = $this->userWith(['view.students']);
        $user->syncPermissions(['view.library']);
        $role = $user->roles()->first();
        $permission = Permission::where('name', 'view.students')->firstOrFail();
        $migration = require database_path('migrations/2026_11_21_000000_create_custom_permission_tables.php');
        $migration->up();
        $this->assertDatabaseHas('roles', ['id' => $role->id, 'name' => $role->name]);
        $this->assertDatabaseHas('permissions', ['id' => $permission->id, 'name' => 'view.students']);
        $this->assertDatabaseHas('role_user', ['role_id' => $role->id, 'user_id' => $user->id]);
        $this->assertTrue($user->can('view.students'));
        $this->assertTrue($user->can('view.library'));
    }

    public function test_obsolete_table_cleanup_backs_up_rows_and_preserves_custom_grants(): void
    {
        Storage::fake('local');
        $user = $this->userWith(['view.students']);
        $user->syncPermissions(['view.library']);
        Schema::create('legacy_roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        Schema::create('legacy_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        Schema::create('legacy_role_has_permissions', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained('legacy_roles');
            $table->foreignId('permission_id')->constrained('legacy_permissions');
            $table->primary(['role_id', 'permission_id']);
        });
        foreach (['legacy_model_has_roles', 'legacy_model_has_permissions'] as $table) {
            Schema::create($table, fn (Blueprint $table) => $table->id());
        }
        DB::table('legacy_roles')->insert(['id' => 42, 'name' => 'obsolete_reader']);
        DB::table('legacy_permissions')->insert(['id' => 51, 'name' => 'view.students']);
        DB::table('legacy_role_has_permissions')->insert(['role_id' => 42, 'permission_id' => 51]);
        $migration = require database_path('migrations/2026_11_21_000001_remove_obsolete_authorization_tables.php');
        $migration->up();
        foreach (['legacy_roles', 'legacy_permissions', 'legacy_role_has_permissions', 'legacy_model_has_roles', 'legacy_model_has_permissions'] as $table) {
            $this->assertFalse(Schema::hasTable($table));
        }
        $this->assertTrue($user->can('view.students'));
        $this->assertTrue($user->can('view.library'));
        $disk = Storage::disk('local');
        $files = $disk->files('authorization-backups');
        $this->assertCount(1, $files);
        $backup = json_decode($disk->get($files[0]), true, flags: JSON_THROW_ON_ERROR);
        $this->assertSame('obsolete_reader', $backup['tables']['legacy_roles']['rows'][0]['name']);
        $this->assertNotEmpty($backup['tables']['legacy_role_has_permissions']['foreign_keys']);
        $migration->down();
        $this->assertTrue($user->can('view.students'));
        $this->assertTrue(Schema::hasTable('role_user'));
    }

    public function test_cleanup_consolidates_history_without_rolling_back_current_schema(): void
    {
        $custom = '2026_11_21_000000_create_custom_permission_tables';
        $oldCreation = '2026_11_14_064657_create_permission_tables';
        $oldConversion = '2026_11_21_000000_convert_to_custom_permissions';
        DB::table('migrations')->insert(['migration' => $oldCreation, 'batch' => 4]);
        DB::table('migrations')->insert(['migration' => $oldConversion, 'batch' => 5]);
        DB::table('migrations')->where('migration', $custom)->update(['batch' => 6]);
        $migration = require database_path('migrations/2026_11_21_000001_remove_obsolete_authorization_tables.php');
        $migration->up();
        $this->assertDatabaseHas('migrations', ['migration' => $custom, 'batch' => 5]);
        $this->assertDatabaseMissing('migrations', ['migration' => $oldCreation]);
        $this->assertDatabaseMissing('migrations', ['migration' => $oldConversion]);
        $this->assertTrue(Schema::hasTable('roles'));
        $this->assertTrue(Schema::hasTable('permission_role'));
    }
}
