@extends('layouts.app')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>تسجيل في نشاط</h1>
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
                        <div class="card-header">
                            <h3 class="card-title">{{ $activity->name }}</h3>
                        </div>
                        <form method="post" action="{{ url('parent/activity/save-registration') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="activity_id" value="{{ $activity->id }}">
                            
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>اختر الطالب <span style="color: red;">*</span></label>
                                            <select name="student_id" class="form-control" required>
                                                <option value="">اختر الطالب</option>
                                                @foreach($children as $child)
                                                <option value="{{ $child->id }}">{{ $child->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>ملاحظات</label>
                                            <textarea name="notes" class="form-control" rows="3" placeholder="أدخل أي ملاحظات إضافية"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">تسجيل</button>
                                <a href="{{ url('parent/activities') }}" class="btn btn-default">إلغاء</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection