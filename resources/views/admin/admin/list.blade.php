@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ __('messages.admin_list') }} (total : {{ $getRecord->total() }})</h1>
          </div>
          <div class="col-sm-6" style="text-align: right;">
              <a href="{{ url('admin/admin/add') }}" class="btn btn-primary">{{ __('messages.add_new_admin') }}</a>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{ __('messages.search_admin') }}</h3>
              </div>
              <form method="get" action="">
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label>{{ __('messages.name') }}</label>
                      <input type="text" class="form-control" value="{{ Request::get('name') }}" name="name" placeholder="{{ __('messages.name') }}">
                    </div>
                   <div class="form-group col-md-6">
                      <button class="btn btn-primary" type="submit" style="margin-top: 30px;">{{ __('messages.search') }}</button>
                      <a href="{{ url('admin/admin/list') }}" class="btn btn-success" style="margin-top: 30px;">{{ __('messages.reset') }}</a>
                    </div>
                  </div>
                </div>
              </form>
            </div>

            <!-- Admin List Table -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{ __('messages.admin_list') }}</h3>
              </div>
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>{{ __('messages.profile_pic') }}</th>
                      <th>{{ __('messages.name') }}</th>
                      <th>{{ __('messages.email') }}</th>
                      <th>{{ __('messages.created_date') }}</th>
                      <th>{{ __('messages.action') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($getRecord as $value)
                      <tr>
                        <td>{{ $value->id }}</td>
                        <td>
                          @if(!empty($value->getProfile()))
                            <img src="{{ $value->getProfile() }}" style="height: 50px; width: 50px; border-radius: 50px;">
                          @endif
                        </td>
                        <td>{{ $value->name }}</td>
                        <td>{{ $value->email }}</td>
                        <td>{{ date('d-m-Y h:i A', strtotime($value->created_at)) }}</td>
                        <td>
                          <a href="{{ url('admin/admin/edit/'.$value->id) }}" class="btn btn-primary">{{ __('messages.edit') }}</a>
                          <a href="{{ url('admin/admin/delete/'.$value->id) }}" class="btn btn-danger">{{ __('messages.delete') }}</a>
                          <a href="{{ url('admin/admin/chat/'.$value->id) }}" class="btn btn-success">{{ __('messages.send_message') }}</a>
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