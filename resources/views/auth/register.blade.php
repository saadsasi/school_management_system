<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{__('messages.register')}}</title>
  @php
    $getHeaderSetting = App\Models\SettingModel::getSingle();
  @endphp
  <link href="{{ $getHeaderSetting->getFevicon() }}" rel="icon" type="image/jpg" />
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ url('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ url('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url('dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition register-page">
<div class="register-box" style="width: 600px;">
  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">{{__('messages.register_new_account')}}</p>
      @include('_message')

    
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
      <form action="{{ url('register') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
          <label>{{__('messages.select_user_type')}} <span style="color: red;">*</span></label>
          <select class="form-control" name="user_type" id="user_type" required>
            <option value="">{{__('messages.select_type')}}</option>
            <option value="teacher">{{__('messages.teacher')}}</option>
            <option value="student">{{__('messages.student')}}</option>
            <option value="parent">{{__('messages.parent')}}</option>
          </select>
        </div>

        <div class="row">
          <div class="form-group col-md-6">
            <label>{{__('messages.first_name')}} <span style="color: red;">*</span></label>
            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
          </div>

          <div class="form-group col-md-6">
            <label>{{__('messages.last_name')}} <span style="color: red;">*</span></label>
            <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required>
          </div>
        </div>

        <!-- Student Specific Fields -->
        <div id="student_fields" style="display: none;">
          <div class="row">
            <div class="form-group col-md-6">
              <label>{{__('messages.admission_number')}} <span style="color: red;">*</span></label>
              <input type="text" class="form-control" name="admission_number" value="{{ old('admission_number') }}">
            </div>
            <div class="form-group col-md-6">
              <label>{{__('messages.grade_level')}} <span style="color: red;">*</span></label>
              <select class="form-control" name="grade_level">
                  <option value="">{{__('messages.select_grade_level')}}</option>
                  <option value="first_primary">{{__('messages.first_primary')}}</option>
                  <option value="second_primary">{{__('messages.second_primary')}}</option>
                  <option value="third_primary">{{__('messages.third_primary')}}</option>
                  <option value="fourth_primary">{{__('messages.fourth_primary')}}</option>
                  <option value="fifth_primary">{{__('messages.fifth_primary')}}</option>
                  <option value="sixth_primary">{{__('messages.sixth_primary')}}</option>
                  <option value="first_preparatory">{{__('messages.first_preparatory')}}</option>
                  <option value="second_preparatory">{{__('messages.second_preparatory')}}</option>
                  <option value="third_preparatory">{{__('messages.third_preparatory')}}</option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label>{{__('messages.roll_number')}}</label>
              <input type="text" class="form-control" name="roll_number" value="{{ old('roll_number') }}">
            </div>
            <div class="form-group col-md-6">
              <label>{{__('messages.date_of_birth')}} <span style="color: red;">*</span></label>
              <input type="date" class="form-control" name="date_of_birth" value="{{ old('date_of_birth') }}">
            </div>
          </div>
        </div>

        <!-- Teacher Specific Fields -->
        <div id="teacher_fields" style="display: none;">
          <div class="row">
            <div class="form-group col-md-6">
              <label>{{__('messages.qualification')}} <span style="color: red;">*</span></label>
              <input type="text" class="form-control" name="qualification" value="{{ old('qualification') }}">
            </div>
            <div class="form-group col-md-6">
              <label>{{__('messages.work_experience')}}</label>
              <input type="text" class="form-control" name="work_experience" value="{{ old('work_experience') }}">
            </div>
          </div>
        </div>

        <!-- Parent Specific Fields -->
        <div id="parent_fields" style="display: none;">
          <div class="row">
            <div class="form-group col-md-6">
              <label>{{__('messages.occupation')}}</label>
              <input type="text" class="form-control" name="occupation" value="{{ old('occupation') }}">
            </div>
            <div class="form-group col-md-6">
              <label>{{__('messages.address')}}</label>
              <input type="text" class="form-control" name="address" value="{{ old('address') }}">
            </div>
          </div>
        </div>

        <!-- Common Fields -->
        <div class="row">
          <div class="form-group col-md-6">
            <label>{{__('messages.gender')}} <span style="color: red;">*</span></label>
            <select class="form-control" name="gender" required>
              <option value="">{{__('messages.select_gender')}}</option>
              <option value="Male">{{__('messages.male')}}</option>
              <option value="Female">{{__('messages.female')}}</option>
            </select>
          </div>

          <div class="form-group col-md-6">
            <label>{{__('messages.mobile_number')}} <span style="color: red;">*</span></label>
            <input type="text" class="form-control" name="mobile_number" value="{{ old('mobile_number') }}" required>
          </div>

          <div class="form-group col-md-6">
            <label>{{__('messages.profile_picture')}}</label>
            <input type="file" class="form-control" name="profile_pic">
          </div>

          <div class="form-group col-md-6">
            <label>{{__('messages.email')}} <span style="color: red;">*</span></label>
            <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
          </div>

          <div class="form-group col-md-6">
            <label>{{__('messages.password')}} <span style="color: red;">*</span></label>
            <input type="password" class="form-control" name="password" required>
          </div>

          <div class="form-group col-md-6">
            <label>{{__('messages.confirm_password')}} <span style="color: red;">*</span></label>
            <input type="password" class="form-control" name="password_confirmation" required>
          </div>
        </div>

        <div class="row">
          <div class="col-8">
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">{{__('messages.register')}}</button>
          </div>
        </div>
      </form>

      <a href="{{ url('/') }}" class="text-center">{{__('messages.i_already_have_an_account')}}</a>
    </div>
  </div>
</div>

<!-- jQuery -->
<script src="{{ url('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ url('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ url('dist/js/adminlte.min.js') }}"></script>

<script>
$(document).ready(function() {
    $('#user_type').change(function() {
        var userType = $(this).val();
        $('#student_fields, #teacher_fields, #parent_fields').hide();
        
        if(userType == 'student') {
            $('#student_fields').show();
        } else if(userType == 'teacher') {
            $('#teacher_fields').show();
        } else if(userType == 'parent') {
            $('#parent_fields').show();
        }
    });
});
</script>
</body>
</html>
