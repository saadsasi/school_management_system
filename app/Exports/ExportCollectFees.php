<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\User;

class ExportCollectFees implements FromCollection, WithMapping, WithHeadings
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
            case 'pending_fees':
                return [
                    'اسم الطالب',
                    'الصف',
                    'إجمالي الرسوم',
                    'المبلغ المدفوع',
                    'المبلغ المتبقي',
                    'نسبة السداد'
                ];

            case 'completed_fees':
                return [
                    'اسم الطالب',
                    'الصف',
                    'إجمالي الرسوم',
                    'تاريخ اكتمال السداد',
                    'طريقة الدفع'
                ];

            case 'payment_analysis':
                return [
                    'طريقة الدفع',
                    'عدد المعاملات',
                    'إجمالي المبلغ',
                    'النسبة المئوية'
                ];

            default:
                return [
                    'اسم الطالب',
                    'الصف',
                    'نوع الرسوم',
                    'المبلغ',
                    'الحالة',
                    'تاريخ الدفع'
                ];
        }
    }

    public function map($row): array
    {
        switch ($this->reportType) {
            case 'pending_fees':
                $percentage = ($row->total_fees > 0) ? 
                    round(($row->paid_amount / $row->total_fees) * 100, 2) : 0;
                
                return [
                    $row->name,
                    $row->class_name,
                    $row->total_fees,
                    $row->paid_amount,
                    $row->remaining_amount,
                    $percentage . '%'
                ];

            case 'completed_fees':
                return [
                    $row->name,
                    $row->class_name,
                    $row->total_fees,
                    date('Y-m-d', strtotime($row->payment_date)),
                    $row->payment_method
                ];

            case 'payment_analysis':
                return [
                    $row->payment_method,
                    $row->count,
                    $row->total_amount,
                    round($row->percentage, 2) . '%'
                ];

            default:
                return [
                    $row->student_name,
                    $row->class_name,
                    $row->fee_type,
                    $row->amount,
                    $row->status == 'paid' ? 'مدفوع' : 'غير مدفوع',
                    date('Y-m-d', strtotime($row->created_at))
                ];
        }
    }
}
