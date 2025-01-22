@extends('layouts.app')

@section('content')



<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ __('messages.assign_class_supervisor') }} ({{ $getRecord->total() }})</h1>
          </div>
          <div class="col-sm-6" style="text-align: right;">
              <a href="{{ url('admin/assign_class_teacher/add') }}" class="btn btn-primary">{{ __('messages.add_new_assign_class_teacher') }}</a>
          </div>

         
          
        </div>
      </div><!-- /.container-fluid -->
    </section>




    <!-- Main content -->
    <section class="content">


      <div class="container-fluid">
        <div class="row">
       
          <!-- /.col -->
          <div class="col-md-12">


             <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{ __('messages.search_assign_class_supervisor') }}</h3>
              </div>
              <form method="get" action="">
                <div class="card-body">
                  <div class="row">
                    
                  
                  <div class="form-group col-md-4">
                    <label>{{ __('messages.class_name') }}</label>
                    <input type="text" class="form-control" value="{{ Request::get('class_name') }}" name="class_name"  placeholder="{{ __('messages.class_name') }}">
                  </div>

                  <div class="form-group col-md-4">
                    <label>{{ __('messages.teacher_name') }}</label>
                    <input type="text" class="form-control" value="{{ Request::get('teacher_name') }}" name="teacher_name"  placeholder="{{ __('messages.teacher_name') }}">
                  </div>

                
                  <div class="form-group col-md-2">
                    <button class="btn btn-primary" type="submit" style="margin-top: 30px;">{{ __('messages.search') }}</button>
                    <a href="{{ url('admin/assign_class_teacher/list') }}" class="btn btn-success" style="margin-top: 30px;">{{ __('messages.reset') }}</a>

                  </div>

                  </div>
                </div>
              </form>
            </div>

       

            @include('_message')
            
            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{ __('messages.assign_class_supervisor_list') }}</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>{{ __('messages.class_name') }}</th>
                      <th>{{ __('messages.teacher_name') }}</th>
                      <th>{{ __('messages.status') }}</th>
                      <th>{{ __('messages.created_by') }}</th>
                      <th>{{ __('messages.created_date') }}</th>
                      <th>{{ __('messages.action') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                     @foreach($getRecord as $value)
                        <tr>
                          <td>{{ $value->id }}</td>
                          <td>{{ $value->class_name }}</td>
                          <td>{{ $value->teacher_name }} {{ $value->teacher_last_name }}</td>
                          <td>
                            @if($value->status == 0)
                              {{ __('messages.active') }}
                            @else
                              {{ __('messages.inactive') }}
                            @endif
                          </td>
                          <td>{{ $value->created_by_name }}</td>
                          <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                          <td>
                               <a href="{{ url('admin/assign_class_teacher/edit/'.$value->id) }}" class="btn btn-primary">{{ __('messages.edit') }}</a>

                                <a href="{{ url('admin/assign_class_teacher/delete/'.$value->id) }}" class="btn btn-danger">{{ __('messages.delete') }}</a>

                          </td>
                        </tr>
                      @endforeach
                  </tbody>
                </table>
                 <div style="padding: 10px; float: right;">
                   {!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}  
                </div>

              </div>

              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
   
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection