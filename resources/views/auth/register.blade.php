<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register</title>
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
      <p class="login-box-msg">Register a new account</p>
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
          <label>Select User Type <span style="color: red;">*</span></label>
          <select class="form-control" name="user_type" id="user_type" required>
            <option value="">Select Type</option>
            <option value="teacher">Teacher</option>
            <option value="student">Student</option>
            <option value="parent">Parent</option>
          </select>
        </div>

        <div class="row">
          <div class="form-group col-md-6">
            <label>First Name <span style="color: red;">*</span></label>
            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
          </div>

          <div class="form-group col-md-6">
            <label>Last Name <span style="color: red;">*</span></label>
            <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required>
          </div>
        </div>

        <!-- Student Specific Fields -->
        <div id="student_fields" style="display: none;">
          <div class="row">
            <div class="form-group col-md-6">
              <label>Admission Number <span style="color: red;">*</span></label>
              <input type="text" class="form-control" name="admission_number" value="{{ old('admission_number') }}">
            </div>
            <div class="form-group col-md-6">
              <label>Class <span style="color: red;">*</span></label>
              <select class="form-control" name="class_id">
                <option value="">Select Class</option>
                @foreach($getClass ?? [] as $class)
                  <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group col-md-6">
              <label>Roll Number</label>
              <input type="text" class="form-control" name="roll_number" value="{{ old('roll_number') }}">
            </div>
            <div class="form-group col-md-6">
              <label>Date of Birth <span style="color: red;">*</span></label>
              <input type="date" class="form-control" name="date_of_birth" value="{{ old('date_of_birth') }}">
            </div>
          </div>
        </div>

        <!-- Teacher Specific Fields -->
        <div id="teacher_fields" style="display: none;">
          <div class="row">
            <div class="form-group col-md-6">
              <label>Qualification <span style="color: red;">*</span></label>
              <input type="text" class="form-control" name="qualification" value="{{ old('qualification') }}">
            </div>
            <div class="form-group col-md-6">
              <label>Work Experience</label>
              <input type="text" class="form-control" name="work_experience" value="{{ old('work_experience') }}">
            </div>
          </div>
        </div>

        <!-- Parent Specific Fields -->
        <div id="parent_fields" style="display: none;">
          <div class="row">
            <div class="form-group col-md-6">
              <label>Occupation</label>
              <input type="text" class="form-control" name="occupation" value="{{ old('occupation') }}">
            </div>
            <div class="form-group col-md-6">
              <label>Address</label>
              <input type="text" class="form-control" name="address" value="{{ old('address') }}">
            </div>
          </div>
        </div>

        <!-- Common Fields -->
        <div class="row">
          <div class="form-group col-md-6">
            <label>Gender <span style="color: red;">*</span></label>
            <select class="form-control" name="gender" required>
              <option value="">Select Gender</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select>
          </div>

          <div class="form-group col-md-6">
            <label>Mobile Number <span style="color: red;">*</span></label>
            <input type="text" class="form-control" name="mobile_number" value="{{ old('mobile_number') }}" required>
          </div>

          <div class="form-group col-md-6">
            <label>Profile Picture</label>
            <input type="file" class="form-control" name="profile_pic">
          </div>

          <div class="form-group col-md-6">
            <label>Email <span style="color: red;">*</span></label>
            <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
          </div>

          <div class="form-group col-md-6">
            <label>Password <span style="color: red;">*</span></label>
            <input type="password" class="form-control" name="password" required>
          </div>

          <div class="form-group col-md-6">
            <label>Confirm Password <span style="color: red;">*</span></label>
            <input type="password" class="form-control" name="password_confirmation" required>
          </div>
        </div>

        <div class="row">
          <div class="col-8">
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
        </div>
      </form>

      <a href="{{ url('/') }}" class="text-center">I already have an account</a>
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
