@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $getTeacher->name }} - {{ __('messages.edit_subjects') }}</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <form action="{{ url('admin/teacher_subject/update/'.$getTeacher->id) }}" method="post">
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ __('messages.grade_level') }} <span style="color: red;">*</span></label>
                                            <select name="grade_level" class="form-control" id="grade_level" required>
                                                <option value="">{{ __('messages.select_grade') }}</option>
                                                @foreach($grades as $grade)
                                                    <option value="{{ $grade->grade_level }}" 
                                                        {{ ($assignedSubjects->first() && $assignedSubjects->first()->grade_level == $grade->grade_level) ? 'selected' : '' }}>
                                                        {{ $grade->grade_level }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>{{ __('messages.class') }} <span style="color: red;">*</span></label>
                                            <select name="class_id" class="form-control" id="class_id" required>
                                                <option value="">{{ __('messages.select_class') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ __('messages.subjects') }} <span style="color: red;">*</span></label>
                                            <div class="subject-list" style="max-height: 300px; overflow-y: auto; border: 1px solid #ddd; padding: 10px;">
                                                <div id="subjects_container">
                                                    <!-- Subjects will be loaded here -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ __('messages.update') }}</button>
                                <a href="{{ url('admin/teacher_subject/view/'.$getTeacher->id) }}" class="btn btn-default">{{ __('messages.cancel') }}</a>
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
<script type="text/javascript">
$(document).ready(function() {
    // تحميل البيانات الأولية عند تحميل الصفحة
    if($('#grade_level').val()) {
        loadClassesAndSubjects($('#grade_level').val());
    }

    $('#grade_level').change(function() {
        var grade_level = $(this).val();
        if(grade_level) {
            loadClassesAndSubjects(grade_level);
        } else {
            $('#class_id').html('<option value="">{{ __("messages.select_class") }}</option>').prop('disabled', true);
            $('#subjects_container').html('');
        }
    });

    function loadClassesAndSubjects(grade_level) {
        $.ajax({
            url: '{{ url("admin/teacher_subject/get-classes-subjects") }}',
            type: 'GET',
            data: {grade_level: grade_level},
            success: function(response) {
                // تحديث قائمة الفصول
                var classSelect = $('#class_id');
                var currentClassId = '{{ $assignedSubjects->first() ? $assignedSubjects->first()->class_id : "" }}';
                classSelect.html('<option value="">{{ __("messages.select_class") }}</option>');
                $.each(response.classes, function(key, value) {
                    classSelect.append('<option value="'+ value.id +'" '+ (currentClassId == value.id ? 'selected' : '') +'>'+ value.name +'</option>');
                });
                classSelect.prop('disabled', false);

                // تحديث قائمة المواد
                var subjectsHtml = '';
                var assignedSubjectIds = {!! json_encode($assignedSubjects->pluck('subject_id')->toArray()) !!};
                $.each(response.subjects, function(key, subject) {
                    subjectsHtml += `
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" 
                                   id="subject_${subject.id}" 
                                   name="subject_ids[]" 
                                   value="${subject.id}"
                                   ${assignedSubjectIds.includes(subject.id) ? 'checked' : ''}>
                            <label class="custom-control-label" for="subject_${subject.id}">
                                ${subject.name}
                            </label>
                        </div>`;
                });
                $('#subjects_container').html(subjectsHtml);
            }
        });
    }
});
</script>
@endsection