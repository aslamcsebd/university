<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LibrarySetting extends Model
{
    protected $fillable = [
        'student_issue_days', 'staff_issue_days',
        'max_books_student', 'max_books_staff',
        'fine_per_day', 'max_fine_per_book',
    ];

    public static function current(): self
    {
        return static::firstOrCreate([], [
            'student_issue_days' => 14,
            'staff_issue_days'   => 30,
            'max_books_student'  => 3,
            'max_books_staff'    => 5,
            'fine_per_day'       => 5.00,
            'max_fine_per_book'  => 200.00,
        ]);
    }
}
