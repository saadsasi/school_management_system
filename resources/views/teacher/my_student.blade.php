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
            
            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{__('messages.my_student_list')}}</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0" style="overflow: auto;">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>{{__('messages.profile_pic')}}</th>
                      <th>{{__('messages.name')}}</th>
                      <th>{{__('messages.email')}}</th>
                      <th>{{__('messages.admission_number')}}</th>
                      <th>{{__('messages.roll_number')}}</th>
                      <th>{{__('messages.class')}}</th>
                      <th>{{__('messages.gender')}}</th>
                      <th>{{__('messages.dob')}}</th>
                      <th>{{__('messages.mobile_number')}}</th>
                      <th>{{__('messages.admission_date')}}</th>
                      <th>{{__('messages.blood_group')}}</th>
                      <th>{{__('messages.height')}}</th>
                      <th>{{__('messages.weight')}}</th>
                      <th>{{__('messages.created_date')}}</th>
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
                          <td>{{ $value->admission_number }}</td>
                          <td>{{ $value->roll_number }}</td>
                          <td>{{ $value->class_name }}</td>
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
                          <td>{{ $value->blood_group }}</td>
                          <td>{{ $value->height }}</td>
                          <td>{{ $value->weight }}</td>
                          <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                          
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