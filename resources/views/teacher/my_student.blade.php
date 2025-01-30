@extends('layouts.app')

@section('content')



<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{__('messages.my_student_list')}}</h1>
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


        
         
         


            @include('_message')
            
            <!-- Search Filters Card -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{__('messages.search_filter')}}</h3>
              </div>

              <div class="card-body">
                <form method="get" action="{{ url('teacher/my_student') }}">
                  <div class="row">
                    <div class="form-group col-md-3">
                      <label>{{__('messages.first_name')}}</label>
                      <input type="text" class="form-control" name="name" value="{{ Request::get('name') }}" placeholder="{{__('messages.first_name')}}">
                    </div>
                    <div class="form-group col-md-3">
                      <label>{{__('messages.last_name')}}</label>
                      <input type="text" class="form-control" name="last_name" value="{{ Request::get('last_name') }}" placeholder="{{__('messages.last_name')}}">
                    </div>
                    <div class="form-group col-md-3">
                      <button class="btn btn-primary" type="submit" style="margin-top: 30px;">{{__('messages.search')}}</button>
                      <a href="{{ url('teacher/my_student') }}" class="btn btn-success" style="margin-top: 30px;">{{__('messages.reset')}}</a>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <!-- Data Table Card -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{__('messages.my_student_list')}}</h3>
              </div>
              
              <div class="card-body p-0" style="overflow: auto;">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>{{__('messages.profile_pic')}}</th>
                      <th>{{__('messages.name')}}</th>
                      <th>{{__('messages.email')}}</th>
                      <th>{{__('messages.class')}}</th>
                      <th>{{__('messages.parent_name')}}</th>
                      <th>{{__('messages.gender')}}</th>
                      <th>{{__('messages.dob')}}</th>
                      <th>{{__('messages.mobile_number')}}</th>
                      <th>{{__('messages.admission_date')}}</th>
                      <th>{{__('messages.created_date')}}</th>
                      <th>{{__('messages.action')}}</th>
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
                          <td>{{ $value->class_name }}</td>
                          <td>{{ $value->parent_name }}</td>
                          <td>{{ $value->gender }}</td>
                          <td>
                              @if(!empty($value->date_of_birth))
                                {{ date('d-m-Y', strtotime($value->date_of_birth)) }}
                              @endif
                          </td>
                          <td>{{ $value->mobile_number }}</td>
                          <td>
                            @if(!empty($value->admission_date))
                              {{ date('d-m-Y', strtotime($value->admission_date)) }}
                              @endif
                          </td>
                          <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                          <td>
                            <a href="{{ url('chat?receiver_id='.base64_encode($value->id)) }}" class="btn btn-primary btn-sm">
                              <i class="fas fa-comment"></i> {{__('messages.message_student')}}
                            </a>
                            @if(!empty($value->parent_id))
                            <a href="{{ url('chat?receiver_id='.base64_encode($value->parent_id)) }}" class="btn btn-info btn-sm">
                              <i class="fas fa-comment"></i> {{__('messages.message_parent')}}
                            </a>
                            @endif
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