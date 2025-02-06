<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\User;

class ExportStudent implements FromCollection, WithMapping, WithHeadings
{

    public function collection()
    {
        return User::where('user_type', 3)->get();
    }

    public function headings(): array
    {
        
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

    public function map($row): array
    {
       
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
