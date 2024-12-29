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
                            <h3 class="card-title">سجل طلبات المغادرة</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>التاريخ</th>
                                        <th>الوقت</th>
                                        <th>النوع</th>
                                        <th>السبب</th>
                                        <th>الحالة</th>
                                        <th>تاريخ الطلب</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($getRecord as $value)
                                        <tr>
                                            <td>{{ date('d/m/Y', strtotime($value->date)) }}</td>
                                            <td>{{ date('h:i A', strtotime($value->time)) }}</td>
                                            <td>
    @if($value->type == \App\Http\Controllers\LeaveController::LEAVE_TYPE_EARLY)
        <span class="badge badge-info">مغادرة مبكرة</span>
    @elseif($value->type == \App\Http\Controllers\LeaveController::LEAVE_TYPE_END_DAY)
        <span class="badge badge-warning">نهاية الدوام</span>
    @endif
</td>
                                            <td>{{ $value->reason }}</td>
                                            <td>
                                                @if($value->status == 0)
                                                    <span class="badge badge-warning">قيد الانتظار</span>
                                                @elseif($value->status == 1)
                                                    <span class="badge badge-success">تمت الموافقة</span>
                                                @else
                                                    <span class="badge badge-danger">مرفوض</span>
                                                @endif
                                            </td>
                                            <td>{{ date('d/m/Y h:i A', strtotime($value->created_at)) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">لا توجد طلبات مغادرة</td>
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