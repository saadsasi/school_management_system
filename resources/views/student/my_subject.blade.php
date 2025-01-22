@extends('layouts.app')

@section('content')



<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{__('messages.my_subject')}}</h1>
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
                <h3 class="card-title">{{__('messages.my_subject')}}</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>{{__('messages.subject_name')}}</th>
                      <th>{{__('messages.subject_type')}}</th>
                      <th>{{__('messages.curriculum_file')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                   @foreach($getRecord as $value)
                    <tr>
                      <td>{{ $value->subject_name }}</td>
                      <td>{{ $value->subject_type }}</td>
                      <td>
                        <!-- Debug info -->
                        @php
                            \Log::info('Subject ID: ' . $value->subject_id);
                            \Log::info('Curriculum File: ' . ($value->curriculum_file ?? 'null'));
                        @endphp
                        
                        @if($value->curriculum_file)
                          <a href="{{ url('student/subject/download-curriculum/'.$value->subject_id) }}" 
                             class="btn btn-info btn-sm">
                              <i class="fas fa-download"></i> {{__('messages.download_curriculum')}}
                          </a>
                        @else
                          <span class="text-muted">{{__('messages.no_curriculum_file')}}</span>
                        @endif
                      </td>
                    </tr>
                   @endforeach
                  </tbody>
                </table>
                

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