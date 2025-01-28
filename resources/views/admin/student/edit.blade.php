@extends('layouts.app')

@section('content')

 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ __('messages.edit_student') }}</h1>
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
              <form method="post" action="" enctype="multipart/form-data">
                 {{ csrf_field() }}
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label>{{ __('messages.name') }} <span style="color: red;">*</span></label>
                      <input type="text" class="form-control" value="{{ old('name', $getRecord->name) }}" name="name" required placeholder="{{ __('messages.name') }}">
                      <div style="color:red">{{ $errors->first('name') }}</div>
                    </div>  

                    <div class="form-group col-md-6">
                      <label>{{ __('messages.last_name') }} <span style="color: red;">*</span></label>
                      <input type="text" class="form-control" value="{{ old('last_name', $getRecord->last_name) }}" name="last_name" required placeholder="{{ __('messages.last_name') }}">
                      <div style="color:red">{{ $errors->first('last_name') }}</div>
                    </div>  


                  

                    <div class="form-group col-md-6">
                      <label>{{ __('messages.grade_level') }} <span style="color: red;">*</span></label>
                      <select class="form-control" required name="grade_level" id="grade_level">
                          <option value="">{{ __('messages.select_grade_level') }}</option>
                        <option {{ (old('grade_level', $getRecord->grade_level) == 'first_primary') ? 'selected' : '' }} value="first_primary">{{ __('messages.first_primary') }}</option>
                        <option {{ (old('grade_level', $getRecord->grade_level) == 'second_primary') ? 'selected' : '' }} value="second_primary">{{ __('messages.second_primary') }}</option>
                        <option {{ (old('grade_level', $getRecord->grade_level) == 'third_primary') ? 'selected' : '' }} value="third_primary">{{ __('messages.third_primary') }}</option>
                        <option {{ (old('grade_level', $getRecord->grade_level) == 'fourth_primary') ? 'selected' : '' }} value="fourth_primary">{{ __('messages.fourth_primary') }}</option>
                        <option {{ (old('grade_level', $getRecord->grade_level) == 'fifth_primary') ? 'selected' : '' }} value="fifth_primary">{{ __('messages.fifth_primary') }}</option>
                        <option {{ (old('grade_level', $getRecord->grade_level) == 'sixth_primary') ? 'selected' : '' }} value="sixth_primary">{{ __('messages.sixth_primary') }}</option>
                        <option {{ (old('grade_level', $getRecord->grade_level) == 'first_preparatory') ? 'selected' : '' }} value="first_preparatory">{{ __('messages.first_preparatory') }}</option>
                        <option {{ (old('grade_level', $getRecord->grade_level) == 'second_preparatory') ? 'selected' : '' }} value="second_preparatory">{{ __('messages.second_preparatory') }}</option>
                        <option {{ (old('grade_level', $getRecord->grade_level) == 'third_preparatory') ? 'selected' : '' }} value="third_preparatory">{{ __('messages.third_preparatory') }}</option>
                      </select>
                      <div style="color:red">{{ $errors->first('grade_level') }}</div>
                    </div>

                    <div class="form-group col-md-6">
                      <label>{{ __('messages.class') }} <span style="color: red;">*</span></label>
                      <select class="form-control" required name="class_id" id="class_id">
                          <option value="">{{ __('messages.select_class') }}</option>
                      </select>
                      <div style="color:red">{{ $errors->first('class_id') }}</div>
                    </div>  

                    
                    <div class="form-group col-md-6">
                      <label>{{ __('messages.gender') }} <span style="color: red;">*</span></label>
                      <select class="form-control" required name="gender">
                          <option value="">{{ __('messages.select_gender') }}</option>
                          <option {{ (old('gender', $getRecord->gender) == 'Male') ? 'selected' : '' }} value="Male">{{ __('messages.male') }}</option>
                          <option {{ (old('gender', $getRecord->gender) == 'Female') ? 'selected' : '' }} value="Female">{{ __('messages.female') }}</option>
                      </select>
                      <div style="color:red">{{ $errors->first('gender') }}</div>
                    </div>  


                     <div class="form-group col-md-6">
                      <label>{{ __('messages.date_of_birth') }} <span style="color: red;">*</span></label>
                      <input type="date" class="form-control" required value="{{ old('date_of_birth', $getRecord->date_of_birth) }}" name="date_of_birth" >
                      <div style="color:red">{{ $errors->first('date_of_birth') }}</div>
                    </div>  


                    <div class="form-group col-md-6">
                      <label>{{ __('messages.mobile_number') }} <span style="color: red;"></span></label>
                      <input type="text" class="form-control" value="{{ old('mobile_number', $getRecord->mobile_number) }}" name="mobile_number"  placeholder="{{ __('messages.mobile_number') }}">
                      <div style="color:red">{{ $errors->first('mobile_number') }}</div>
                    </div> 

                    <div class="form-group col-md-6">
                      <label>{{ __('messages.admission_date') }} <span style="color: red;">*</span></label>
                      <input type="date" class="form-control" value="{{ old('admission_date', $getRecord->admission_date) }}" name="admission_date"  required>
                      <div style="color:red">{{ $errors->first('admission_date') }}</div>
                    </div> 



                    <div class="form-group col-md-6">
                      <label>{{ __('messages.profile_pic') }} <span style="color: red;"></span></label>
                      <input type="file" class="form-control" name="profile_pic" >
                      <div style="color:red">{{ $errors->first('profile_pic') }}</div>
                      @if(!empty($getRecord->getProfile()))
                        <img src="{{  $getRecord->getProfile() }}" style="width: auto;height: 50px;"> 
                      @endif
                    </div> 


                     <div class="form-group col-md-6">
                      <label>{{ __('messages.status') }} <span style="color: red;">*</span></label>
                      <select class="form-control" required name="status">
                          <option value="">{{ __('messages.select_status') }}</option>
                          <option {{ (old('status', $getRecord->status) == 0) ? 'selected' : '' }} value="0">{{ __('messages.active') }}</option>
                          <option {{ (old('status', $getRecord->status) == 1) ? 'selected' : '' }} value="1">{{ __('messages.inactive') }}</option>
                      </select>
                      <div style="color:red">{{ $errors->first('status') }}</div>
                    </div>  

                  </div>

                  <hr />

                  <div class="form-group">
                    <label>{{ __('messages.email') }} <span style="color: red;">*</span></label>
                    <input type="email" class="form-control" name="email" value="{{ old('email', $getRecord->email) }}" required placeholder="{{ __('messages.email') }}">
                    <div style="color:red">{{ $errors->first('email') }}</div>
                  </div>
                  <div class="form-group">
                    <label>{{ __('messages.password') }} <span style="color: red;"></span></label>
                    <input type="text" class="form-control" name="password"  placeholder="{{ __('messages.password') }}">
                    <p>{{ __('messages.password_note') }}</p>
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
$(document).ready(function() {
    // Function to load classes based on grade level
    function loadClasses(gradeLevel) {
        $.ajax({
            url: '/get-classes-by-grade/' + gradeLevel,
            type: 'GET',
            success: function(response) {
                var classSelect = $('#class_id');
                classSelect.empty();
                classSelect.append('<option value="">{{ __("messages.select_class") }}</option>');
                
                $.each(response.classes, function(key, value) {
                    var selected = (value.id == '{{ $getRecord->class_id }}') ? 'selected' : '';
                    classSelect.append('<option value="' + value.id + '" ' + selected + '>' + value.name + '</option>');
                });
            }
        });
    }

    // Load classes when grade level changes
    $('#grade_level').on('change', function() {
        var gradeLevel = $(this).val();
        if (gradeLevel) {
            loadClasses(gradeLevel);
        } else {
            $('#class_id').empty().append('<option value="">{{ __("messages.select_class") }}</option>');
        }
    });

    // Load classes for initial grade level if set
    var initialGradeLevel = $('#grade_level').val();
    if (initialGradeLevel) {
        loadClasses(initialGradeLevel);
    }
});
</script>
@endsection