<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSubjectTimetableModel extends Model
{
    use HasFactory;

    protected $table = 'class_subject_timetable';

    static public function getRecordClassSubject($class_id,$subject_id,$week_id)
    {
        return self::where('class_id', '=', $class_id)->where('subject_id', '=', $subject_id)->where('week_id', '=', $week_id)->first();
    }

    static public function getTotalWeeklyClasses($teacher_id)
    {
        return self::join('teacher_subjects', function($join) use ($teacher_id) {
            $join->on('class_subject_timetable.class_id', '=', 'teacher_subjects.class_id')
                ->on('class_subject_timetable.subject_id', '=', 'teacher_subjects.subject_id')
                ->where('teacher_subjects.teacher_id', '=', $teacher_id);
        })
        ->whereNotNull('start_time')
        ->whereNotNull('end_time')
        ->count();
    }
}
