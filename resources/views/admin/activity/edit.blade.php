@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>تعديل النشاط</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <form method="post" action="{{ url('admin/activity/update/'.$activity->id) }}">
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="form-group">
                                    <label>اسم النشاط</label>
                                    <input type="text" class="form-control" name="name" value="{{ $activity->name }}" required>
                                </div>

                                <div class="form-group">
                                    <label>تاريخ البداية</label>
                                    <input type="date" class="form-control" name="start_date" value="{{ $activity->start_date }}" required>
                                </div>

                                <div class="form-group">
                                    <label>تاريخ النهاية</label>
                                    <input type="date" class="form-control" name="end_date" value="{{ $activity->end_date }}" required>
                                </div>

                                <div class="form-group">
                                    <label>الحد الأقصى للطلاب</label>
                                    <input type="number" class="form-control" name="max_students" value="{{ $activity->max_students }}" required>
                                </div>

                                <div class="form-group">
                                    <label>التكلفة</label>
                                    <input type="number" step="0.01" class="form-control" name="cost" value="{{ $activity->cost }}" required>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
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