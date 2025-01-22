@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>تقييمات المعلم: {{ $subject->teacher->name }} - {{ $subject->subject->name }}</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>تاريخ التقييم</th>
                                            <th>الملاحظات</th>
                                            <th>تم التقييم بواسطة</th>
                                            <th>تاريخ الإنشاء</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($evaluations as $evaluation)
                                        <tr>
                                            <td>{{ $evaluation->evaluation_date }}</td>
                                            <td>{{ $evaluation->notes }}</td>
                                            <td>{{ $evaluation->creator->name }}</td>
                                            <td>{{ $evaluation->created_at }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection