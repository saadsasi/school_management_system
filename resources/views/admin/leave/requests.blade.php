@extends('layouts.app')
@section('content')

<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>طلبات المغادرة</h1>
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
                        <!-- Card Header -->
                        <div class="card-header">
                            <h3 class="card-title">قائمة طلبات المغادرة</h3>
                            <div class="card-tools">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default" onclick="filterLeaves('all')">الكل</button>
                                    <button type="button" class="btn btn-info" onclick="filterLeaves('{{ \App\Http\Controllers\LeaveController::LEAVE_TYPE_EARLY }}')">
                                        مغادرة مبكرة
                                    </button>
                                    <button type="button" class="btn btn-warning" onclick="filterLeaves('{{ \App\Http\Controllers\LeaveController::LEAVE_TYPE_END_DAY }}')">
                                        نهاية الدوام
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Card Body -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>اسم الطالب</th>
                                        <th>نوع المغادرة</th>
                                        <th>التاريخ</th>
                                        <th>الوقت</th>
                                        <th>السبب</th>
                                        <th>الحالة</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($getRecord as $value)
                                        <tr class="leave-row {{ str_replace('_leave', '', $value->type) }}">
                                        <td>{{ $loop->iteration }}</td>
                                            <td>{{ $value->student->name }}</td>
                                            <td>
                                                @if($value->type == \App\Http\Controllers\LeaveController::LEAVE_TYPE_EARLY)
                                                    <span class="badge badge-info">مغادرة مبكرة</span>
                                                @elseif($value->type == \App\Http\Controllers\LeaveController::LEAVE_TYPE_END_DAY)
                                                    <span class="badge badge-warning">نهاية الدوام</span>
                                                @endif
                                            </td>
                                            <td>{{ date('Y-m-d', strtotime($value->date)) }}</td>
                                            <td>{{ $value->time }}</td>
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
                                            <td>
                                                @if($value->status == 0)
                                                    <a href="{{ url('admin/leave/approve/'.$value->id) }}" class="btn btn-success btn-sm">
                                                        <i class="fas fa-check"></i> موافقة
                                                    </a>
                                                    <a href="{{ url('admin/leave/reject/'.$value->id) }}" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-times"></i> رفض
                                                    </a>
                                                @endif
                                                <a href="{{ url('admin/leave/delete/'.$value->id) }}" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i> حذف
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">لا توجد طلبات مغادرة</td>
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

@push('scripts')
<script>
    function filterLeaves(type) {
        if (type === 'all') {
            $('.leave-row').show();
        } else {
            $('.leave-row').hide();
            $('.leave-row.' + type).show();
        }
        
        // تحديث حالة الأزرار
        $('.btn-group .btn').removeClass('active');
        $(event.target).addClass('active');
    }
</script>
@endpush

@endsection