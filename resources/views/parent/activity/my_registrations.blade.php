@extends('layouts.app')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('messages.my_registrations') }}</h1>
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
                            <h3 class="card-title">{{ __('messages.my_registrations') }}</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.activity') }}</th>
                                        <th>{{ __('messages.student') }}</th>
                                        <th>{{ __('messages.registration_date') }}</th>
                                        <th>{{ __('messages.status') }}</th>
                                        <th>{{ __('messages.notes') }}</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($registrations as $registration)
                                    <tr>
                                        <td>{{ $registration->activity->name }}</td>
                                        <td>{{ $registration->student->name }}</td>
                                        <td>{{ $registration->created_at }}</td>
                                        <td>
                                            @if($registration->status == 'pending')
                                                <span class="badge badge-warning">{{ __('messages.pending') }}</span>
                                            @elseif($registration->status == 'approved')
                                                <span class="badge badge-success">{{ __('messages.approved') }}</span>

                                            @else
                                                <span class="badge badge-danger">{{ __('messages.rejected') }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $registration->notes }}</td>
                                    </tr>
                                    @endforeach
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