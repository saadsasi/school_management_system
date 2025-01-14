@extends('layouts.app')

@section('content')

 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ __('messages.add_marks_grade') }}</h1>
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
                    <label>{{ __('messages.grade_name') }}</label>
                    <input type="text" class="form-control" value="{{ old('name') }}" name="name" required placeholder="{{ __('messages.grade_name') }}">
                  </div>
                  

                  <div class="form-group">
                    <label>{{ __('messages.percent_from') }}</label>
                    <input type="number" class="form-control" value="{{ old('percent_from') }}" name="percent_from" required placeholder="{{ __('messages.percent_from') }}">
                  </div>


                  <div class="form-group">
                    <label>{{ __('messages.percent_to') }}</label>
                    <input type="number" class="form-control" value="{{ old('percent_to') }}" name="percent_to" required placeholder="{{ __('messages.percent_to') }}">
                  </div>
                 
               
                
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">{{ __('messages.submit') }}</button>
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