@extends('layouts.app')

@section('content')



<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ __('messages.exam_timetable') }} <span style="color: blue;">({{ $getStudent->name }} {{ $getStudent->last_name }})</span></h1>
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
          
             @foreach($getRecord as $value)
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{ $value['name'] }}</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>{{ __('messages.subject_name') }}</th>
                      <th>{{ __('messages.day') }}</th>
                      <th>{{ __('messages.exam_date') }}</th>
                      <th>{{ __('messages.start_time') }} </th>
                      <th>{{ __('messages.end_time') }} </th>
                      <th>{{ __('messages.room_number') }}</th>
                      <th>{{ __('messages.full_marks') }} </th>                      
                      <th>{{ __('messages.passing_marks') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($value['exam'] as $valueS)
                      <tr>
                          <td>{{ $valueS['subject_name'] }}</td>
                          <td>{{ date('l', strtotime($valueS['exam_date'])) }}</td>
                          <td>{{ date('d-m-Y', strtotime($valueS['exam_date'])) }}</td>
                          <td>{{ date('h:i A', strtotime($valueS['start_time'])) }}</td>
                          <td>{{ date('h:i A', strtotime($valueS['end_time'])) }}</td>                          
                          <td>{{ $valueS['room_number'] }}</td>
                          <td>{{ $valueS['full_marks'] }}</td>
                          <td>{{ $valueS['passing_mark'] }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            @endforeach

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


