@extends('layouts.app')

@section('content')

 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{__('messages.add_new_student')}}</h1>
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
                      <label>{{__('messages.full_name')}} <span style="color: red;">*</span></label>
                      <input type="text" class="form-control" value="{{ old('name') }}" name="name" required placeholder="{{__('messages.full_name')}}">
                      <div style="color:red">{{ $errors->first('name') }}</div>
                    </div>  

                    <div class="form-group col-md-6">
                      <label>{{__('messages.last_name')}} <span style="color: red;">*</span></label>
                      <input type="text" class="form-control" value="{{ old('last_name') }}" name="last_name" required placeholder="{{__('messages.last_name')}}">
                      <div style="color:red">{{ $errors->first('last_name') }}</div>
                    </div>  



                    <div class="form-group col-md-6">
                      <label>{{__('messages.grade_level')}} <span style="color: red;">*</span></label>
                      <select class="form-control" required name="grade_level" id="grade_level">
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
                      <div style="color:red">{{ $errors->first('grade_level') }}</div>
                    </div>  

                    <div class="form-group col-md-6">
                      <label>{{__('messages.class_name')}} </label>
                      <select class="form-control"  name="class_id" id="class_id">
                          <option value="">{{__('messages.select_class')}}</option>
                          @foreach($getClass as $value)
                            <option {{ (old('class_id') == $value->id) ? 'selected' : '' }} value="{{ $value->id }}" data-grade="{{ $value->grade_level }}">{{ $value->name }}</option>
                          @endforeach
                      </select>
                      <div style="color:red">{{ $errors->first('class_id') }}</div>
                    </div>  

                    <div class="form-group col-md-6">
                      <label>{{__('messages.gender')}} <span style="color: red;">*</span></label>
                      <select class="form-control" required name="gender">
                          <option value="">{{__('messages.select_gender')}}</option>
                          <option {{ (old('gender') == 'Male') ? 'selected' : '' }} value="Male">{{__('messages.male')}}</option>
                          <option {{ (old('gender') == 'Female') ? 'selected' : '' }} value="Female">{{__('messages.female')}}</option>
                      </select>
                      <div style="color:red">{{ $errors->first('gender') }}</div>
                    </div>  


                     <div class="form-group col-md-6">
                      <label>{{__('messages.date_of_birth')}} <span style="color: red;">*</span></label>
                      <input type="date" class="form-control" required value="{{ old('date_of_birth') }}" name="date_of_birth" >
                      <div style="color:red">{{ $errors->first('date_of_birth') }}</div>
                    </div>  


                    <div class="form-group col-md-6">
                      <label>{{__('messages.mobile_number')}} <span style="color: red;"></span></label>
                      <input type="text" class="form-control" value="{{ old('mobile_number') }}" name="mobile_number"  placeholder="{{__('messages.mobile_number')}}">
                      <div style="color:red">{{ $errors->first('mobile_number') }}</div>
                    </div> 

                    <div class="form-group col-md-6">
                      <label>{{__('messages.admission_date')}} <span style="color: red;">*</span></label>
                      <input type="date" class="form-control" value="{{ old('admission_date') }}" name="admission_date"  required>
                      <div style="color:red">{{ $errors->first('admission_date') }}</div>
                    </div> 


                    <div class="form-group col-md-6">
                      <label>{{__('messages.profile_pic')}} <span style="color: red;"></span></label>
                      <input type="file" class="form-control" name="profile_pic" >
                      <div style="color:red">{{ $errors->first('profile_pic') }}</div>
                    </div> 

                     <div class="form-group col-md-6">
                      <label>{{__('messages.blood_group')}} <span style="color: red;"></span></label>
                      <input type="text" class="form-control" name="blood_group" value="{{ old('blood_group') }}" placeholder="{{__('messages.blood_group')}}">
                      <div style="color:red">{{ $errors->first('blood_group') }}</div>
                    </div> 


                     <div class="form-group col-md-6">
                      <label>{{__('messages.height')}} <span style="color: red;"></span></label>
                      <input type="text" class="form-control" name="height" value="{{ old('height') }}" placeholder="{{__('messages.height')}}">
                      <div style="color:red">{{ $errors->first('height') }}</div>
                    </div> 


                     <div class="form-group col-md-6">
                      <label>{{__('messages.weight')}} <span style="color: red;"></span></label>
                      <input type="text" class="form-control" name="weight" value="{{ old('weight') }}" placeholder="{{__('messages.weight')}}">
                      <div style="color:red">{{ $errors->first('weight') }}</div>
                    </div> 


                     <div class="form-group col-md-6">
                      <label>{{__('messages.status')}} <span style="color: red;">*</span></label>
                      <select class="form-control" required name="status">
                          <option value="">{{__('messages.select_status')}}</option>
                          <option {{ (old('status') == 0) ? 'selected' : '' }} value="0">{{__('messages.active')}}</option>
                          <option {{ (old('status') == 1) ? 'selected' : '' }} value="1">{{__('messages.inactive')}}</option>
                      </select>
                      <div style="color:red">{{ $errors->first('status') }}</div>
                    </div>  

                  </div>

                  <hr />


                  
                  <div class="form-group">
                    <label>{{__('messages.email')}} <span style="color: red;">*</span></label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="{{__('messages.email')}}">
                    <div style="color:red">{{ $errors->first('email') }}</div>
                  </div>
                  <div class="form-group">
                    <label>{{__('messages.password')}} <span style="color: red;">*</span></label>
                    <input type="password" class="form-control" name="password" required placeholder="{{__('messages.password')}}">
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">{{__('messages.submit')}}</button>
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
    // Hide all class options initially except the placeholder
    $("#class_id option:not(:first)").hide();
    
    // When grade level changes
    $("#grade_level").change(function() {
        var selectedGrade = $(this).val();
        
        // Reset class selection
        $("#class_id").val("");
        
        // Hide all options first
        $("#class_id option:not(:first)").hide();
        
        // Show only classes matching the selected grade
        $("#class_id option").each(function() {
            if ($(this).data('grade') === selectedGrade) {
                $(this).show();
            }
        });
    });
});
</script>
@endsection