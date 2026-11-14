<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable()->after('email');
            $table->boolean('is_active')->default(true)->after('avatar');
            $table->string('two_fa_secret')->nullable()->after('password');
            $table->boolean('two_fa_enabled')->default(false)->after('two_fa_secret');
            $table->timestamp('two_fa_confirmed_at')->nullable()->after('two_fa_enabled');
            $table->timestamp('last_login_at')->nullable()->after('two_fa_confirmed_at');
            $table->string('last_login_ip', 45)->nullable()->after('last_login_at');
            $table->tinyInteger('login_attempts')->default(0)->after('last_login_ip');
            $table->timestamp('locked_until')->nullable()->after('login_attempts');
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'avatar', 'is_active', 'two_fa_secret', 'two_fa_enabled',
                'two_fa_confirmed_at', 'last_login_at', 'last_login_ip',
                'login_attempts', 'locked_until', 'deleted_at',
            ]);
        });
    }
};
