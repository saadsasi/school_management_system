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