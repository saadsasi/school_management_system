@extends('layouts.app')

@section('content')



<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ __('messages.Collect_Fees') }} <span style="color: blue;">({{ $getStudent->name }} {{ $getStudent->last_name }})</span></h1>
          </div>
          <div class="col-sm-6" style="text-align: right;">
            <button type="button" class="btn btn-primary" id="AddFees">{{ __('messages.add_fees') }}</button>
          </div>              
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
             @include('_message')          
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{ __('messages.payment_detail') }}</h3>
              </div>
              
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
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
                     @forelse($getFees as $value)
                      <tr>
                          <td>{{ $value->class_name }}</td>
                          <td>{{ __('messages.in_dinars') }} {{ number_format($value->total_amount, 2) }}</td>
                          <td>{{ __('messages.in_dinars') }} {{ number_format($value->paid_amount, 2) }}</td>
                          <td>{{ __('messages.in_dinars') }} {{ number_format($value->remaning_amount, 2) }}</td>
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
                
              </div>

             
            </div>
            
          </div>
          
        </div>
        
      </div>
    </section>

  </div>


<div class="modal fade" id="AddFeesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{ __('messages.add_fees') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       <form action="" method="post">
         {{ csrf_field() }}
      <div class="modal-body">

          <div class="form-group">
            <label class="col-form-label">{{ __('messages.class_name') }} : {{ $getStudent->class_name }}</label>
          </div>



          <div class="form-group">
            <label class="col-form-label">{{ __('messages.total_amount') }} : {{ __('messages.in_dinars') }} {{ number_format($getStudent->amount, 2) }}</label>            
          </div>

          <div class="form-group">
            <label class="col-form-label">{{ __('messages.paid_amount') }} : {{ __('messages.in_dinars') }} {{ number_format($paid_amount, 2) }}</label>            
          </div>

          <div class="form-group">
            @php
              $RemaningAmount = $getStudent->amount - $paid_amount;
            @endphp
            <label class="col-form-label">{{ __('messages.remaning_amount') }} : {{ __('messages.in_dinars') }} {{ number_format($RemaningAmount, 2) }}</label>            
          </div>

          <div class="form-group">
            <label class="col-form-label">{{ __('messages.amount') }} <span style="color:red;">*</span></label>
            <input type="number" class="form-control" name="amount">
          </div>

          <div class="form-group">
            <label class="col-form-label">{{ __('messages.payment_type') }} <span style="color:red;">*</span></label>
            <select class="form-control" name="payment_type" required>
                  <option value="">{{ __('messages.select') }}</option>
                  <option value="Cash">{{ __('messages.cash') }}</option>
                  <option value="Cheque">{{ __('messages.cheque') }}</option>
            </select>
          </div>

          <div class="form-group">
            <label class="col-form-label">{{ __('messages.remark') }} </label>
            <textarea class="form-control" name="remark" ></textarea>
          </div>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.close') }}</button>
        <button type="submit" class="btn btn-primary">{{ __('messages.submit') }}</button>
      </div>
       </form>
    </div>
  </div>
</div>

@endsection

@section('script')
  <script type="text/javascript">
      $('#AddFees').click(function() {
          $('#AddFeesModal').modal('show');
      });
  </script>

@endsection