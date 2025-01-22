<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\TeacherSubject;

class TeacherEvaluation extends Model
{
    protected $fillable = [
        'teacher_subject_id',
        'evaluation_date',
        'notes',
        'created_by'
    ];

    public function teacherSubject()
    {
        return $this->belongsTo(TeacherSubject::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}