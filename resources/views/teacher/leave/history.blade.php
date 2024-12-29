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
                            <h3 class="card-title">سجل طلبات المغادرة</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>النوع</th>
                                        <th>التاريخ</th>
                                        <th>الوقت</th>
                                        <th>السبب</th>
                                        <th>الحالة</th>
                                        <th>تاريخ الإنشاء</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($getRecord))
                                        @foreach($getRecord as $value)
                                            <tr>
                                                <td>{{ $value->id }}</td>
                                                <td>
                                                    @if($value->type == 'early_leave')
                                                        مغادرة مبكرة
                                                    @elseif($value->type == 'end_day_leave')
                                                        نهاية الدوام
                                                    @elseif($value->type == 'full_day_leave')
                                                        يوم كامل
                                                    @endif
                                                </td>
                                                <td>{{ date('d-m-Y', strtotime($value->date)) }}</td>
                                                <td>{{ !empty($value->time) ? date('h:i A', strtotime($value->time)) : '' }}</td>
                                                <td>{{ $value->reason }}</td>
                                                <td>
                                                    @if($value->status == 0)
                                                        <span class="badge badge-warning">قيد الانتظار</span>
                                                    @elseif($value->status == 1)
                                                        <span class="badge badge-success">تمت الموافقة</span>
                                                    @elseif($value->status == 2)
                                                        <span class="badge badge-danger">مرفوض</span>
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