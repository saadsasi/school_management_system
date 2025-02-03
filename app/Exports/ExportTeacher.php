<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\User;

class ExportTeacher implements FromCollection, WithMapping, WithHeadings
{
    protected $data;
    protected $reportType;

    public function __construct($data, $reportType)
    {
        $this->data = $data;
        $this->reportType = $reportType;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        switch ($this->reportType) {
            case 'assigned_classes':
                return [
                    'اسم المعلم',
                    'المادة',
                    'الفصول المسندة',
                    'عدد الطلاب',
                    'الحالة'
                ];

            case 'evaluations':
                return [
                    'اسم المعلم',
                    'التقييم',
                    'الملاحظات',
                    'تاريخ التقييم',
                    'المقيم'
                ];

            case 'subjects':
                return [
                    'اسم المعلم',
                    'المادة',
                    'المستوى',
                    'عدد الحصص',
                    'الحالة'
                ];

            default:
                return [
                    'ID',
                    'اسم المعلم',
                    'البريد الإلكتروني',
                    'رقم الهاتف',
                    'التخصص',
                    'الخبرة',
                    'تاريخ التعيين',
                    'الحالة'
                ];
        }
    }

    public function map($row): array
    {
        switch ($this->reportType) {
            case 'assigned_classes':
                $classes = $row->assignedClasses->pluck('name')->implode(', ');
                $totalStudents = $row->assignedClasses->sum(function($class) {
                    return $class->students->count();
                });
                
                return [
                    $row->name,
                    $row->subject_name,
                    $classes,
                    $totalStudents,
                    $row->status == 0 ? 'نشط' : 'غير نشط'
                ];

            case 'evaluations':
                return [
                    $row->name,
                    $row->evaluation_score,
                    $row->evaluation_notes,
                    date('Y-m-d', strtotime($row->evaluation_date)),
                    $row->evaluator_name
                ];

            case 'subjects':
                return [
                    $row->name,
                    $row->subject_name,
                    $row->grade_level,
                    $row->weekly_classes,
                    $row->status == 0 ? 'نشط' : 'غير نشط'
                ];

            default:
                return [
                    $row->id,
                    $row->name.' '.$row->last_name,
                    $row->email,
                    $row->mobile_number,
                    $row->qualification,
                    $row->work_experience,
                    date('Y-m-d', strtotime($row->joining_date)),
                    $row->status == 0 ? 'نشط' : 'غير نشط'
                ];
        }
    }
}
