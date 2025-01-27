@extends('layouts.app')

@section('content')

 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{__('messages.my_account')}}</h1>
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
                      <label>{{__('messages.full_name')}}</label>
                      <input type="text" class="form-control" value="{{ $getRecord->name }}" readonly>
                    </div>  

                    <div class="form-group col-md-6">
                      <label>{{__('messages.last_name')}}</label>
                      <input type="text" class="form-control" value="{{ $getRecord->last_name }}" readonly>
                    </div>  

                    <div class="form-group col-md-6">
                      <label>{{__('messages.gender')}}</label>
                      <input type="text" class="form-control" value="{{ $getRecord->gender }}" readonly>
                    </div>  

                     <div class="form-group col-md-6">
                      <label>{{__('messages.date_of_birth')}}</label>
                      <input type="text" class="form-control" value="{{ $getRecord->date_of_birth }}" readonly>
                    </div>  

                    <div class="form-group col-md-6">
                      <label>{{__('messages.mobile_number')}}</label>
                      <input type="text" class="form-control" value="{{ $getRecord->mobile_number }}" readonly>
                    </div> 

                    <div class="form-group col-md-6">
                      <label>{{__('messages.profile_pic')}} <span style="color: red;"></span></label>
                      <input type="file" class="form-control" name="profile_pic" >
                      <div style="color:red">{{ $errors->first('profile_pic') }}</div>
                      @if(!empty($getRecord->getProfile()))
                        <img src="{{  $getRecord->getProfile() }}" style="width: auto;height: 50px;"> 
                      @endif
                    </div> 

                     <div class="form-group col-md-6">
                      <label>{{__('messages.blood_group')}}</label>
                      <input type="text" class="form-control" value="{{ $getRecord->blood_group }}" readonly>
                    </div> 

                     <div class="form-group col-md-6">
                      <label>{{__('messages.height')}}</label>
                      <input type="text" class="form-control" value="{{ $getRecord->height }}" readonly>
                    </div> 

                     <div class="form-group col-md-6">
                      <label>{{__('messages.weight')}}</label>
                      <input type="text" class="form-control" value="{{ $getRecord->weight }}" readonly>
                    </div> 

                  </div>

                  <hr />

                  <div class="form-group">
                    <label>{{__('messages.email')}}</label>
                    <input type="email" class="form-control" value="{{ $getRecord->email }}" readonly>
                  </div>
               
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">{{__('messages.update')}}</button>
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