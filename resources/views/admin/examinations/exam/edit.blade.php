@extends('layouts.app')

@section('content')

 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ __('messages.edit_exam') }}</h1>
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
                    <label>{{ __('messages.exam_name') }}</label>
                    <input type="text" class="form-control" value="{{ $getRecord->name }}" name="name" required placeholder="{{ __('messages.exam_name') }}">
                  </div>
                  <div class="form-group">
                    <label>{{ __('messages.note') }}</label>
                    <textarea class="form-control" name="note" placeholder="{{ __('messages.note') }}">{{ $getRecord->note }}</textarea>
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