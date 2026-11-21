<?php

namespace App\Models\Concerns;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Validation\ValidationException;

trait RecordsCreator
{
    public static function bootRecordsCreator(): void
    {
        static::creating(function ($model) {
            // Never accept an authenticated request's submitted creator ID.
            $model->created_by = auth()->id() ?? $model->created_by;
        });
        static::updating(function ($model) {
            if ($model->isDirty('created_by')) {
                throw ValidationException::withMessages(['created_by' => 'The original creator cannot be changed.']);
            }
        });
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeVisibleTo(Builder $query, User $actor): Builder
    {
        return $actor->isSuperAdmin() ? $query : $query->where($this->qualifyColumn('created_by'), $actor->id);
    }

    public function isVisibleTo(User $actor): bool
    {
        return $actor->isSuperAdmin() || (int) $this->created_by === (int) $actor->id;
    }
}
