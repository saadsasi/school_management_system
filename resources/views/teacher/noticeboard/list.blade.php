@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('messages.noticeboard_list') }}</h1>
                </div>
                <div class="col-sm-6" style="text-align: right;">
                    <a href="{{ url('teacher/noticeboard/add') }}" class="btn btn-primary">{{ __('messages.add_new_notice') }}</a>
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
                                    <div class="form-group col-md-3">
                                        <label>{{ __('messages.title') }}</label>
                                        <input type="text" class="form-control" value="{{ Request::get('title') }}" name="title" placeholder="{{ __('messages.title') }}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>{{ __('messages.notice_date_from') }}</label>
                                        <input type="date" class="form-control" name="notice_date_from" value="{{ Request::get('notice_date_from') }}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>{{ __('messages.notice_date_to') }}</label>
                                        <input type="date" class="form-control" name="notice_date_to" value="{{ Request::get('notice_date_to') }}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <button class="btn btn-primary" type="submit" style="margin-top: 30px;">{{ __('messages.search') }}</button>
                                        <a href="{{ url('teacher/noticeboard') }}" class="btn btn-success" style="margin-top: 30px;">{{ __('messages.reset') }}</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    @include('_message')

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('messages.notice_list') }}</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('messages.title') }}</th>
                                        <th>{{ __('messages.notice_date') }}</th>
                                        <th>{{ __('messages.created_date') }}</th>
                                        <th>{{ __('messages.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($getRecord as $value)
                                    <tr>
                                        <td>{{ $value->id }}</td>
                                        <td>{{ $value->title }}</td>
                                        <td>{{ date('d-m-Y', strtotime($value->notice_date)) }}</td>
                                        <td>{{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                                        <td>
                                            <a href="{{ url('teacher/noticeboard/edit/'.$value->id) }}" class="btn btn-primary">{{ __('messages.edit') }}</a>
                                            <a href="{{ url('teacher/noticeboard/delete/'.$value->id) }}" class="btn btn-danger" onclick="return confirm('{{ __('messages.confirm_delete') }}');">{{ __('messages.delete') }}</a>
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