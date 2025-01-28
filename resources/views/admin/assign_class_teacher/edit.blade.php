@extends('layouts.app')

@section('content')

 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ __('messages.edit_assign_class_teacher') }}</h1>
          </div>
    
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <div class="card card-primary">
              <form method="post" action="">
                 {{ csrf_field() }}
                <div class="card-body">
                  <div class="form-group">
                    <label>{{ __('messages.grade_level') }}</label>
                    <select class="form-control" name="grade_level" id="grade_level" required>
                        <option value="">{{ __('messages.select_grade_level') }}</option>
                        <option value="first_primary" {{ ($classDetails->grade_level == 'first_primary') ? 'selected' : '' }}>{{ __('messages.first_primary') }}</option>
                        <option value="second_primary" {{ ($classDetails->grade_level == 'second_primary') ? 'selected' : '' }}>{{ __('messages.second_primary') }}</option>
                        <option value="third_primary" {{ ($classDetails->grade_level == 'third_primary') ? 'selected' : '' }}>{{ __('messages.third_primary') }}</option>
                        <option value="fourth_primary" {{ ($classDetails->grade_level == 'fourth_primary') ? 'selected' : '' }}>{{ __('messages.fourth_primary') }}</option>
                        <option value="fifth_primary" {{ ($classDetails->grade_level == 'fifth_primary') ? 'selected' : '' }}>{{ __('messages.fifth_primary') }}</option>
                        <option value="sixth_primary" {{ ($classDetails->grade_level == 'sixth_primary') ? 'selected' : '' }}>{{ __('messages.sixth_primary') }}</option>
                        <option value="first_preparatory" {{ ($classDetails->grade_level == 'first_preparatory') ? 'selected' : '' }}>{{ __('messages.first_preparatory') }}</option>
                        <option value="second_preparatory" {{ ($classDetails->grade_level == 'second_preparatory') ? 'selected' : '' }}>{{ __('messages.second_preparatory') }}</option>
                        <option value="third_preparatory" {{ ($classDetails->grade_level == 'third_preparatory') ? 'selected' : '' }}>{{ __('messages.third_preparatory') }}</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>{{ __('messages.class_name') }}</label>
                    <select class="form-control" name="class_id" id="class_id" required>
                        <option value="">{{ __('messages.select_class') }}</option>
                        @foreach($getClass as $class)
                          <option {{ ($getRecord->class_id == $class->id) ? 'selected' : '' }} value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                  </div>

                   <div class="form-group">
                    <label>{{ __('messages.teacher_name') }}</label>
                        @foreach($getTeacher as $teacher)
                        <div>
                          <label style="font-weight: normal;">
                            @php
                              $checked = '';                             
                            @endphp

                            @foreach($getAssignTeacherID as $teacherID)
                              @if($teacherID->teacher_id == $teacher->id)
                                @php
                                  $checked = 'checked';                             
                                @endphp
                              @endif
                            @endforeach
                            <input {{ $checked }} type="checkbox" value="{{ $teacher->id }}" name="teacher_id[]"> {{ $teacher->name }} {{ $teacher->last_name }}
                          </label>
                          </div>
                        @endforeach
                  </div>

                  <div class="form-group">
                    <label>{{ __('messages.status') }}</label>
                    <select class="form-control" name="status">
                        <option  {{ ($getRecord->status == 0) ? 'selected' : '' }} value="0">{{ __('messages.active') }}</option>
                        <option  {{ ($getRecord->status == 1) ? 'selected' : '' }} value="1">{{ __('messages.inactive') }}</option>
                    </select>
                    
                  </div>
              
                
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">{{ __('messages.update') }}</button>
                </div>
              </form>
            </div>
         

          </div>
          <!--/.col (left) -->
          <!-- right column -->
       
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection

@section('script')
<script type="text/javascript">
    $('#grade_level').change(function() {
        var grade_level = $(this).val();
        $.ajax({
            url: "{{ url('admin/assign_class_teacher/get_class_by_grade_level') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                grade_level: grade_level
            },
            dataType: "json",
            success: function(response) {
                $('#class_id').html(response.html);
            }
        });
    });
</script>
@endsection