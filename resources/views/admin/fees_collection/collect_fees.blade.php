@extends('layouts.app')

@section('content')



<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1>{{ __('messages.collect_fees') }}</h1>
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
                <h3 class="card-title">{{ __('messages.search_collect_fees_student') }}</h3>
              </div>
              <form method="get" action="">
                <div class="card-body">
                  <div class="row">
                    
                  
                  <div class="form-group col-md-2">
                    <label>{{ __('messages.class') }}</label>
                    <select class="form-control" name="class_id">
                        <option value="">{{ __('messages.Select_Class') }}</option>
                        @foreach($getClass as $class)
                        <option {{ (Request::get('class_id') == $class->id) ? 'selected' : '' }} value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                  </div>


                   <div class="form-group col-md-2">
                    <label>{{ __('messages.student_id') }}</label>
                    <input type="text" class="form-control" value="{{ Request::get('student_id') }}" name="student_id"  placeholder="{{ __('messages.student_id') }}">
                  </div>


                  <div class="form-group col-md-3">
                    <label>{{ __('messages.student_first_name') }}</label>
                    <input type="text" class="form-control" value="{{ Request::get('first_name') }}" name="first_name"  placeholder="{{ __('messages.student_first_name') }}">
                  </div>


                  <div class="form-group col-md-3">
                    <label>{{ __('messages.student_last_name') }}</label>
                    <input type="text" class="form-control" value="{{ Request::get('last_name') }}" name="last_name"  placeholder="{{ __('messages.student_last_name') }}">
                  </div>
                

                  <div class="form-group col-md-2">
                    <button class="btn btn-primary" type="submit" style="margin-top: 30px;">{{ __('messages.search') }}</button>
                    <a href="{{ url('admin/fees_collection/collect_fees') }}" class="btn btn-success" style="margin-top: 30px;">{{ __('messages.reset') }}</a>

                  </div>

                  </div>
                </div>
              </form>
            </div>
         


            @include('_message')
            
            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{ __('messages.student_list') }}</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>{{ __('messages.student_id') }}</th>
                      <th>{{ __('messages.student_name') }}</th>
                      <th>{{ __('messages.class_name') }}</th>
                      <th>{{ __('messages.total_amount') }}</th>
                      <th>{{ __('messages.paid_amount') }}</th>
                      <th>{{ __('messages.remaning_amount') }}</th>
                      <th>{{ __('messages.created_date') }}</th>
                      <th>{{ __('messages.action') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                      @if(!empty($getRecord))
                          @forelse($getRecord as $value)
                              @php
                                $paid_amount = $value->getPaidAmount($value->id, $value->class_id);

                                 $RemaningAmount = $value->amount - $paid_amount;
                              @endphp
                            <tr>
                              <td>{{ $value->id }}</td>
                              <td>{{ $value->name }} {{ $value->last_name }}</td>
                              <td>{{ $value->class_name }}</td>
                              <td>${{ number_format($value->amount, 2) }}</td>
                              <td>${{ number_format($paid_amount, 2) }}</td>
                              <td>${{ number_format($RemaningAmount, 2) }}</td>
                              <td>{{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                              <td>
                                  <a href="{{ url('admin/fees_collection/collect_fees/add_fees/'.$value->id) }}" class="btn btn-success">{{ __('messages.collect_fees') }}</a>
                              </td>
                            </tr>
                          @empty
                            <tr>
                              <td colspan="100%">{{ __('messages.record_not_found') }}</td>
                            </tr>
                          @endforelse
                      @else
                        <tr>
                          <td colspan="100%">{{ __('messages.record_not_found') }}</td>
                        </tr>
                      @endif
                  </tbody>
                </table>
                <div style="padding: 10px; float: right;">
                   @if(!empty($getRecord))
                     {!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}
                   @endif
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