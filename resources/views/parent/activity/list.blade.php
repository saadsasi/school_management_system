@extends('layouts.app')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('messages.activities') }}</h1>
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
                            <h3 class="card-title">{{__('messages.activity_list')}}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($activities as $activity)
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $activity->name }}</h5>
                                            <p class="card-text">{{ $activity->description }}</p>
                                            <ul class="list-unstyled">
                                                <li><strong>{{ __('messages.start_date') }}:</strong> {{ $activity->start_date }}</li>
                                                <li><strong>{{ __('messages.end_date') }}:</strong> {{ $activity->end_date }}</li>
                                                <li><strong>{{ __('messages.cost') }}:</strong> {{ $activity->cost }} د.ل</li>
                                                <li><strong>{{ __('messages.max_students') }}:</strong> {{ $activity->max_students }}</li>
                                            </ul>
                                            <a href="{{ url('parent/activity/register/'.$activity->id) }}" class="btn btn-primary">{{ __('messages.register') }}</a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection