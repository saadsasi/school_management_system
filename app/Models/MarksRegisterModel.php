<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarksRegisterModel extends Model
{
    use HasFactory;

    protected $table = 'marks_register';

    static public function getAlreadyFirst($student_id, $exam_id, $grade_level, $subject_id)
    {
        return self::select('marks_register.*')
            ->join('class', 'marks_register.class_id', '=', 'class.id')
            ->where('marks_register.student_id', '=', $student_id)
            ->where('marks_register.exam_id', '=', $exam_id)
            ->where('class.grade_level', '=', $grade_level)
            ->where('marks_register.subject_id', '=', $subject_id)
            ->first();
    }

    static public function getExam($student_id)
    {
        return self::select('marks_register.*', 'exam.name as exam_name')
            ->join('exam', 'exam.id', '=', 'marks_register.exam_id')
            ->where('marks_register.student_id', '=', $student_id)
            ->groupBy('marks_register.exam_id')
            ->get();
    }

    static public function getExamSubject($exam_id, $student_id)
    {
        return self::select('marks_register.*', 'subject.name as subject_name', 'exam_schedule.full_marks', 'exam_schedule.passing_mark')
            ->join('subject', 'subject.id', '=', 'marks_register.subject_id')
            ->join('exam_schedule', function($join) {
                $join->on('exam_schedule.exam_id', '=', 'marks_register.exam_id')
                    ->on('exam_schedule.subject_id', '=', 'marks_register.subject_id');
            })
            ->where('marks_register.exam_id', '=', $exam_id)
            ->where('marks_register.student_id', '=', $student_id)
            ->groupBy('marks_register.subject_id')
            ->get();
    }

    static public function getStudentSubjectMark($student_id, $exam_id, $grade_level, $subject_id)
    {
        return self::select('marks_register.*')
            ->join('class', 'marks_register.class_id', '=', 'class.id')
            ->where('marks_register.student_id', '=', $student_id)
            ->where('marks_register.exam_id', '=', $exam_id)
            ->where('class.grade_level', '=', $grade_level)
            ->where('marks_register.subject_id', '=', $subject_id)
            ->first();
    }

    static public function getStudentSubjects($exam_id, $student_id)
    {
        return self::select('marks_register.*', 'subject.name as subject_name', 'subject.type as subject_type')
            ->join('subject', 'marks_register.subject_id', '=', 'subject.id')
            ->where('marks_register.exam_id', '=', $exam_id)
            ->where('marks_register.student_id', '=', $student_id)
            ->get();
    }

    static public function getClass($exam_id, $student_id)
    {
        return self::select('class.name as class_name', 'class.grade_level')
            ->join('class', 'marks_register.class_id', '=', 'class.id')
            ->where('marks_register.exam_id', '=', $exam_id)
            ->where('marks_register.student_id', '=', $student_id)
            ->first();
    }
}
