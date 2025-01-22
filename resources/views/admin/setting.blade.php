@extends('layouts.app')

@section('content')

 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ __('messages.setting') }}</h1>
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
                  


                   <div class="form-group">
                      <label>{{ __('messages.logo') }} <span style="color: red;"></span></label>
                      <input type="file" class="form-control" name="logo">
                       @if(!empty($getRecord->getLogo()))
                        <img src="{{  $getRecord->getLogo() }}" style="width: auto;height: 50px;"> 
                      @endif
                  </div> 


                   <div class="form-group">
                      <label>{{ __('messages.fevicon_icon') }} <span style="color: red;"></span></label>
                      <input type="file" class="form-control" name="fevicon_icon" >
                       @if(!empty($getRecord->getFevicon()))
                        <img src="{{  $getRecord->getFevicon() }}" style="width: auto;height: 50px;"> 
                      @endif
                  </div> 


                  <div class="form-group">
                    <label>{{ __('messages.school_name') }}</label>
                    <input type="text" class="form-control" name="school_name" value="{{ $getRecord->school_name }}" >                                         
                  </div>


                  <div class="form-group">
                    <label>{{ __('messages.exam_description') }}</label>
                    <textarea class="form-control" name="exam_description">{{ $getRecord->exam_description }}</textarea>
                  </div>

               

                </div>

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
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