@extends('layouts.app')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('messages.leave_requests') }}</h1>
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
                            <h3 class="card-title">{{ __('messages.leave_requests_list') }}</h3>
                            <div class="card-tools">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default active" onclick="filterLeaves('all', this)">{{ __('messages.all') }}</button>
                                    <button type="button" class="btn btn-info" onclick="filterLeaves('early', this)">
                                        {{ __('messages.early_leave') }}
                                    </button>
                                    <button type="button" class="btn btn-warning" onclick="filterLeaves('end_day', this)">
                                        {{ __('messages.end_day') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-right">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('messages.student_name') }}</th>
                                        <th>{{ __('messages.leave_type') }}</th>
                                        <th>{{ __('messages.date') }}</th>
                                        <th>{{ __('messages.time') }}</th>
                                        <th>{{ __('messages.reason') }}</th>
                                        <th>{{ __('messages.status') }}</th>
                                        <th>{{ __('messages.created_date') }}</th>
                                        <th>{{ __('messages.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($getRecord as $value)
                                    <tr class="leave-row {{ $value->type }}">                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ optional($value->user)->name }}</td>
                                            <td>
                                                @if($value->type == 'early_leave')
                                                    <span class="badge badge-info">{{ __('messages.early_leave') }}</span>
                                                @elseif($value->type == 'end_day_leave')
                                                    <span class="badge badge-warning">{{ __('messages.end_day') }}</span>
                                                @endif
                                            </td>
                                            <td>{{ date('Y-m-d', strtotime($value->date)) }}</td>
                                            <td>{{ date('h:i A', strtotime($value->time)) }}</td>
                                            <td>{{ Str::limit($value->reason, 30) }}</td>
                                            <td>
                                                @if($value->status == 0)
                                                    <span class="badge badge-warning">{{ __('messages.pending') }}</span>
                                                @elseif($value->status == 1)
                                                    <span class="badge badge-success">{{ __('messages.approved') }}</span>
                                                @else
                                                    <span class="badge badge-danger">{{ __('messages.rejected') }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $value->created_at->format('Y-m-d') }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    @if($value->status == 0)
                                                        <a href="{{ url('admin/leave/approve/'.$value->id) }}" 
                                                           class="btn btn-success btn-sm" 
                                                           data-toggle="tooltip" 
                                                           title="{{ __('messages.approve') }}">
                                                            <i class="fas fa-check"></i>
                                                        </a>
                                                        <a href="{{ url('admin/leave/reject/'.$value->id) }}" 
                                                           class="btn btn-warning btn-sm"
                                                           data-toggle="tooltip" 
                                                           title="{{ __('messages.reject') }}">
                                                            <i class="fas fa-times"></i>
                                                        </a>
                                                    @endif
                                                    <a href="{{ url('admin/leave/delete/'.$value->id) }}" 
                                                       class="btn btn-danger btn-sm" 
                                                       onclick="return confirm('{{ __('messages.delete_confirm') }}')"
                                                       data-toggle="tooltip" 
                                                       title="{{ __('messages.delete') }}">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">{{ __('messages.no_leave_requests_found') }}</td>
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
$(document).ready(function() {
    // تفعيل tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    // تحديث الوقت بتنسيق 12 ساعة
    $('.time-format').each(function() {
        let time = $(this).text();
        let formattedTime = moment(time, 'HH:mm').format('hh:mm A');
        $(this).text(formattedTime);
    });
});

function filterLeaves(type, button) {
    // إزالة الفلتر السابق
    $('.leave-row').hide();
    
     
    // تطبيق الفلتر الجديد
    if (type === 'all') {
        $('.leave-row').show();
    } else {
        $('.leave-row.' + type).show();
    }
    
    // تحديث حالة الأزرار
    $('.btn-group .btn').removeClass('active');
    $(button).addClass('active');
}
</script>
@endpush