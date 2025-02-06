<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\User;

class ExportTeacher implements FromCollection, WithMapping, WithHeadings
{


    public function collection()
    {
        return User::where('user_type', 2)->get();
    }

    public function headings(): array
    {
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

    public function map($row): array
    {
        return [
            $row->id,
            $row->name . ' ' . $row->last_name,
            $row->email,
            $row->mobile_number,
            $row->qualification,
            $row->work_experience,
            date('Y-m-d', strtotime($row->joining_date)),
            $row->status == 0 ? 'نشط' : 'غير نشط'
        ];
    }
}
