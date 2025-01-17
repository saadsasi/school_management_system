@extends('layouts.app')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $header_title }}</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @include('_message')
                    <div class="card card-primary">
                        <form method="post" action="{{ url('parent/leave/add') }}">
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="form-group">
                                    <label>نوع المغادرة <span style="color: red;">*</span></label>
                                    <select class="form-control" required name="type">
                                        <option value="">اختر النوع</option>
                                        <option value="{{ \App\Http\Controllers\LeaveController::LEAVE_TYPE_EARLY }}">مغادرة مبكرة</option>
                                        <option value="{{ \App\Http\Controllers\LeaveController::LEAVE_TYPE_END_DAY }}">نهاية الدوام</option>
                                     </select>
                                </div>

                                <div class="form-group">
                                    <label>اختر الطلاب <span style="color: red;">*</span></label>
                                    <div class="student-checkboxes">
                                        @foreach($getStudent as $student)
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" 
                                                    id="student_{{ $student->id }}" 
                                                    name="student_ids[]" 
                                                    value="{{ $student->id }}">
                                                <label class="custom-control-label" for="student_{{ $student->id }}">
                                                    {{ $student->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <small class="form-text text-muted">يمكنك اختيار أكثر من طالب</small>
                                </div>

                                <div class="form-group">
                                    <label>السبب <span style="color: red;">*</span></label>
                                    <textarea class="form-control" required name="reason" rows="4">{{ old('reason') }}</textarea>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">إرسال</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('styles')
<style>
.student-checkboxes {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 10px;
    max-height: 200px;
    overflow-y: auto;
    background-color: white;
}
.custom-control.custom-checkbox {
    padding-right: 2.5rem;
    margin-bottom: 10px;
    position: relative;
}
.custom-control-label {
    position: relative;
    margin-bottom: 0;
    vertical-align: top;
    cursor: pointer;
}
.custom-control-label::before {
    position: absolute;
    right: -2.5rem;
    top: 0.25rem;
    display: block;
    width: 1.5rem;
    height: 1.5rem;
    content: "";
    background-color: #fff;
    border: 1px solid #adb5bd;
    border-radius: 0.25rem;
}
.custom-control-label::after {
    position: absolute;
    right: -2.5rem;
    top: 0.25rem;
    display: block;
    width: 1.5rem;
    height: 1.5rem;
    content: "";
    background: no-repeat 50% / 50% 50%;
}
.custom-control-input {
    position: absolute;
    right: 0;
    z-index: -1;
    width: 1.5rem;
    height: 1.5rem;
    opacity: 0;
}
.custom-control-input:checked ~ .custom-control-label::before {
    border-color: #007bff;
    background-color: #007bff;
}
.custom-control-input:checked ~ .custom-control-label::after {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 8 8'%3e%3cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26l2.974 2.99L8 2.193z'/%3e%3c/svg%3e");
}
</style>
@endpush
@endsection