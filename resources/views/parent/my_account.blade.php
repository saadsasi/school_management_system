@extends('layouts.app')

@section('content')

 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>  {{ __('messages.parent_account_title') }}</h1>
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

             @include('_message')
             
            <div class="card card-primary">
              <form method="post" action="" enctype="multipart/form-data">
                 {{ csrf_field() }}
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label>  {{ __('messages.full_name') }} <span style="color: red;">*</span></label>
                      <input type="text" class="form-control" value="{{ old('name', $getRecord->name) }}" name="name" required placeholder="{{ __('messages.full_name') }}">
                      <div style="color:red">{{ $errors->first('name') }}</div>
                    </div>  

                    <div class="form-group col-md-6">
                      <label>  {{ __('messages.last_name') }} <span style="color: red;">*</span></label>
                      <input type="text" class="form-control" value="{{ old('last_name', $getRecord->last_name) }}" name="last_name" required placeholder="{{ __('messages.last_name') }}">
                      <div style="color:red">{{ $errors->first('last_name') }}</div>
                    </div>  


 

                    <div class="form-group col-md-6">
                      <label>  {{ __('messages.gender') }} <span style="color: red;">*</span></label>
                      <select class="form-control" required name="gender">
                          <option value="">  {{ __('messages.select') }}</option>
                          <option {{ (old('gender', $getRecord->gender) == 'Male') ? 'selected' : '' }} value="Male">  {{ __('messages.male') }}</option>
                          <option {{ (old('gender', $getRecord->gender) == 'Female') ? 'selected' : '' }} value="Female">  {{ __('messages.female') }}</option>
                      </select>
                      <div style="color:red">{{ $errors->first('gender') }}</div>
                    </div>  


                  

                     <div class="form-group col-md-6">
                      <label>  {{ __('messages.occupation') }} <span style="color: red;"></span></label>
                      <input type="text" class="form-control" value="{{ old('occupation', $getRecord->occupation) }}" name="occupation"  placeholder="{{ __('messages.occupation') }}">
                      <div style="color:red">{{ $errors->first('occupation') }}</div>
                    </div>  

                 
                    <div class="form-group col-md-6">
                      <label> {{ __('messages.mobile') }}<span style="color: red;">*</span></label>
                      <input type="text" class="form-control" required value="{{ old('mobile_number', $getRecord->mobile_number) }}" name="mobile_number"  placeholder="{{ __('messages.mobile') }}">
                      <div style="color:red">{{ $errors->first('mobile_number') }}</div>
                    </div> 

                     <div class="form-group col-md-6">
                      <label> {{ __('messages.address') }}<span style="color: red;">*</span></label>
                      <input type="text" class="form-control" required value="{{ old('address', $getRecord->address) }}" name="address"  placeholder="{{ __('messages.address') }}">
                      <div style="color:red">{{ $errors->first('address') }}</div>
                    </div>  

                   


                    <div class="form-group col-md-6">
                      <label> {{ __('messages.profile_pic') }}<span style="color: red;"></span></label>
                      <input type="file" class="form-control" name="profile_pic" >
                      <div style="color:red">{{ $errors->first('profile_pic') }}</div>
                       @if(!empty($getRecord->getProfile()))
                        <img src="{{  $getRecord->getProfile() }}" style="width: auto;height: 50px;"> 
                      @endif
                    </div> 

                     


                     

                  </div>

                  <hr />


                  
                  <div class="form-group">
                    <label>  {{ __('messages.email') }}<span style="color: red;">*</span></label>
                    <input type="email" class="form-control" name="email" value="{{ old('email', $getRecord->email) }}" required placeholder="{{ __('messages.email') }}">
                    <div style="color:red">{{ $errors->first('email') }}</div>
                  </div>
                 
               
                
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">  {{ __('messages.update') }}</button>
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