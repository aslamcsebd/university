<?php

namespace Tests\Feature;

use App\Http\Middleware\AuthorizeModule;
use App\Models\Permission;
use App\Models\PermissionPage;
use App\Models\Role;
use App\Models\User;
use App\Support\PermissionCatalog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class PagePermissionTest extends TestCase
{
    use RefreshDatabase;

    private function userWith(array $permissions): User
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'page_reader_'.$user->id]);
        $role->syncPermissions($permissions);
        $user->assignRole($role->name);

        return $user;
    }

    public function test_page_grants_do_not_allow_sibling_pages_or_other_actions(): void
    {
        $reader = $this->userWith(['view.faculties']);
        $this->actingAs($reader)->get('/faculties')->assertOk();
        $this->get('/departments')->assertForbidden();
        $this->get('/faculties/create')->assertForbidden();
        $this->post('/faculties', ['name' => 'Forbidden'])->assertForbidden();
        $this->assertSame(['view.faculties'], PermissionCatalog::forRoute('faculties.index'));
        $reader->roles()->first()->syncPermissions([]);
        $this->get('/faculties')->assertForbidden();
    }

    public function test_dashboard_cards_require_both_card_and_data_permission_before_querying(): void
    {
        $reader = $this->userWith(['view.dashboard-students']);
        $queries = [];
        DB::listen(function ($query) use (&$queries) { $queries[] = $query->sql; });
        $this->actingAs($reader)->get('/dashboard')->assertOk()->assertDontSee('Total Students')
            ->assertViewHas('stats', fn ($stats) => $stats['students'] === null);
        $this->assertFalse(collect($queries)->contains(fn ($sql) => str_contains($sql, 'from "students"')));
        $reader->syncPermissions(['view.students']);
        $this->get('/dashboard')->assertOk()->assertSee('Total Students');
        $reader->roles()->first()->syncPermissions([]);
        $this->get('/dashboard')->assertOk()->assertDontSee('Total Students');
    }

    public function test_new_page_crud_permissions_register_in_order_without_assigning_grants(): void
    {
        $ordinary = $this->userWith(['view.users']);
        $before = DB::table('permission_role')->get()->toArray();
        $pages = config('authorization.pages');
        $pages['lab-tools'] = ['category' => 'academic', 'label' => 'Lab Tools'];
        $pages['lab-summary'] = ['category' => 'academic', 'label' => 'Lab Summary', 'prefixes' => ['labs.summary']];
        config(['authorization.pages' => $pages]);
        Route::middleware(['web', 'auth', AuthorizeModule::class])->group(function () {
            Route::get('/lab-tools', fn () => 'Lab Tools')->name('lab-tools.index');
            Route::post('/lab-tools', fn () => 'Created')->name('lab-tools.store');
            Route::post('/lab-tools/reset', fn () => 'Reset')->name('lab-tools.reset');
            Route::get('/lab-summary', fn () => 'Summary')->name('labs.summary');
        });
        $this->artisan('permissions:sync')->assertSuccessful();
        $this->assertDatabaseHas('permissions', ['name' => 'view.lab-tools']);
        $this->assertDatabaseHas('permissions', ['name' => 'create.lab-tools']);
        $this->assertDatabaseHas('permissions', ['name' => 'view.lab-summary']);
        $this->assertDatabaseMissing('permissions', ['name' => 'delete.lab-tools']);
        $this->assertDatabaseMissing('permissions', ['name' => 'reset.lab-tools']);
        $this->assertEquals($before, DB::table('permission_role')->get()->toArray());
        $this->assertFalse($ordinary->can('view.lab-tools'));
        $academic = PermissionPage::whereHas('category', fn ($query) => $query->where('slug', 'academic'))
            ->orderBy('sort_order')->pluck('key')->all();
        $this->assertSame(['lab-tools', 'lab-summary'], array_slice($academic, -2));
        $super = User::factory()->create();
        $super->assignRole('super_admin');
        $this->actingAs($super)->get('/lab-tools')->assertOk();
        $this->post('/lab-tools/reset')->assertForbidden();
    }

    public function test_existing_grants_are_upgraded_once_without_losing_keys_ids_or_direct_grants(): void
    {
        $reader = $this->userWith(['view.academic']);
        $reader->syncPermissions(['create.hr']);
        $oldId = Permission::where('name', 'view.academic')->value('id');
        $migration = require database_path('migrations/2026_11_21_000002_add_permission_page_groups.php');
        $migration->up();
        $this->assertSame($oldId, Permission::where('name', 'view.academic')->value('id'));
        $this->assertTrue($reader->can('view.faculties'));
        $this->assertTrue($reader->can('view.departments'));
        $this->assertTrue($reader->can('create.designations'));
        $reader->roles()->first()->syncPermissions(['view.academic']);
        $this->artisan('permissions:sync')->assertSuccessful();
        $this->assertFalse($reader->can('view.faculties'));
        $this->assertTrue($reader->can('create.designations'));
    }

    public function test_workspace_payload_groups_permissions_by_real_category_and_page_ids(): void
    {
        $super = User::factory()->create();
        $super->assignRole('super_admin');
        $this->actingAs($super)->get('/roles')->assertOk()->assertViewHas('workspaceModules', function ($modules) {
            $academic = collect($modules)->firstWhere('key', 'academic');
            $this->assertNotContains('create.academic', array_column($academic['permissions'], 'key'));
            $page = collect($academic['pages'])->firstWhere('key', 'faculties');
            $this->assertSame(PermissionPage::where('key', 'faculties')->value('id'), $page['id']);
            $this->assertSame(['view.faculties', 'create.faculties', 'edit.faculties', 'delete.faculties'], array_column($page['permissions'], 'key'));
            $dashboard = collect($modules)->firstWhere('key', 'dashboard');
            $this->assertCount(count(config('authorization.dashboard_cards')), $dashboard['permissions']);
            return true;
        });
    }

    public function test_generated_privileged_permissions_cannot_be_delegated_by_an_ordinary_administrator(): void
    {
        $actor = $this->userWith(['create.roles', 'create.permission-categories']);
        $this->actingAs($actor)->postJson('/roles', [
            'name' => 'forged_page_admin', 'label' => 'Forged', 'permissions' => ['create.permission-categories'],
        ])->assertUnprocessable()->assertJsonValidationErrors('permissions');
        $this->assertDatabaseMissing('roles', ['name' => 'forged_page_admin']);
    }

    public function test_generated_application_permissions_cannot_be_deleted(): void
    {
        $super = User::factory()->create();
        $super->assignRole('super_admin');
        $permission = Permission::where('name', 'view.faculties')->firstOrFail();
        $this->actingAs($super)->delete('/permissions/'.$permission->id)->assertUnprocessable();
    }
}
