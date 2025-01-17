<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'max_students',
        'cost',
        'status'
    ];

    // علاقة مع تسجيلات الأنشطة
    public function registrations()
    {
        return $this->hasMany(ActivityRegistration::class);
    }

    // علاقة مع الطلاب المسجلين
    public function students()
    {
        return $this->belongsToMany(User::class, 'activity_registrations', 'activity_id', 'student_id');
    }
}