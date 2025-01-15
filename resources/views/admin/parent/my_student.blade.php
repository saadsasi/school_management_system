@extends('layouts.app')

@section('content')



<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1> {{__('messages.my_student_list')}} ({{ $getParent->name }} {{ $getParent->last_name }})</h1>
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
                <h3 class="card-title"> {{__('messages.search_student')}} </h3>
              </div>
              <form method="get" action="">
                <div class="card-body">
                  <div class="row">
                    


                  <div class="form-group col-md-4">
                    <label> {{__('messages.name')}} </label>
                    <input type="text" class="form-control" value="{{ Request::get('name') }}" name="name"  placeholder=" {{__('messages.name')}} ">
                  </div>

                  <div class="form-group col-md-4">
                    <label> {{__('messages.last_name')}} </label>
                    <input type="text" class="form-control" value="{{ Request::get('last_name') }}" name="last_name"  placeholder=" {{__('messages.last_name')}} ">
                  </div>



              

                  <div class="form-group col-md-3">
                    <button class="btn btn-primary" type="submit" style="margin-top: 30px;">{{ __('messages.search') }}</button>
                    <a href="{{ url('admin/parent/my-student/'.$parent_id) }}" class="btn btn-success" style="margin-top: 30px;">{{ __('messages.reset') }}</a>

                  </div>

                  </div>
                </div>
              </form>
            </div>


            @include('_message')
            
            <!-- /.card -->

@if(!empty($getSearchStudent))
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"> {{__('messages.student_list')}} </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th> {{__('messages.profile_pic')}} </th>
                      <th> {{__('messages.student_name')}} </th>
                      <th> {{__('messages.email')}} </th>
                      <th> {{__('messages.parent_name')}} </th>
                      <th> {{__('messages.created_date')}} </th>
                      <th> {{__('messages.action')}} </th>
                    </tr>
                  </thead>
                  <tbody>
                     @foreach($getSearchStudent as $value)
                        <tr>
                          <td>{{ $value->id }}</td>
                          <td>
                            @if(!empty($value->getProfile()))
                            <img src="{{ $value->getProfile() }}" style="height: 50px; width:50px; border-radius: 50px;">
                            @endif
                          </td>
                          <td>{{ $value->name }} {{ $value->last_name }}</td>
                          <td>{{ $value->email }}</td>
                          <td>{{ $value->parent_name }}</td>
                          
                          <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                          <td style="min-width: 150px;">

                            <a href="{{ url('admin/parent/assign_student_parent/'.$value->id.'/'.$parent_id) }}" class="btn btn-primary btn-sm"> {{__('messages.add_student_to_parent')}} </a>
                        
                          </td>
                        </tr>
                      @endforeach
                  </tbody>
                </table>
                <div style="padding: 10px; float: right;">
                  
                </div>

              </div>

              <!-- /.card-body -->
            </div>
@endif



             <div class="card">
              <div class="card-header">
                <h3 class="card-title"> {{__('messages.parent_student_list')}} </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                 <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th> {{__('messages.profile_pic')}} </th>
                      <th> {{__('messages.student_name')}} </th>
                      <th> {{__('messages.email')}} </th>
                      <th> {{__('messages.parent_name')}} </th>
                      <th> {{__('messages.created_date')}} </th>
                      <th> {{__('messages.action')}} </th>
                    </tr>
                  </thead>
                  <tbody>
                     @foreach($getRecord as $value)
                        <tr>
                          <td>{{ $value->id }}</td>
                          <td>
                            @if(!empty($value->getProfile()))
                            <img src="{{ $value->getProfile() }}" style="height: 50px; width:50px; border-radius: 50px;">
                            @endif
                          </td>
                          <td>{{ $value->name }} {{ $value->last_name }}</td>
                          <td>{{ $value->email }}</td>
                          <td>{{ $value->parent_name }}</td>
                          
                          <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                          <td style="min-width: 150px;">

                            <a href="{{ url('admin/parent/assign_student_parent_delete/'.$value->id) }}" class="btn btn-danger"> {{__('messages.delete_student')}} </a>
                        
                          </td>
                        </tr>
                      @endforeach
                  </tbody>
                </table>
                <div style="padding: 10px; float: right;">
                  
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