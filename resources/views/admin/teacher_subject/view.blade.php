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
                                            <button type="button" 
                                                    class="btn btn-primary" 
                                                    data-toggle="modal" 
                                                    data-target="#evaluateModal{{ $subject->id }}">
                                                <i class="fas fa-star"></i> {{ __('messages.evaluate') }}
                                            </button>
                                            <a href="{{ url('admin/teacher_subject/evaluations/'.$subject->id) }}" 
                                               class="btn btn-info">
                                                <i class="fas fa-history"></i> {{ __('messages.view_evaluations') }}
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

<!-- Evaluation Modals -->
@foreach($subjects as $subject)
<div class="modal fade" id="evaluateModal{{ $subject->id }}" tabindex="-1" role="dialog" aria-labelledby="evaluateModalLabel{{ $subject->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="evaluateModalLabel{{ $subject->id }}">تقييم معلم المادة: {{ $subject->subject->name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('admin/teacher_subject/evaluate/'.$subject->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="evaluation_date">تاريخ التقييم</label>
                        <input type="date" class="form-control" id="evaluation_date" name="evaluation_date" required>
                    </div>
                    <div class="form-group">
                        <label for="notes">الملاحظات</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-primary">حفظ التقييم</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection