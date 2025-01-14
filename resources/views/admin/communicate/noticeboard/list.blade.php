@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ __('messages.notice_board') }}</h1>
          </div>
          <div class="col-sm-6" style="text-align: right;">
              <a href="{{ url('admin/communicate/notice_board/add') }}" class="btn btn-primary">{{ __('messages.add_new_notice_board') }}</a>
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
                <h3 class="card-title">{{ __('messages.search_notice_board') }}</h3>
              </div>
              <form method="get" action="">
                <div class="card-body">
                  <div class="row">
                    
                  
                  <div class="form-group col-md-2">
                    <label>{{ __('messages.title') }}</label>
                    <input type="text" class="form-control" value="{{ Request::get('title') }}" name="title"  placeholder="{{ __('messages.title') }}">
                  </div>

                 

                 


                  <div class="form-group col-md-2">
                    <label>{{ __('messages.notice_date') }}</label>
                    <input type="date" class="form-control" name="notice_date_from" value="{{ Request::get('notice_date_from') }}"  >
                  </div>



                   <div class="form-group col-md-2">
                    <label>{{ __('messages.publish_date') }}</label>
                    <input type="date" class="form-control" name="publish_date_to" value="{{ Request::get('publish_date_to') }}"  >
                  </div>



                  <div class="form-group col-md-2">
                    <label>{{ __('messages.message_to') }}</label>
                    <select class="form-control" name="message_to">
                        <option value="">{{ __('messages.select') }}</option>
                        <option {{ (Request::get('message_to') == 3) ? 'selected' : '' }} value="3">{{ __('messages.student') }}</option>
                        <option {{ (Request::get('message_to') == 4) ? 'selected' : '' }} value="4">{{ __('messages.parent') }}</option>
                        <option {{ (Request::get('message_to') == 2) ? 'selected' : '' }} value="2">{{ __('messages.teacher') }}</option>
                    </select>
                  </div>




                  <div class="form-group col-md-3">
                    <button class="btn btn-primary" type="submit" style="margin-top: 10px;">{{ __('messages.search') }}</button>
                    <a href="{{ url('admin/communicate/notice_board') }}" class="btn btn-success" style="margin-top: 10px;">{{ __('messages.reset') }}</a>

                  </div>

                  </div>
                </div>
              </form>
            </div>


            @include('_message')
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{ __('messages.notice_board_list') }}</h3>
              </div>
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>{{ __('messages.title') }}</th>
                      <th>{{ __('messages.notice_date') }}</th>
                      <th>{{ __('messages.publish_date') }}</th>
                      <th>{{ __('messages.message_to') }}</th>
                      <th>{{ __('messages.created_by') }}</th>
                      <th>{{ __('messages.created_date') }}</th>
                      <th>{{ __('messages.action') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($getRecord as $value)
                        <tr>
                          <td>{{ $value->id }}</td>
                          <td>{{ $value->title }}</td>
                          <td>{{ date('d-m-Y', strtotime($value->notice_date)) }}</td>
                          <td>{{ date('d-m-Y', strtotime($value->publish_date)) }}</td>
                          <td>
                            @foreach($value->getMessage as $message)
                                @if($message->message_to == 2)
                                  <div>{{ __('messages.teacher') }}</div>
                                @elseif($message->message_to == 3)
                                  <div>{{ __('messages.student') }}</div>
                                @elseif($message->message_to == 4)
                                  <div>{{ __('messages.parent') }}</div>
                                @endif
                            @endforeach
                          </td>
                          <td>{{ $value->created_by_name }}</td>
                          <td>{{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                          <td>

                            <a href="{{ url('admin/communicate/notice_board/edit/'.$value->id) }}" class="btn btn-primary">{{ __('messages.edit') }}</a>

                            <a href="{{ url('admin/communicate/notice_board/delete/'.$value->id) }}" class="btn btn-danger">{{ __('messages.delete') }}</a>


                          </td>
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