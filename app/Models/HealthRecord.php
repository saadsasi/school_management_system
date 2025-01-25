<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HealthRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'student_id',
        'height',
        'weight',
        'blood_group',
        'allergies',
        'medical_condition',
        'medications',
        'chronic_diseases',
        'previous_surgeries',
        'emergency_contact',
        'notes',
        'created_by',
        'record_date'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}