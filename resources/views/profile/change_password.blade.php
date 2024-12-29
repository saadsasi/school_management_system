@extends('layouts.app')

@section('content')

 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>     {{ __('messages.change_password_title') }}</h1>
          </div>
    
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">

            

          <div class="col-md-12">
            @include('_message')
            <div class="card card-primary">
              <form method="post" action="">
                 {{ csrf_field() }}
                <div class="card-body">
                  <div class="form-group">
                    <label> {{ __('messages.change_password_old') }}</label>
                    <input type="password" class="form-control" name="old_password" required placeholder="{{ __('messages.change_password_old_placeholder') }}">
                  </div>

                  <div class="form-group">
                    <label>{{ __('messages.change_password_new') }}</label>
                    <input type="password" class="form-control" name="new_password" required placeholder="{{ __('messages.change_password_new_placeholder') }}">
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