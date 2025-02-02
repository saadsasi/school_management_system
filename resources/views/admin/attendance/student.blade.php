@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ __('messages.student_attendance') }}</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
       
          <!-- /.col -->
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{ __('messages.search_student_attendance') }}</h3>
              </div>
              <form method="get" action="">
                <div class="card-body">
                  <div class="row">
                  <div class="form-group col-md-3">
                    <label>{{ __('messages.grade_level') }}</label>
                    <select class="form-control" name="grade_level" id="grade_level" required>
                        <option value="">{{ __('messages.select_grade_level') }}</option>
                        <option {{ (Request::get('grade_level') == 'first_primary') ? 'selected' : '' }} value="first_primary">{{ __('messages.first_primary') }}</option>
                        <option {{ (Request::get('grade_level') == 'second_primary') ? 'selected' : '' }} value="second_primary">{{ __('messages.second_primary') }}</option>
                        <option {{ (Request::get('grade_level') == 'third_primary') ? 'selected' : '' }} value="third_primary">{{ __('messages.third_primary') }}</option>
                        <option {{ (Request::get('grade_level') == 'fourth_primary') ? 'selected' : '' }} value="fourth_primary">{{ __('messages.fourth_primary') }}</option>
                        <option {{ (Request::get('grade_level') == 'fifth_primary') ? 'selected' : '' }} value="fifth_primary">{{ __('messages.fifth_primary') }}</option>
                        <option {{ (Request::get('grade_level') == 'sixth_primary') ? 'selected' : '' }} value="sixth_primary">{{ __('messages.sixth_primary') }}</option>
                        <option {{ (Request::get('grade_level') == 'first_preparatory') ? 'selected' : '' }} value="first_preparatory">{{ __('messages.first_preparatory') }}</option>
                        <option {{ (Request::get('grade_level') == 'second_preparatory') ? 'selected' : '' }} value="second_preparatory">{{ __('messages.second_preparatory') }}</option>
                        <option {{ (Request::get('grade_level') == 'third_preparatory') ? 'selected' : '' }} value="third_preparatory">{{ __('messages.third_preparatory') }}</option>
                    </select>
                  </div>

                  <div class="form-group col-md-3">
                    <label>{{ __('messages.class') }}</label>
                    <select class="form-control" name="class_id" id="getClass" required>
                        <option value="">{{ __('messages.select') }}</option>                                              
                        @foreach($getClass as $class)                                         
                          <option {{ (Request::get('class_id') == $class->id) ? 'selected' : '' }} value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                  </div>

                   <div class="form-group col-md-3">
                    <label>{{ __('messages.attendance_date') }}</label>
                    <input type="date" class="form-control" id="getAttendanceDate" value="{{ Request::get('attendance_date') }}" required name="attendance_date">
                  </div>


                  <div class="form-group col-md-3">
                    <button class="btn btn-primary" type="submit" style="margin-top: 30px;">{{ __('messages.search') }}</button>
                    <a href="{{ url('admin/attendance/student') }}" class="btn btn-success" style="margin-top: 30px;">{{ __('messages.reset') }}</a>

                  </div>

                  </div>
                </div>
              </form>
            </div>

            @if(!empty(Request::get('class_id')) && !empty(Request::get('attendance_date')))
            
                 <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">{{ __('messages.student_list') }}</h3>
                    </div>
                    
                    <div class="card-body p-0" style="overflow: auto;">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>{{ __('messages.student_id') }}</th>
                            <th>{{ __('messages.student_name') }}</th>
                            <th>{{ __('messages.attendance') }}</th>
                            <th>{{ __('messages.notes') }}</th>
                          </tr>
                        </thead>
                        <tbody>
                          @if(!empty($getStudent) && !empty($getStudent->count()))
                             @foreach($getStudent as $value)
                              @php
                                  $attendance_type = ''; 
                                  $getAttendance = $value->getAttendance($value->id, Request::get('class_id'), Request::get('attendance_date'));

                                  if(!empty($getAttendance->attendance_type))
                                  {
                                      $attendance_type = $getAttendance->attendance_type; 
                                  }

                              @endphp
                               <tr>
                                 <td>{{ $value->id }}</td>
                                 <td>{{ $value->name }} {{ $value->last_name }}</td>
                                 <td>
                                  <label style="margin-right: 10px;">
                                    <input value="1" type="radio" {{ ($attendance_type == '1') ? 'checked' : '' }} id="{{ $value->id }}" class="attendance-radio" name="attendance{{ $value->id }}"> {{ __('messages.present') }}
                                  </label>
                                  <label style="margin-right: 10px;">
                                    <input value="2" type="radio" {{ ($attendance_type == '2') ? 'checked' : '' }} id="{{ $value->id }}" class="attendance-radio" name="attendance{{ $value->id }}"> {{ __('messages.late') }}
                                  </label>
                                  <label style="margin-right: 10px;">
                                    <input value="3" type="radio" {{ ($attendance_type == '3') ? 'checked' : '' }} id="{{ $value->id }}" class="attendance-radio" name="attendance{{ $value->id }}"> {{ __('messages.absent') }}
                                  </label>
                                  <label>
                                    <input value="4" type="radio" {{ ($attendance_type == '4') ? 'checked' : '' }} id="{{ $value->id }}" class="attendance-radio" name="attendance{{ $value->id }}"> {{ __('messages.half_day') }}
                                  </label>

                                 </td>
                                 <td>
                                    <textarea name="notes{{ $value->id }}" class="form-control attendance-notes" rows="1" placeholder="{{ __('messages.enter_notes') }}">{{ !empty($getAttendance->notes) ? $getAttendance->notes : '' }}</textarea>
                                 </td>
                               </tr>
                             @endforeach
                          @endif
                        </tbody>
                      </table>
                    </div>
                    <div class="card-footer">
                      <button type="button" class="btn btn-primary" id="saveAllAttendance">{{ __('messages.save_all_attendance') }}</button>
                    </div>
                  </div>
            @endif
          </div>
        
        </div>
        
      </div>
    </section>
  </div>

@endsection

@section('script')

<script type="text/javascript">
  $(document).ready(function() {
    // Handle grade level change
    $('#grade_level').change(function() {
      var grade_level = $(this).val();
      
      // Clear class dropdown
      $('#getClass').html('<option value="">{{ __('messages.select') }}</option>');
      
      if(grade_level) {
        // Get classes for selected grade level
        $.ajax({
          type: "GET",
          url: "{{ url('admin/get-classes-by-grade') }}/" + grade_level,
          success: function(data) {
            if(data.length > 0) {
              data.forEach(function(item) {
                $('#getClass').append('<option value="' + item.id + '">' + item.name + '</option>');
              });
            }
          }
        });
      }
    });
  });

  $('#saveAllAttendance').click(function(e) {
    var attendanceData = [];
    
    // Collect all attendance data
    $('.attendance-radio:checked').each(function() {
      var student_id = $(this).attr('id');
      var attendance_type = $(this).val();
      var notes = $('textarea[name="notes'+student_id+'"]').val();
      
      attendanceData.push({
        student_id: student_id,
        attendance_type: attendance_type,
        notes: notes
      });
    });

    var class_id = $('#getClass').val();
    var attendance_date = $('#getAttendanceDate').val();
   
    // Send all attendance data at once
    $.ajax({
          type: "POST",
          url: "{{ url('admin/attendance/student/save') }}",
          data : {
             "_token": "{{ csrf_token() }}",
            attendance_data: attendanceData,
            class_id : class_id,
            attendance_date : attendance_date,           
          },
          dataType : "json",
          success: function(data) {
              alert(data.message);
          },
          error: function(xhr, status, error) {
              alert('Error saving attendance. Please try again.');
          }
    });
  });
</script>

@endsection