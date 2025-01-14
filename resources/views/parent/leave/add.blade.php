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
                                    <label>{{ __('messages.leave_type') }} <span style="color: red;">*</span></label>
                                    <select class="form-control" required name="type">
                                        <option value="">{{ __('messages.select_type') }}</option>
                                        <option value="{{ \App\Http\Controllers\LeaveController::LEAVE_TYPE_EARLY }}">{{ __('messages.early_leave') }}</option>
                                        <option value="{{ \App\Http\Controllers\LeaveController::LEAVE_TYPE_END_DAY }}">{{ __('messages.end_day') }}</option>
                                        <option value="{{ \App\Http\Controllers\LeaveController::LEAVE_TYPE_FULL_DAY }}">{{ __('messages.full_day') }}</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('messages.select_student') }} <span style="color: red;">*</span></label>
                                    <select class="form-control" required name="student_id">
                                        <option value="">{{ __('messages.select_student') }}</option>
                                        @foreach($getStudent as $student)
                                            <option value="{{ $student->id }}">{{ $student->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('messages.date') }} <span style="color: red;">*</span></label>
                                    <input type="date" class="form-control" required name="date" value="{{ old('date') }}">
                                </div>

                                <div class="form-group">
                                    <label>{{ __('messages.time') }} <span style="color: red;">*</span></label>
                                    <input type="time" class="form-control" required name="time" value="{{ old('time') }}">
                                </div>

                                <div class="form-group">
                                    <label>{{ __('messages.reason') }} <span style="color: red;">*</span></label>
                                    <textarea class="form-control" required name="reason" rows="4">{{ old('reason') }}</textarea>
                                </div>

                                <input type="hidden" name="user_type" value="parent">
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ __('messages.send') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection