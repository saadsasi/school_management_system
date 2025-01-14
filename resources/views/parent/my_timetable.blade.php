@extends('layouts.app')

@section('content')



<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ __('messages.my_timetable') }} ({{ $getClass->name }} - {{ $getSubject->name }}) <span style="color:blue">( {{ $getStudent->name }}  {{ $getStudent->last_name }} )</span></h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
         
           
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  {{ $getClass->name }} - {{ $getSubject->name }}
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>{{ __('messages.week') }}</th>
                      <th>{{ __('messages.start_time') }}</th>
                      <th>{{ __('messages.end_time') }}</th>
                      <th>{{ __('messages.room_number') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($getRecord as $valueW)
                      <tr>
                        <td>{{ $valueW['week_name'] }}</td>
                        <td>{{ !empty($valueW['start_time']) ? date('h:i A',strtotime($valueW['start_time'])) : '' }}</td>
                        <td>{{ !empty($valueW['end_time']) ? date('h:i A',strtotime($valueW['end_time'])) : '' }}</td>                        
                        <td>{{ $valueW['room_number'] }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
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


