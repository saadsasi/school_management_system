@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ __('messages.teacher_list') }} ({{__('messages.total')}} : {{ $getRecord->total() }})</h1>
          </div>
          <div class="col-sm-6" style="text-align: right;">
              <a href="{{ url('admin/teacher/add') }}" class="btn btn-primary">{{ __('messages.add_new_teacher') }}</a>
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
                <h3 class="card-title">{{ __('messages.search_teacher') }}</h3>
              </div>
              <form method="get" action="">
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label>{{ __('messages.name') }}</label>
                      <input type="text" class="form-control" value="{{ Request::get('name') }}" name="name" placeholder="{{ __('messages.name') }}">
                    </div>

                    <div class="form-group col-md-4">
                      <label>{{ __('messages.last_name') }}</label>
                      <input type="text" class="form-control" value="{{ Request::get('last_name') }}" name="last_name" placeholder="{{ __('messages.last_name') }}">
                    </div>

                    <div class="form-group col-md-3">
                      <button class="btn btn-primary" type="submit" style="margin-top: 30px;">{{ __('messages.search') }}</button>
                      <a href="{{ url('admin/teacher/list') }}" class="btn btn-success" style="margin-top: 30px;">{{ __('messages.reset') }}</a>
                    </div>
                  </div>
                </div>
              </form>
            </div>

            @include('_message')

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{ __('messages.teacher_list') }}</h3>
                <form action="{{ url('admin/teacher/export_excel') }}" method="post" style="float: right;">
                    {{ csrf_field() }}
                    <input type="hidden" name="name" value="{{ Request::get('name') }}">
                    <input type="hidden" name="last_name" value="{{ Request::get('last_name') }}">
                    <input type="hidden" name="email" value="{{ Request::get('email') }}">
                    <input type="hidden" name="gender" value="{{ Request::get('gender') }}">
                    <input type="hidden" name="mobile_number" value="{{ Request::get('mobile_number') }}">
                    <input type="hidden" name="marital_status" value="{{ Request::get('marital_status') }}">
                    <input type="hidden" name="address" value="{{ Request::get('address') }}">
                    <input type="hidden" name="status" value="{{ Request::get('status') }}">
                    <input type="hidden" name="admission_date" value="{{ Request::get('admission_date') }}">
                    <input type="hidden" name="date" value="{{ Request::get('date') }}">
                    <button class="btn btn-primary">{{ __('messages.export_excel') }}</button>
                </form>
              </div>

              <div class="card-body p-0" style="overflow: auto;">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>{{ __('messages.profile_pic') }}</th>
                      <th>{{ __('messages.teacher_name') }}</th>
                      <th>{{ __('messages.email') }}</th>
                      <th>{{ __('messages.gender') }}</th>
                      <th>{{ __('messages.date_of_birth') }}</th>
                      <th>{{ __('messages.date_of_joining') }}</th>
                      <th>{{ __('messages.mobile_number') }}</th>
                      <th>{{ __('messages.marital_status') }}</th>
                      <th>{{ __('messages.current_address') }}</th>
                      <th>{{ __('messages.permanent_address') }}</th>
                      <th>{{ __('messages.qualification') }}</th>
                      <th>{{ __('messages.work_experience') }}</th>
                      <th>{{ __('messages.note') }}</th>
                      <th>{{ __('messages.status') }}</th>
                      <th>{{ __('messages.created_date') }}</th>
                      <th>{{ __('messages.action') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($getRecord as $value)
                      <tr>
                        <td>{{ $value->id }}</td>
                        <td>
                          @if(!empty($value->getProfileDirect()))
                            <img src="{{ $value->getProfileDirect() }}" style="height: 50px; width:50px; border-radius: 50px;">
                          @endif
                        </td>
                        <td>{{ $value->name }} {{ $value->last_name }}</td>
                        <td>{{ $value->email }}</td>
                        <td>{{ $value->gender }}</td>
                        <td>
                          @if(!empty($value->date_of_birth))
                            {{ date('d-m-Y', strtotime($value->date_of_birth)) }}
                          @endif
                        </td>
                        <td>
                          @if(!empty($value->admission_date))
                            {{ date('d-m-Y', strtotime($value->admission_date)) }}
                          @endif
                        </td>
                        <td>{{ $value->mobile_number }}</td>
                        <td>{{ $value->marital_status }}</td>
                        <td>{{ $value->address }}</td>
                        <td>{{ $value->permanent_address }}</td>
                        <td>{{ $value->qualification }}</td>
                        <td>{{ $value->work_experience }}</td>
                        <td>{{ $value->note }}</td>
                        <td>{{ ($value->status == 0) ? __('messages.active') : __('messages.inactive') }}</td>
                        <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                        <td style="min-width: 270px;">
                          <a href="{{ url('admin/teacher/edit/'.$value->id) }}" class="btn btn-primary btn-sm">{{ __('messages.edit') }}</a>
                          <a href="{{ url('admin/teacher/delete/'.$value->id) }}" class="btn btn-danger btn-sm">{{ __('messages.delete') }}</a>
                          <a href="{{ url('chat?receiver_id='.base64_encode($value->id)) }}" class="btn btn-success btn-sm">{{ __('messages.send_message') }}</a>

                          <form action="{{ url('admin/teacher/toggle-supervisor/'.$value->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn {{ $value->is_supervisor ? 'btn-danger' : 'btn-success' }}">
                                {{ $value->is_supervisor ? __('messages.remove_supervisor') : __('messages.make_supervisor') }}
                            </button>
                        </form>

                        </td>
                      </tr>
                    @endforeach
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