@extends('layouts.app')

@section('content')

 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ __('messages.add_new_class') }}</h1>
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
                    <label>{{ __('messages.class_name') }}</label>
                    <input type="text" class="form-control" name="name" required placeholder="{{ __('messages.class_name') }}">
                  </div>


                  <div class="form-group">
                    <label>{{ __('messages.amount') }} ($)</label>
                    <input type="number" class="form-control" name="amount" required placeholder="{{ __('messages.amount') }}">
                  </div>


                  <div class="form-group">
                    <label>{{ __('messages.status') }}</label>
                    <select class="form-control" name="status">
                        <option value="0">{{ __('messages.active') }}</option>
                        <option value="1">{{ __('messages.inactive') }}</option>
                    </select>
                    
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