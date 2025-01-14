@extends('layouts.app')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $header_title }}</h1>
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
                            <h3 class="card-title">{{ __('messages.leave_history') }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('messages.type') }}</th>
                                        <th>{{ __('messages.date') }}</th>
                                        <th>{{ __('messages.time') }}</th>
                                        <th>{{ __('messages.reason') }}</th>
                                        <th>{{ __('messages.status') }}</th>
                                        <th>{{ __('messages.created_date') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($getRecord))
                                        @foreach($getRecord as $value)
                                            <tr>
                                                <td>{{ $value->id }}</td>
                                                <td>
                                                    @if($value->type == 'early_leave')
                                                        {{ __('messages.early_leave') }}
                                                    @elseif($value->type == 'end_day_leave')
                                                        {{ __('messages.end_day_leave') }}
                                                    @elseif($value->type == 'full_day_leave')
                                                        {{ __('messages.full_day_leave') }}
                                                    @endif
                                                </td>
                                                <td>{{ date('d-m-Y', strtotime($value->date)) }}</td>
                                                <td>{{ !empty($value->time) ? date('h:i A', strtotime($value->time)) : '' }}</td>
                                                <td>{{ $value->reason }}</td>
                                                <td>
                                                    @if($value->status == 0)
                                                        <span class="badge badge-warning">{{ __('messages.pending') }}</span>
                                                    @elseif($value->status == 1)
                                                        <span class="badge badge-success">{{ __('messages.approved') }}</span>
                                                    @elseif($value->status == 2)
                                                        <span class="badge badge-danger">{{ __('messages.rejected') }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection