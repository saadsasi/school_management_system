@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('messages.my_activities') }}</h1>
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
                            <h3 class="card-title">{{ __('messages.registered_activities') }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @if(count($activities) > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>{{ __('messages.activity_name') }}</th>
                                                <th>{{ __('messages.description') }}</th>
                                                <th>{{ __('messages.start_date') }}</th>
                                                <th>{{ __('messages.end_date') }}</th>
                                                <th>{{ __('messages.status') }}</th>
                                                <th>{{ __('messages.registration_date') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($activities as $activity)
                                                <tr>
                                                    <td>{{ $activity->activity->name }}</td>
                                                    <td>{{ $activity->activity->description }}</td>
                                                    <td>{{ date('Y-m-d', strtotime($activity->activity->start_date)) }}</td>
                                                    <td>{{ date('Y-m-d', strtotime($activity->activity->end_date)) }}</td>
                                                    <td>
                                                        @if($activity->status == 'pending')
                                                            <span class="badge badge-warning">{{ __('messages.pending') }}</span>
                                                        @elseif($activity->status == 'approved')
                                                            <span class="badge badge-success">{{ __('messages.approved') }}</span>
                                                        @elseif($activity->status == 'rejected')
                                                            <span class="badge badge-danger">{{ __('messages.rejected') }}</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ date('Y-m-d', strtotime($activity->created_at)) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    {{ __('messages.no_activities_found') }}
                                </div>
                            @endif
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
</div>
@endsection