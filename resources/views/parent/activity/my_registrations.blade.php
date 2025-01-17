@extends('layouts.app')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>تسجيلاتي في الأنشطة</h1>
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
                            <h3 class="card-title">قائمة التسجيلات</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>النشاط</th>
                                        <th>الطالب</th>
                                        <th>تاريخ التسجيل</th>
                                        <th>الحالة</th>
                                        <th>ملاحظات</th>
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
                                                <span class="badge badge-warning">قيد المراجعة</span>
                                            @elseif($registration->status == 'approved')
                                                <span class="badge badge-success">تم القبول</span>
                                            @else
                                                <span class="badge badge-danger">تم الرفض</span>
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