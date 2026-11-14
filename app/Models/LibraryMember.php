<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LibraryMember extends Model
{
    protected $fillable = [
        'person_id', 'person_type', 'member_no', 'name', 'email',
        'phone', 'valid_until', 'max_books', 'is_active',
    ];

    protected $casts = ['valid_until' => 'date', 'is_active' => 'boolean'];

    public function issues()       { return $this->hasMany(BookIssue::class, 'member_id'); }
    public function activeIssues() { return $this->hasMany(BookIssue::class, 'member_id')->where('status', 'issued'); }
    public function requests()     { return $this->hasMany(BookRequest::class, 'member_id'); }

    public static function generateMemberNo(string $type): string
    {
        $prefix = strtoupper(substr($type, 0, 3));
        $last   = static::where('person_type', $type)->latest('id')->value('member_no');
        $num    = $last ? ((int) substr($last, -4)) + 1 : 1;
        return $prefix . '-' . str_pad($num, 4, '0', STR_PAD_LEFT);
    }
}
