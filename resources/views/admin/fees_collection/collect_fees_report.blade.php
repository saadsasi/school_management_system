@extends('layouts.app')

@section('content')



<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ __('messages.Collect_Fees_Report') }}</h1>
          </div>
                  
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">


                 <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{ __('messages.Search_Collect_Fees_Report') }}</h3>
              </div>
              <form method="get" action="">
                <div class="card-body">
                  <div class="row">

                  <div class="form-group col-md-2">
                    <label>{{ __('messages.Student_ID') }}</label>
                    <input type="text" class="form-control" placeholder="{{ __('messages.Student_ID') }}" value="{{ Request::get('student_id') }}" name="student_id">
                  </div>


                   <div class="form-group col-md-2">
                    <label>{{ __('messages.Student_Name') }}</label>
                    <input type="text" class="form-control" placeholder="{{ __('messages.Student_Name') }}" value="{{ Request::get('student_name') }}" name="student_name">
                  </div>

                  <div class="form-group col-md-2">
                    <label>{{ __('messages.Student_Last_Name') }}</label>
                    <input type="text" class="form-control" placeholder="{{ __('messages.Student_Last_Name') }}" value="{{ Request::get('student_last_name') }}" name="student_last_name">
                  </div>



                  <div class="form-group col-md-2">
                    <label>{{ __('messages.Class') }}</label>
                    <select class="form-control" name="class_id" >
                        <option value="">{{ __('messages.select') }}</option>                                              
                        @foreach($getClass as $class)                                         
                          <option {{ (Request::get('class_id') == $class->id) ? 'selected' : '' }} value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                  </div>

                   <div class="form-group col-md-2">
                    <label>{{ __('messages.Start_Created_Date') }}</label>
                    <input type="date" class="form-control"  value="{{ Request::get('start_created_date') }}" name="start_created_date">
                  </div>

                   <div class="form-group col-md-2">
                    <label>{{ __('messages.End_Created_Date') }}</label>
                    <input type="date" class="form-control"  value="{{ Request::get('end_created_date') }}" name="end_created_date">
                  </div>


                  <div class="form-group col-md-2">
                    <label>{{ __('messages.Payment_Type') }}</label>
                    <select class="form-control" name="payment_type">
                        <option value="">{{ __('messages.select') }}</option>
                        <option {{ (Request::get('payment_type') == 'Cash') ? 'selected' : '' }} value="Cash">{{ __('messages.Cash') }}</option>
                        <option {{ (Request::get('payment_type') == 'Cheque') ? 'selected' : '' }} value="Cheque">{{ __('messages.Cheque') }}</option>
                        <option {{ (Request::get('payment_type') == 'Paypal') ? 'selected' : '' }} value="Paypal">{{ __('messages.Paypal') }}</option>
                        <option {{ (Request::get('payment_type') == 'Stripe') ? 'selected' : '' }} value="Stripe">{{ __('messages.Stripe') }}</option>
                    </select>
                  </div>


                  <div class="form-group col-md-2">
                    <button class="btn btn-primary" type="submit" style="margin-top: 30px;">{{ __('messages.search') }}</button>
                    <a href="{{ url('admin/fees_collection/collect_fees_report') }}" class="btn btn-success" style="margin-top: 30px;">{{ __('messages.reset') }}</a>

                  </div>

                  </div>
                </div>
              </form>
            </div>





             @include('_message')          
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{ __('messages.Collect_Fees_Report') }}</h3>
                <form style="float: right;" method="post" action="{{ url('admin/fees_collection/export_collect_fees_report') }}">
                   {{ csrf_field() }}
                  <input type="hidden" value="{{ Request::get('student_id') }}" name="student_id">
                  <input type="hidden" value="{{ Request::get('student_name') }}" name="student_name">
                  <input type="hidden" value="{{ Request::get('student_last_name') }}" name="student_last_name">
                  <input type="hidden" value="{{ Request::get('class_id') }}" name="class_id">
                  <input type="hidden" value="{{ Request::get('start_created_date') }}" name="start_created_date">
                  <input type="hidden" value="{{ Request::get('end_created_date') }}" name="end_created_date">
                  <input type="hidden" value="{{ Request::get('payment_type') }}" name="payment_type">
                  <button type="submit" class="btn btn-primary">{{ __('messages.export_excel') }}</button>
                </form>
              </div>
              
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>{{ __('messages.student_id') }}</th>
                      <th>{{ __('messages.student_name') }}</th>
                      <th>{{ __('messages.class_name') }}</th>
                      <th>{{ __('messages.total_amount') }}</th>
                      <th>{{ __('messages.paid_amount') }}</th>
                      <th>{{ __('messages.remaning_amount') }}</th>
                      <th>{{ __('messages.payment_type') }}</th>
                      <th>{{ __('messages.remark') }}</th>
                      <th>{{ __('messages.created_by') }}</th>
                      <th>{{ __('messages.created_date') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                      @forelse($getRecord as $value)
                        <tr>
                          <td>{{ $value->id }}</td>
                          <td>{{ $value->student_id }}</td>
                          <td>{{ $value->student_name_first }} {{ $value->student_name_last }}</td>
                          <td>{{ $value->class_name }}</td>
                          <td>${{ number_format($value->total_amount, 2) }}</td>
                          <td>${{ number_format($value->paid_amount, 2) }}</td>
                          <td>${{ number_format($value->remaning_amount, 2) }}</td>
                          <td>{{ $value->payment_type }}</td>
                          <td>{{ $value->remark }}</td>
                          <td>{{ $value->created_name }}</td>
                          <td>{{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                        </tr>
                      @empty
                        <tr>
                          <td colspan="100%">{{ __('messages.record_not_found') }}</td>
                        </tr>
                      @endforelse
                  </tbody>
                </table>

                <div style="padding: 10px; float: right;">
                    {!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}
                </div>
                
              </div>

             
            </div>
            
          </div>
          
        </div>
        
      </div>
    </section>

  </div>


@endsection

@section('script')


@endsection