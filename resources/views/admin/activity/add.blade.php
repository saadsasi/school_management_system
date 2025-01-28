@extends('layouts.app')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>إضافة نشاط جديد</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @include('_message')
                    <div class="card card-primary">
                        <form method="post" action="{{ url('admin/activity/store') }}">
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="form-group">
                                    <label>اسم النشاط <span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" name="name" required placeholder="أدخل اسم النشاط">
                                </div>

                                <div class="form-group">
                                    <label>الوصف</label>
                                    <textarea class="form-control" name="description" rows="3" placeholder="أدخل وصف النشاط"></textarea>
                                </div>

                                <div class="form-group">
                                    <label>تاريخ البداية <span style="color: red;">*</span></label>
                                    <input type="date" class="form-control" name="start_date" required>
                                </div>

                                <div class="form-group">
                                    <label>تاريخ النهاية <span style="color: red;">*</span></label>
                                    <input type="date" class="form-control" name="end_date" required>
                                </div>

                                <!-- Weekly Schedule Section -->
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">جدول النشاط الأسبوعي</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="schedule-container">
                                            <div class="schedule-row">
                                                <div class="form-group">
                                                    <label>اليوم</label>
                                                    <select class="form-control" name="schedule[0][week_id]">
                                                        <option value="">اختر اليوم</option>
                                                        <option value="1">الأحد</option>
                                                        <option value="2">الإثنين</option>
                                                        <option value="3">الثلاثاء</option>
                                                        <option value="4">الأربعاء</option>
                                                        <option value="5">الخميس</option>
                                                        <option value="6">الجمعة</option>
                                                        <option value="7">السبت</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>وقت البداية</label>
                                                    <input type="time" class="form-control" name="schedule[0][start_time]">
                                                </div>
                                                <div class="form-group">
                                                    <label>وقت النهاية</label>
                                                    <input type="time" class="form-control" name="schedule[0][end_time]">
                                                </div>
                                                <div class="form-group">
                                                    <label>المكان</label>
                                                    <input type="text" class="form-control" name="schedule[0][location]" placeholder="مكان النشاط">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-info mt-2" id="addScheduleRow">
                                            <i class="fas fa-plus"></i> إضافة موعد آخر
                                        </button>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>العدد الأقصى للطلاب <span style="color: red;">*</span></label>
                                    <input type="number" class="form-control" name="max_students" required min="0">
                                </div>

                                <div class="form-group">
                                    <label>التكلفة <span style="color: red;">*</span></label>
                                    <input type="number" class="form-control" name="cost" required min="0" step="0.01">
                                </div>

                                <div class="form-group">
                                    <label>الحالة</label>
                                    <select class="form-control" name="status">
                                        <option value="active">نشط</option>
                                        <option value="inactive">غير نشط</option>
                                    </select>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">حفظ</button>
                                <a href="{{ url('admin/activities') }}" class="btn btn-default">إلغاء</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@section('script')
<script>
$(document).ready(function() {
    let scheduleCount = 1;
    
    $('#addScheduleRow').click(function() {
        const newRow = `
            <div class="schedule-row mt-3">
                <hr>
                <div class="form-group">
                    <label>اليوم</label>
                    <select class="form-control" name="schedule[${scheduleCount}][week_id]">
                        <option value="">اختر اليوم</option>
                        <option value="1">الأحد</option>
                        <option value="2">الإثنين</option>
                        <option value="3">الثلاثاء</option>
                        <option value="4">الأربعاء</option>
                        <option value="5">الخميس</option>
                        <option value="6">الجمعة</option>
                        <option value="7">السبت</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>وقت البداية</label>
                    <input type="time" class="form-control" name="schedule[${scheduleCount}][start_time]">
                </div>
                <div class="form-group">
                    <label>وقت النهاية</label>
                    <input type="time" class="form-control" name="schedule[${scheduleCount}][end_time]">
                </div>
                <div class="form-group">
                    <label>المكان</label>
                    <input type="text" class="form-control" name="schedule[${scheduleCount}][location]" placeholder="مكان النشاط">
                </div>
                <button type="button" class="btn btn-danger remove-schedule">
                    <i class="fas fa-trash"></i> حذف
                </button>
            </div>
        `;
        
        $('.schedule-container').append(newRow);
        scheduleCount++;
    });
    
    $(document).on('click', '.remove-schedule', function() {
        $(this).closest('.schedule-row').remove();
    });
});
</script>
@endsection