<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HealthRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'health_records';

    protected $fillable = [
        'student_id',
        'height',
        'weight',
        'blood_group',
        'vaccination_name',
        'vaccination_date',
        'allergy_type',
        'allergy_severity',
        'disease_name',
        'disease_medications',
        'visit_date',
        'visit_reason',
        'visit_diagnosis',
        'visit_treatment',
        'medical_condition',
        'notes',
        'created_by',
        'record_date'
    ];

    protected $dates = [
        'vaccination_date',
        'visit_date',
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