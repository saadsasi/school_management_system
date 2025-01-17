@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('messages.teachers_list') }}</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('messages.teachers') }}</h3>
                        </div>
                        <form method="get" action="">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label>{{ __('messages.teacher_name') }}</label>
                                        <input type="text" class="form-control" name="name" value="{{ Request::get('name') }}" placeholder="{{ __('messages.enter_teacher_name') }}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>{{ __('messages.subject') }}</label>
                                        <select class="form-control" name="subject_id">
                                            <option value="">{{ __('messages.select_subject') }}</option>
                                            @foreach($subjects as $subject)
                                                <option {{ (Request::get('subject_id') == $subject->id) ? 'selected' : '' }} value="{{ $subject->id }}">{{ $subject->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <button style="margin-top: 30px;" type="submit" class="btn btn-primary">{{ __('messages.search') }}</button>
                                        <a style="margin-top: 30px;" href="{{ url('admin/teacher_subject/list') }}" class="btn btn-success">{{ __('messages.reset') }}</a>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.id') }}</th>
                                        <th>{{ __('messages.teacher_name') }}</th>
                                        <th>{{ __('messages.subjects_count') }}</th>
                                        <th>{{ __('messages.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($teachers as $teacher)
                                    <tr>
                                        <td>{{ $teacher->id }}</td>
                                        <td>{{ $teacher->name }}</td>
                                        <td>{{ $teacher->subjects_count }}</td>
                                        <td>
                                            <a href="{{ url('admin/teacher_subject/add/'.$teacher->id) }}" class="btn btn-primary">
                                                {{ __('messages.assign_subjects') }}
                                            </a>
                                           
                                            @if($teacher->subjects_count > 0)
                                            <a href="{{ url('admin/teacher_subject/edit/'.$teacher->id) }}" class="btn btn-warning">
                                                {{ __('messages.edit_subjects') }}
                                            </a>
                                            <a href="{{ url('admin/teacher_subject/view/'.$teacher->id) }}" class="btn btn-info">
                                                {{ __('messages.view_subjects') }}
                                            </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div style="padding: 10px; float: right;">
                                {!! $teachers->appends(request()->except('page'))->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection