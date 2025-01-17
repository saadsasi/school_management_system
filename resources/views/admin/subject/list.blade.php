@extends('layouts.app')

@section('content')



<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ __('messages.subject_list') }}</h1>
          </div>
          <div class="col-sm-6" style="text-align: right;">
              <a href="{{ url('admin/subject/add') }}" class="btn btn-primary">{{ __('messages.add_new_subject') }}</a>
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
                <h3 class="card-title">{{ __('messages.search_subject') }}</h3>
              </div>
              <form method="get" action="">
                <div class="card-body">
                  <div class="row">
                    
                  
                  <div class="form-group col-md-4">
                    <label>{{ __('messages.name') }}</label>
                    <input type="text" class="form-control" value="{{ Request::get('name') }}" name="name"  placeholder="{{ __('messages.name') }}">
                  </div>


                  <div class="form-group col-md-4">
                     <label>{{ __('messages.subject_type') }}</label>
                     <select class="form-control" name="type">
                        <option value="">{{ __('messages.select_type') }}</option>
                        <option {{ (Request::get('type') == 'Theory') ? 'selected' : '' }} value="Theory">{{ __('messages.theory') }}</option>
                        <option {{ (Request::get('type') == 'Practical') ? 'selected' : '' }} value="Practical">{{ __('messages.practical') }}</option>
                    </select>
                  </div>

                  
                 

                  <div class="form-group col-md-3">
                    <button class="btn btn-primary" type="submit" style="margin-top: 30px;">{{ __('messages.search') }}</button>
                    <a href="{{ url('admin/subject/list') }}" class="btn btn-success" style="margin-top: 30px;">{{ __('messages.reset') }}</a>

                  </div>

                  </div>
                </div>
              </form>
            </div>
         


            @include('_message')
            
            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{ __('messages.subject_list') }}</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>{{ __('messages.subject_name') }}</th>
                      <th>{{ __('messages.grade_level') }}</th>
                      <th>{{ __('messages.subject_type') }}</th>
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
                          <td>{{ $value->name }}</td>
                          <td>
                            @switch($value->grade_level)
                                @case('first_primary')
                                    الصف الأول الابتدائي
                                    @break
                                @case('second_primary')
                                    الصف الثاني الابتدائي
                                    @break
                                @case('third_primary')
                                    الصف الثالث الابتدائي
                                    @break
                                @case('fourth_primary')
                                    الصف الرابع الابتدائي
                                    @break
                                @case('fifth_primary')
                                    الصف الخامس الابتدائي
                                    @break
                                @case('sixth_primary')
                                    الصف السادس الابتدائي
                                    @break
                                @case('first_preparatory')
                                    الصف الأول الإعدادي
                                    @break
                                @case('second_preparatory')
                                    الصف الثاني الإعدادي
                                    @break
                                @case('third_preparatory')
                                    الصف الثالث الإعدادي
                                    @break
                            @endswitch
                        </td>
                          <td>{{ $value->type }}</td>
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
                             <a href="{{ url('admin/subject/edit/'.$value->id) }}" class="btn btn-primary">{{ __('messages.edit') }}</a>
                            <a href="{{ url('admin/subject/delete/'.$value->id) }}" class="btn btn-danger">{{ __('messages.delete') }}</a>

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