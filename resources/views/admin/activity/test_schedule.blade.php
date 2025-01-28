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
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">جداول النشاط</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>النشاط</th>
                                        <th>اليوم</th>
                                        <th>وقت البداية</th>
                                        <th>وقت النهاية</th>
                                        <th>المكان</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($schedules as $schedule)
                                    <tr>
                                        <td>{{ $schedule->activity->name }}</td>
                                        <td>{{ $schedule->week_name }}</td>
                                        <td>{{ date('h:i A', strtotime($schedule->start_time)) }}</td>
                                        <td>{{ date('h:i A', strtotime($schedule->end_time)) }}</td>
                                        <td>{{ $schedule->location }}</td>
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