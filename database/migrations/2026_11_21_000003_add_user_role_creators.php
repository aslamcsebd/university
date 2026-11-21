<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['users', 'roles'] as $table) {
            if (! Schema::hasColumn($table, 'created_by')) {
                Schema::table($table, function (Blueprint $blueprint) {
                    $blueprint->foreignId('created_by')->nullable()->index()->constrained('users')->nullOnDelete();
                });
            }
        }
        $auditTable = config('activitylog.table_name', 'activity_log');
        if (! Schema::hasTable($auditTable) || ! Schema::hasColumn($auditTable, 'event')) {
            return;
        }
        // Only explicit creation events establish ownership. An editor is not a creator.
        $types = [(new User)->getMorphClass() => 'users', (new Role)->getMorphClass() => 'roles'];
        DB::transaction(function () use ($auditTable, $types) {
            DB::table($auditTable)->where('event', 'created')->whereIn('subject_type', array_keys($types))
                ->where('causer_type', (new User)->getMorphClass())->whereNotNull('causer_id')
                ->orderBy('id')->chunkById(500, function ($events) use ($types) {
                    foreach ($events as $event) {
                        if (DB::table('users')->where('id', $event->causer_id)->exists()) {
                            DB::table($types[$event->subject_type])->where('id', $event->subject_id)->whereNull('created_by')
                                ->update(['created_by' => $event->causer_id]);
                        }
                    }
                });
        });
    }

    public function down(): void
    {
        foreach (['roles', 'users'] as $table) {
            Schema::table($table, function (Blueprint $blueprint) use ($table) {
                $blueprint->dropForeign(['created_by']);
                $blueprint->dropIndex($table.'_created_by_index');
                $blueprint->dropColumn('created_by');
            });
        }
    }
};
