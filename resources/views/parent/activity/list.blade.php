@extends('layouts.app')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>الأنشطة المتاحة</h1>
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
                            <h3 class="card-title">قائمة الأنشطة المتاحة للتسجيل</h3>
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
                                                <li><strong>تاريخ البداية:</strong> {{ $activity->start_date }}</li>
                                                <li><strong>تاريخ النهاية:</strong> {{ $activity->end_date }}</li>
                                                <li><strong>التكلفة:</strong> {{ $activity->cost }} د.ل</li>
                                                <li><strong>العدد المتاح:</strong> {{ $activity->max_students }}</li>
                                            </ul>
                                            <a href="{{ url('parent/activity/register/'.$activity->id) }}" class="btn btn-primary">تسجيل</a>
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