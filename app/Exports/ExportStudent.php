<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\User;

class ExportStudent implements FromCollection, WithMapping, WithHeadings
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
            case 'students_with_guardians':
                return [
                    'اسم الطالب',
                    'اسم ولي الأمر',
                    'رقم هاتف ولي الأمر',
                    'البريد الإلكتروني لولي الأمر'
                ];

            case 'students_without_guardians':
                return [
                    'اسم الطالب',
                    'الصف',
                    'رقم الهاتف',
                    'البريد الإلكتروني'
                ];

            case 'guardians_without_students':
                return [
                    'اسم ولي الأمر',
                    'رقم الهاتف',
                    'البريد الإلكتروني',
                    'العنوان'
                ];

            case 'classes_students':
                return [
                    'الصف',
                    'اسم الطالب',
                    'رقم الهاتف',
                    'البريد الإلكتروني',
                    'ولي الأمر'
                ];

            default:
                return [
                    'ID',
                    'اسم الطالب',
                    'اسم ولي الأمر',
                    'البريد الإلكتروني',
                    'الصف',
                    'الجنس',
                    'تاريخ الميلاد',
                    'رقم الهاتف',
                    'تاريخ التسجيل',
                    'الحالة',
                    'تاريخ الإنشاء'
                ];
        }
    }

    public function map($row): array
    {
        switch ($this->reportType) {
            case 'students_with_guardians':
                return [
                    $row->name,
                    $row->guardian_name,
                    $row->guardian_mobile,
                    $row->guardian_email
                ];

            case 'students_without_guardians':
                return [
                    $row->name,
                    $row->class_name,
                    $row->mobile_number,
                    $row->email
                ];

            case 'guardians_without_students':
                return [
                    $row->name,
                    $row->mobile_number,
                    $row->email,
                    $row->address
                ];

            case 'classes_students':
                return [
                    $row->name, // class name
                    $row->student_name,
                    $row->mobile_number,
                    $row->email,
                    $row->guardian_name ?? 'لا يوجد'
                ];

            default:
                $student_name = $row->name.' '.$row->last_name;
                $parent_name = $row->parent_name.' '.$row->parent_last_name;
                $date_of_birth = !empty($row->date_of_birth) ? date('d-m-Y', strtotime($row->date_of_birth)) : '';
                $admission_date = !empty($row->admission_date) ? date('d-m-Y', strtotime($row->admission_date)) : '';
                $status = ($row->status == 0) ? 'نشط' : 'غير نشط';
                
                return [
                    $row->id,
                    $student_name,
                    $parent_name,
                    $row->email,
                    $row->class_name,
                    $row->gender,
                    $date_of_birth,
                    $row->mobile_number,
                    $admission_date,
                    $status,
                    date('Y-m-d', strtotime($row->created_at))
                ];
        }
    }
}
