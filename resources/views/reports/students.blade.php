@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">تقرير الطلاب - {{ $class->name }}</h1>
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
                        @if($reportType == 'attendance')
                            تقرير الحضور والغياب
                        @elseif($reportType == 'grades')
                            تقرير الدرجات
                        @else
                            تقرير الرسوم الدراسية
                        @endif
                    </h3>
                </div>
                <div class="card-body">
                    @if($reportType == 'attendance')
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>اسم الطالب</th>
                                        <th>عدد أيام الحضور</th>
                                        <th>عدد أيام الغياب</th>
                                        <th>نسبة الحضور</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $studentId => $attendance)
                                        <tr>
                                            <td>{{ $attendance->first()->student_name }}</td>
                                            <td>{{ $attendance->where('attendance_status', 1)->count() }}</td>
                                            <td>{{ $attendance->where('attendance_status', 0)->count() }}</td>
                                            <td>
                                                @php
                                                    $total = $attendance->count();
                                                    $present = $attendance->where('attendance_status', 1)->count();
                                                    $percentage = ($total > 0) ? round(($present / $total) * 100, 2) : 0;
                                                @endphp
                                                {{ $percentage }}%
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @elseif($reportType == 'grades')
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>اسم الطالب</th>
                                        <th>المادة</th>
                                        <th>الدرجة</th>
                                        <th>التقدير</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $studentName => $grades)
                                        @foreach($grades as $grade)
                                            <tr>
                                                <td>{{ $studentName }}</td>
                                                <td>{{ $grade->subject_name }}</td>
                                                <td>{{ $grade->marks }}</td>
                                                <td>
                                                    @if($grade->marks >= 90)
                                                        ممتاز
                                                    @elseif($grade->marks >= 80)
                                                        جيد جداً
                                                    @elseif($grade->marks >= 70)
                                                        جيد
                                                    @elseif($grade->marks >= 60)
                                                        مقبول
                                                    @else
                                                        راسب
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>اسم الطالب</th>
                                        <th>نوع الرسوم</th>
                                        <th>المبلغ</th>
                                        <th>تاريخ الدفع</th>
                                        <th>الحالة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $studentName => $fees)
                                        @foreach($fees as $fee)
                                            <tr>
                                                <td>{{ $studentName }}</td>
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
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection