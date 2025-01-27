@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">التقارير</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Student Reports Card -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title mb-0">تقارير الطلاب</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('reports.students') }}" method="GET">
                                <div class="form-group">
                                    <label>نوع التقرير</label>
                                    <select name="report_type" class="form-control select2">
                                        <option value="attendance">الحضور والغياب</option>
                                        <option value="grades">الدرجات</option>
                                        <option value="fees">الرسوم الدراسية</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>الصف</label>
                                    <select name="class_id" class="form-control select2">
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-file-alt ml-2"></i>عرض التقرير
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Teacher Reports Card -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-success text-white">
                            <h3 class="card-title mb-0">تقارير المعلمين</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('reports.teachers') }}" method="GET">
                                <div class="form-group">
                                    <label>نوع التقرير</label>
                                    <select name="report_type" class="form-control select2">
                                        <option value="classes">الفصول الدراسية</option>
                                        <option value="attendance">الحضور</option>
                                        <option value="performance">الأداء</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>التاريخ</label>
                                    <input type="date" name="date" class="form-control datepicker">
                                </div>
                                <button type="submit" class="btn btn-success btn-block">
                                    <i class="fas fa-file-alt ml-2"></i>عرض التقرير
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Financial Reports Card -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-warning text-white">
                            <h3 class="card-title mb-0">التقارير المالية</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('reports.financial') }}" method="GET">
                                <div class="form-group">
                                    <label>نوع التقرير</label>
                                    <select name="report_type" class="form-control select2">
                                        <option value="fees_collection">تحصيل الرسوم</option>
                                        <option value="expenses">المصروفات</option>
                                        <option value="summary">ملخص مالي</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>الفترة</label>
                                    <select name="period" class="form-control select2">
                                        <option value="monthly">شهري</option>
                                        <option value="quarterly">ربع سنوي</option>
                                        <option value="yearly">سنوي</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-warning btn-block">
                                    <i class="fas fa-file-alt ml-2"></i>عرض التقرير
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Examination Reports Card -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-info text-white">
                            <h3 class="card-title mb-0">تقارير الامتحانات</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('reports.examinations') }}" method="GET">
                                <div class="form-group">
                                    <label>نوع التقرير</label>
                                    <select name="report_type" class="form-control select2">
                                        <option value="results">نتائج الامتحانات</option>
                                        <option value="analysis">تحليل الأداء</option>
                                        <option value="comparison">مقارنة النتائج</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>الصف</label>
                                    <select name="class_id" class="form-control select2">
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-info btn-block">
                                    <i class="fas fa-file-alt ml-2"></i>عرض التقرير
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Statistics -->
            <div class="row mt-4">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $totalStudents ?? 0 }}</h3>
                            <p>إجمالي الطلاب</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $totalTeachers ?? 0 }}</h3>
                            <p>إجمالي المعلمين</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $totalClasses ?? 0 }}</h3>
                            <p>إجمالي الفصول</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-school"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $totalFees ?? 0 }}</h3>
                            <p>إجمالي الرسوم المحصلة</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize select2 for better dropdown experience
        $('.select2').select2({
            theme: 'bootstrap4',
            width: '100%'
        });
        
        // Initialize datepicker
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            rtl: true,
            language: 'ar'
        });
    });
</script>
@endsection