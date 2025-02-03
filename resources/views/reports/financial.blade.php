@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">التقرير المالي</h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-left">
                        <a href="{{ route('reports.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-right ml-2"></i>رجوع
                        </a>
                        <button onclick="window.print()" class="btn btn-primary">
                            <i class="fas fa-print ml-2"></i>طباعة
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        @if($reportType == 'fees_collection')
                            تقرير تحصيل الرسوم
                        @elseif($reportType == 'expenses')
                            تقرير المصروفات
                        @else
                            الملخص المالي
                        @endif
                        - 
                        @if($period == 'monthly')
                            شهري
                        @elseif($period == 'quarterly')
                            ربع سنوي
                        @else
                            سنوي
                        @endif
                    </h3>
                </div>
                <div class="card-body">
                    @if($reportType == 'fees_collection')
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>اسم الطالب</th>
                                        <th>الصف</th>
                                        <th>نوع الرسوم</th>
                                        <th>المبلغ</th>
                                        <th>تاريخ التحصيل</th>
                                        <th>الحالة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $fee)
                                        <tr>
                                            <td>{{ $fee->student_name }}</td>
                                            <td>{{ $fee->class_name }}</td>
                                            <td>{{ $fee->fee_type }}</td>
                                            <td>{{ $fee->amount }}</td>
                                            <td>{{ date('Y-m-d', strtotime($fee->created_at)) }}</td>
                                            <td>
                                                @if($fee->status == 'paid')
                                                    <span class="badge badge-success">مدفوع</span>
                                                @else
                                                    <span class="badge badge-danger">غير مدفوع</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3">إجمالي التحصيل</th>
                                        <th colspan="3">{{ $total }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @elseif($reportType == 'expenses')
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>البيان</th>
                                        <th>المبلغ</th>
                                        <th>التاريخ</th>
                                        <th>ملاحظات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $expense)
                                        <tr>
                                            <td>{{ $expense->description }}</td>
                                            <td>{{ $expense->amount }}</td>
                                            <td>{{ date('Y-m-d', strtotime($expense->created_at)) }}</td>
                                            <td>{{ $expense->notes ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>إجمالي المصروفات</th>
                                        <th colspan="3">{{ $total }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@if($reportType == 'summary')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('financialChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['الإيرادات', 'المصروفات', 'الرصيد'],
            datasets: [{
                label: 'المبلغ',
                data: [{{ $data['income'] }}, {{ $data['expenses'] }}, {{ $data['balance'] }}],
                backgroundColor: [
                    'rgba(40, 167, 69, 0.2)',
                    'rgba(220, 53, 69, 0.2)',
                    'rgba(23, 162, 184, 0.2)'
                ],
                borderColor: [
                    'rgba(40, 167, 69, 1)',
                    'rgba(220, 53, 69, 1)',
                    'rgba(23, 162, 184, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
@endif
@endsection