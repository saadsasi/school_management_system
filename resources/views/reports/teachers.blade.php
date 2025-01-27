@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">تقرير المعلمين</h1>
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
                        @if($reportType == 'classes')
                            تقرير الفصول الدراسية
                        @elseif($reportType == 'attendance')
                            تقرير الحضور
                            @if($date)
                                - {{ $date }}
                            @endif
                        @else
                            تقرير الأداء
                        @endif
                    </h3>
                </div>
                <div class="card-body">
                    @if($reportType == 'classes')
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>اسم المعلم</th>
                                        <th>الفصول المسندة</th>
                                        <th>عدد الطلاب</th>
                                        <th>المواد</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $teacherName => $classes)
                                        <tr>
                                            <td>{{ $teacherName }}</td>
                                            <td>
                                                <ul class="list-unstyled">
                                                    @foreach($classes as $class)
                                                        <li>{{ $class->class_name }}</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>{{ $classes->sum('student_count') }}</td>
                                            <td>
                                                <ul class="list-unstyled">
                                                    @foreach($classes as $class)
                                                        <li>{{ $class->subject_name ?? 'غير محدد' }}</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @elseif($reportType == 'attendance')
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>اسم المعلم</th>
                                        <th>حالة الحضور</th>
                                        <th>وقت الحضور</th>
                                        <th>وقت الانصراف</th>
                                        <th>ملاحظات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $teacherName => $attendance)
                                        @foreach($attendance as $record)
                                            <tr>
                                                <td>{{ $teacherName }}</td>
                                                <td>
                                                    @if($record->status == 1)
                                                        <span class="badge badge-success">حاضر</span>
                                                    @else
                                                        <span class="badge badge-danger">غائب</span>
                                                    @endif
                                                </td>
                                                <td>{{ $record->check_in ?? '-' }}</td>
                                                <td>{{ $record->check_out ?? '-' }}</td>
                                                <td>{{ $record->notes ?? '-' }}</td>
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
                                        <th>اسم المعلم</th>
                                        <th>عدد الفصول</th>
                                        <th>نسبة الحضور</th>
                                        <th>تقييم الأداء</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $teacher)
                                        <tr>
                                            <td>{{ $teacher->name }}</td>
                                            <td>{{ $teacher->total_classes }}</td>
                                            <td>
                                                @php
                                                    $workingDays = 20; // Assuming 20 working days per month
                                                    $attendancePercentage = ($teacher->attendance_count / $workingDays) * 100;
                                                @endphp
                                                {{ number_format($attendancePercentage, 2) }}%
                                            </td>
                                            <td>
                                                @if($attendancePercentage >= 90)
                                                    <span class="badge badge-success">ممتاز</span>
                                                @elseif($attendancePercentage >= 80)
                                                    <span class="badge badge-info">جيد جداً</span>
                                                @elseif($attendancePercentage >= 70)
                                                    <span class="badge badge-warning">جيد</span>
                                                @else
                                                    <span class="badge badge-danger">يحتاج تحسين</span>
                                                @endif
                                            </td>
                                        </tr>
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