@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $teacher->name }} - {{ __('messages.assigned_subjects') }}</h1>
                </div>
                <div class="col-sm-6" style="text-align: right;">
                    <a href="{{ url('admin/teacher_subject/add/'.$teacher->id) }}" class="btn btn-primary">{{ __('messages.assign_new_subject') }}</a>
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
                            <h3 class="card-title">{{ __('messages.subjects_list') }}</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.subject') }}</th>
                                        <th>{{ __('messages.class') }}</th>
                                        <th>{{ __('messages.grade_level') }}</th>
                                        <th>{{ __('messages.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subjects as $subject)
                                    <tr>
                                        <td>{{ $subject->subject->name }}</td>
                                        <td>{{ $subject->class->name }}</td>
                                        <td>{{ $subject->grade_level }}</td>
                                        <td>
                                            <a href="{{ url('admin/teacher_subject/delete/'.$subject->id) }}" 
                                               class="btn btn-danger" 
                                               onclick="return confirm('{{ __('messages.confirm_delete') }}');">
                                                {{ __('messages.unassign') }}
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection