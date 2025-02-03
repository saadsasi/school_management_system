<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportExaminations implements FromCollection, WithMapping, WithHeadings
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
            case 'performance_analysis':
                return [
                    'اسم الطالب',
                    'المادة',
                    'الدرجة',
                    'تاريخ الامتحان'
                ];

            case 'results_comparison':
                return [
                    'اسم الطالب',
                    'المادة',
                    'الدرجة',
                    'تاريخ الامتحان',
                    'التغير عن الامتحان السابق'
                ];

            case 'grades_distribution':
                return [
                    'التقدير',
                    'عدد الطلاب',
                    'النسبة المئوية'
                ];
        }
    }

    public function map($row): array
    {
        switch ($this->reportType) {
            case 'performance_analysis':
                return [
                    $row->name,
                    $row->subject_id,
                    $row->marks,
                    date('Y-m-d', strtotime($row->exam_date))
                ];

            case 'results_comparison':
                return [
                    $row->name,
                    $row->subject_id,
                    $row->marks,
                    date('Y-m-d', strtotime($row->exam_date)),
                    $row->change ?? 'N/A'
                ];

            case 'grades_distribution':
                return [
                    $row->grade,
                    $row->count,
                    round($row->percentage, 2) . '%'
                ];
        }
    }
}