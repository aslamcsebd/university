<?php

namespace App\Models;

use App\Models\Concerns\HasCustomPermissions;
use App\Models\Concerns\RecordsCreator;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasCustomPermissions, HasFactory, LogsActivity, Notifiable, RecordsCreator, SoftDeletes;

    protected $attributes = ['is_active' => true];

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'is_active',
        'two_fa_secret',
        'two_fa_enabled',
        'two_fa_confirmed_at',
        'last_login_at',
        'last_login_ip',
        'login_attempts',
        'locked_until',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_fa_secret',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'two_fa_enabled' => 'boolean',
            'two_fa_confirmed_at' => 'datetime',
            'last_login_at' => 'datetime',
            'locked_until' => 'datetime',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept(['password', 'remember_token', 'two_fa_secret', 'updated_at'])
            ->logOnlyDirty()
            ->dontLogIfAttributesChangedOnly(['updated_at']);
    }

    public function isLocked(): bool
    {
        return $this->locked_until && $this->locked_until->isFuture();
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/'.$this->avatar);
        }

        return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&background=1d4ed8&color=fff';
    }

    public function loginAudits()
    {
        return $this->hasMany(LoginAudit::class);
    }
}
