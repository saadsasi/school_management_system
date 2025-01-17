<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityRegistration extends Model
{
    protected $fillable = [
        'activity_id',
        'student_id',
        'status',
        'notes',
        'approved_at',
        'approved_by'
    ];

    // علاقة مع النشاط
    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    // علاقة مع الطالب
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // علاقة مع المشرف الذي وافق على الطلب
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}