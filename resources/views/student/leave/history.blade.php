@extends('layouts.app')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $header_title }}</h1>
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
                            <h3 class="card-title">{{ __('messages.leave_history') }}</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.date') }}</th>
                                        <th>{{ __('messages.time') }}</th>
                                        <th>{{ __('messages.type') }}</th>
                                        <th>{{ __('messages.reason') }}</th>
                                        <th>{{ __('messages.status') }}</th>
                                        <th>{{ __('messages.request_date') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($getRecord as $value)
                                        <tr>
                                            <td>{{ date('d/m/Y', strtotime($value->date)) }}</td>
                                            <td>{{ date('h:i A', strtotime($value->time)) }}</td>
                                            <td>
    @if($value->type == \App\Http\Controllers\LeaveController::LEAVE_TYPE_EARLY)
        <span class="badge badge-info">{{ __('messages.early_leave') }}</span>
    @elseif($value->type == \App\Http\Controllers\LeaveController::LEAVE_TYPE_END_DAY)
        <span class="badge badge-warning">{{ __('messages.end_day') }}</span>
    @endif
</td>
                                            <td>{{ $value->reason }}</td>
                                            <td>
                                                @if($value->status == 0)
                                                    <span class="badge badge-warning">{{ __('messages.pending') }}</span>
                                                @elseif($value->status == 1)
                                                    <span class="badge badge-success">{{ __('messages.approved') }}</span>
                                                @else
                                                    <span class="badge badge-danger">{{ __('messages.rejected') }}</span>
                                                @endif
                                            </td>
                                            <td>{{ date('d/m/Y h:i A', strtotime($value->created_at)) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">{{ __('messages.no_record_found') }}</td>
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

@endsection