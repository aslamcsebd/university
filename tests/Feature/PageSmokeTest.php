<?php

namespace Tests\Feature;

use App\Models\AcademicSession;
use App\Models\AdmissionApplication;
use App\Models\Batch;
use App\Models\Building;
use App\Models\Campus;
use App\Models\Course;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\GradingSystem;
use App\Models\Hostel;
use App\Models\Program;
use App\Models\Role;
use App\Models\Room;
use App\Models\Staff;
use App\Models\Student;
use App\Models\User;
use Database\Seeders\CustomAuthorizationSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;
use Throwable;

class PageSmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_controller_route_actions_exist(): void
    {
        $missingActions = collect(Route::getRoutes())
            ->map(function ($route) {
                $action = $route->getActionName();

                if ($action === 'Closure') {
                    return null;
                }

                [$controller, $method] = str_contains($action, '@')
                    ? explode('@', $action, 2)
                    : [$action, '__invoke'];

                return method_exists($controller, $method)
                    ? null
                    : sprintf('%s points to missing action %s', $route->uri(), $action);
            })
            ->filter()
            ->values()
            ->all();

        $this->assertSame([], $missingActions, implode(PHP_EOL, $missingActions));
    }

    public function test_all_non_parameterized_get_pages_do_not_have_server_errors(): void
    {
        $this->seed(CustomAuthorizationSeeder::class);
        $user = User::factory()->create();
        $user->assignRole('super_admin');
        $this->actingAs($user);
        $this->withExceptionHandling();

        $uris = collect(Route::getRoutes())
            ->filter(fn ($route) => in_array('GET', $route->methods(), true))
            ->map(fn ($route) => $route->uri())
            ->reject(fn (string $uri) => str_contains($uri, '{'))
            ->reject(fn (string $uri) => str_starts_with($uri, 'storage/'))
            ->unique()
            ->sort()
            ->values();

        $this->assertGreaterThan(0, $uris->count());
        $this->assertPagesAreReachable($uris);
    }

    public function test_all_parameterized_get_pages_are_reachable_with_valid_records(): void
    {
        $this->seed(CustomAuthorizationSeeder::class);
        $user = User::factory()->create();
        $user->assignRole('super_admin');
        $this->actingAs($user);
        $this->withExceptionHandling();

        $campus = Campus::create(['name' => 'Smoke Test Campus']);
        $building = Building::create([
            'campus_id' => $campus->id,
            'name' => 'Smoke Test Building',
        ]);
        $room = Room::create([
            'building_id' => $building->id,
            'name' => 'Smoke Test Room',
        ]);
        $faculty = Faculty::create([
            'name' => 'Smoke Test Faculty',
            'short_name' => 'STF',
        ]);
        $department = Department::create([
            'faculty_id' => $faculty->id,
            'name' => 'Smoke Test Department',
        ]);
        $session = AcademicSession::create([
            'name' => 'Smoke Test Session',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
        ]);
        $program = Program::create([
            'department_id' => $department->id,
            'name' => 'Smoke Test Program',
            'short_name' => 'STP',
        ]);
        $batch = Batch::create([
            'program_id' => $program->id,
            'academic_session_id' => $session->id,
            'name' => 'Smoke Test Batch',
        ]);
        $course = Course::create([
            'department_id' => $department->id,
            'name' => 'Smoke Test Course',
            'code' => 'STC-101',
        ]);
        $grading = GradingSystem::create(['name' => 'Smoke Test Grading']);
        $hostel = Hostel::create([
            'campus_id' => $campus->id,
            'name' => 'Smoke Test Hostel',
        ]);
        $staff = Staff::create([
            'employee_id' => 'SMOKE-EMP-1',
            'first_name' => 'Smoke',
            'last_name' => 'Teacher',
            'department_id' => $department->id,
            'is_teacher' => true,
        ]);
        $student = Student::create([
            'student_id' => 'SMOKE-STU-1',
            'first_name' => 'Smoke',
            'last_name' => 'Student',
            'program_id' => $program->id,
            'batch_id' => $batch->id,
        ]);
        $admission = AdmissionApplication::create([
            'program_id' => $program->id,
            'academic_session_id' => $session->id,
            'applicant_name' => 'Smoke Applicant',
            'email' => 'smoke-applicant@example.com',
        ]);
        $role = Role::create(['name' => 'smoke-test-role']);
        $activity = activity()
            ->causedBy($user)
            ->performedOn($campus)
            ->log('Smoke test activity');

        $urls = [
            route('admissions.show', $admission),
            route('audit.show', $activity),
            route('batches.edit', $batch),
            route('buildings.edit', $building),
            route('campuses.edit', $campus),
            route('courses.show', $course),
            route('courses.edit', $course),
            route('departments.edit', $department),
            route('faculties.edit', $faculty),
            route('grading.edit', $grading),
            route('hostel.rooms', $hostel),
            route('programs.edit', $program),
            route('password.reset', ['token' => 'smoke-test-token']),
            route('roles.edit', $role),
            route('rooms.edit', $room),
            route('salary.edit', $staff),
            route('sessions.edit', $session),
            route('staff.show', $staff),
            route('staff.edit', $staff),
            route('students.show', $student),
            route('students.edit', $student),
            route('teachers.show', $staff),
            route('teachers.edit', $staff),
            route('users.show', $user),
            route('users.edit', $user),
            URL::temporarySignedRoute(
                'verification.verify',
                now()->addMinutes(5),
                ['id' => $user->id, 'hash' => sha1($user->email)],
            ),
        ];

        $this->assertPagesAreReachable($urls);
    }

    private function assertPagesAreReachable(iterable $urls): void
    {
        $failures = [];

        foreach ($urls as $url) {
            $path = str_starts_with($url, 'http')
                ? $url
                : ($url === '/' ? '/' : '/'.ltrim($url, '/'));

            try {
                $response = $this->get($path);

                if ($response->status() >= 400) {
                    $failures[] = sprintf('%s returned HTTP %d', $path, $response->status());
                }
            } catch (Throwable $exception) {
                $failures[] = sprintf(
                    '%s threw %s: %s',
                    $path,
                    $exception::class,
                    $exception->getMessage(),
                );
            }
        }

        $this->assertSame([], $failures, implode(PHP_EOL, $failures));
    }
}
