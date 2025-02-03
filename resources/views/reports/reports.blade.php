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
                                        <option value="students_with_guardians">الطلبة مع أولياء الأمور</option>
                                        <option value="students_without_guardians">الطلبة بدون أولياء أمور</option>
                                        <option value="guardians_without_students">أولياء الأمور بدون طلبة</option>
                                        <option value="classes_students">الفصول والطلبة</option>
                                    </select>
                                </div>
                                <div class="form-group grade-level-group">
                                    <label>المرحلة الدراسية</label>
                                    <select name="grade_level" class="form-control select2">
                                        <option value="">جميع المراحل</option>
                                        @foreach($classes->pluck('grade_level')->unique()->sort() as $level)
                                            <option value="{{ $level }}">{{ $level }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-file-alt ml-2"></i>عرض التقرير
                                </button>
                                <button type="submit" name="export" value="1" class="btn btn-success btn-block mt-2">
                                    <i class="fas fa-file-excel ml-2"></i>تصدير إلى Excel
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
                                        <option value="assigned_classes">الفصول الموكلة</option>
                                        <option value="evaluations">تقييمات المعلمين</option>
                                        <option value="subjects">المواد المسجلة</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success btn-block">
                                    <i class="fas fa-file-alt ml-2"></i>عرض التقرير
                                </button>
                                <button type="submit" name="export" value="1" class="btn btn-success btn-block mt-2">
                                    <i class="fas fa-file-excel ml-2"></i>تصدير إلى Excel
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
                                        <option value="pending_fees">الطلبة المتبقي عليهم رسوم</option>
                                        <option value="completed_fees">الطلبة المسددين بالكامل</option>
                                        <option value="payment_analysis">تحليل طرق السداد</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-warning btn-block">
                                    <i class="fas fa-file-alt ml-2"></i>عرض التقرير
                                </button>
                                <button type="submit" name="export" value="1" class="btn btn-success btn-block mt-2">
                                    <i class="fas fa-file-excel ml-2"></i>تصدير إلى Excel
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
                                        <option value="performance_analysis">تحليل الأداء</option>
                                        <option value="results_comparison">مقارنة النتائج</option>
                                        <option value="grades_distribution">توزيع العلامات</option>
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
                                <button type="submit" name="export" value="1" class="btn btn-success btn-block mt-2">
                                    <i class="fas fa-file-excel ml-2"></i>تصدير إلى Excel
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
        $('.select2').select2({
            theme: 'bootstrap4',
            width: '100%'
        });
        
        // Show/hide grade level based on report type for student reports
        $('select[name="report_type"]').on('change', function() {
            if ($(this).val() === 'classes_students') {
                $('.grade-level-group').show();
            } else {
                $('.grade-level-group').hide();
            }
        });

        // Trigger change event on page load
        $('select[name="report_type"]').trigger('change');
    });
</script>
@endsection