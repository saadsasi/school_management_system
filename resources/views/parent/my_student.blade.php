@extends('layouts.app')

@section('content')



<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>  {{ __('messages.parent_my_student') }}</h1>
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
            
            <!-- /.card -->




             <div class="card">
              <div class="card-header">
                <h3 class="card-title">     {{ __('messages.parent_my_student') }} </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0"  style="overflow: auto;">
                 <table class="table table-striped">
                  <thead>
                    <tr>
                    
                      <th>  {{ __('messages.parent_profile_pic') }}</th>
                      <th>  {{ __('messages.parent_student_name') }} </th>   
                      <th>   {{ __('messages.parent_email') }} </th>
                      <th>   {{ __('messages.parent_admission_number') }}</th>
                      <th>  {{ __('messages.parent_roll_number') }}</th>
                      <th> {{ __('messages.parent_class') }}</th>
                      
                      
                      <th> {{ __('messages.parent_admission_date') }}</th>
                      <th>     {{ __('messages.parent_blood_group') }}</th>
                      <th>   {{ __('messages.parent_height') }}</th>
                      <th>   {{ __('messages.parent_weight') }}</th>
                      <th>  {{ __('messages.parent_created_date') }}</th>
                      <th>  {{ __('messages.parent_action') }}</th>
                     
                    </tr>
                  </thead>
                  <tbody>
                     @foreach($getRecord as $value)
                        <tr>
                          
                          
                          <td>
                            @if(!empty($value->getProfile()))
                            <img src="{{ $value->getProfile() }}" style="height: 50px; width:50px; border-radius: 50px;">
                            @endif
                          </td>

                          <td>{{ $value->name }} {{ $value->last_name }}</td>
                          <td>{{ $value->email }}</td>
                          <td>{{ $value->admission_number }}</td>
                          <td>{{ $value->roll_number }}</td>
                          <td>{{ $value->class_name }}</td>
                        
                       
                          <td>
                            @if(!empty($value->admission_date))
                              {{ date('d-m-Y', strtotime($value->admission_date)) }}
                              @endif
                          </td>
                          <td>{{ $value->blood_group }}</td>
                          <td>{{ $value->height }}</td>
                          <td>{{ $value->weight }}</td>
                          
                          <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                          <td style="min-width: 300px;">
                            <a  style="margin-bottom: 10px;" class="btn btn-success btn-sm" href="{{ url('parent/my_student/subject/'.$value->id) }}">{{ __('messages.subject') }}</a>
                            <a style="margin-bottom: 10px;" class="btn btn-primary btn-sm" href="{{ url('parent/my_student/exam_timetable/'.$value->id) }}">{{ __('messages.exam_timetable') }}</a>

                            <a style="margin-bottom: 10px;" class="btn btn-primary btn-sm" href="{{ url('parent/my_student/exam_result/'.$value->id) }}">{{ __('messages.exam_result') }}</a>

                            <a style="margin-bottom: 10px;" class="btn btn-warning btn-sm" href="{{ url('parent/my_student/calendar/'.$value->id) }}">{{ __('messages.calendar') }}</a>

                            <a style="margin-bottom: 10px;" class="btn btn-primary btn-sm" href="{{ url('parent/my_student/attendance/'.$value->id) }}">{{ __('messages.attendance') }}</a>

                            <a style="margin-bottom: 10px;" class="btn btn-success btn-sm" href="{{ url('parent/my_student/fees_collection/'.$value->id) }}">{{ __('messages.fees_collection') }}</a>


                            <a style="margin-bottom: 10px;" href="{{ url('chat?receiver_id='.base64_encode($value->id)) }}" class="btn btn-success btn-sm">{{ __('messages.send_message') }}</a>

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