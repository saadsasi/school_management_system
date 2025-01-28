<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivitySchedule extends Model
{
    protected $table = 'activity_schedule';

    protected $fillable = [
        'activity_id',
        'week_id',
        'start_time',
        'end_time',
        'location'
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function getWeekNameAttribute()
    {
        $weekDays = [
            1 => 'الأحد',
            2 => 'الإثنين',
            3 => 'الثلاثاء',
            4 => 'الأربعاء',
            5 => 'الخميس',
            6 => 'الجمعة',
            7 => 'السبت'
        ];
        
        return $weekDays[$this->week_id] ?? '';
    }
}