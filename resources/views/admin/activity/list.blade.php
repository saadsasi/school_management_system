@extends('layouts.app')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="text-dark">الأنشطة المدرسية</h1>
                </div>
                <div class="col-sm-6 text-left">
                    <a href="{{ url('admin/activity/add') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> إضافة نشاط جديد
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            @include('_message')
            
            <!-- Small Box Stats -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $activities->count() }}</h3>
                            <p>إجمالي الأنشطة</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-running"></i>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $activities->where('status', 'active')->count() }}</h3>
                            <p>الأنشطة النشطة</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activities Grid -->
            <div class="row">
                @foreach($activities as $activity)
                <div class="col-md-4">
                    <div class="card card-outline card-primary h-100">
                        <div class="card-header">
                            <h3 class="card-title">{{ $activity->name }}</h3>
                            <div class="card-tools">
                                @if($activity->status == 'active')
                                    <span class="badge badge-success">نشط</span>
                                @else
                                    <span class="badge badge-danger">غير نشط</span>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="activity-details">
                                <p class="text-muted mb-2">
                                    <i class="far fa-calendar-alt ml-2"></i>
                                    من {{ date('Y/m/d', strtotime($activity->start_date)) }}
                                    إلى {{ date('Y/m/d', strtotime($activity->end_date)) }}
                                </p>
                                <p class="text-muted mb-2">
                                    <i class="fas fa-users ml-2"></i>
                                    العدد الأقصى: {{ $activity->max_students }} طالب
                                </p>
                                <p class="text-muted mb-2">
                                    <i class="fas fa-money-bill-wave ml-2"></i>
                                    التكلفة: {{ $activity->cost }} د.ل
                                </p>
                                @if($activity->description)
                                <p class="text-muted mb-0">
                                    <i class="fas fa-info-circle ml-2"></i>
                                    {{ Str::limit($activity->description, 100) }}
                                </p>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top">
                            <div class="row">
                                <div class="col">
                                    <a href="{{ url('admin/activity/edit/'.$activity->id) }}" class="btn btn-primary btn-sm btn-block">
                                        <i class="fas fa-edit"></i> تعديل
                                    </a>
                                </div>
                                <div class="col">
                                    <a href="{{ url('admin/activity/delete/'.$activity->id) }}" 
                                       class="btn btn-danger btn-sm btn-block" 
                                       onclick="return confirm('هل أنت متأكد من حذف هذا النشاط؟')">
                                        <i class="fas fa-trash"></i> حذف
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if($activities->isEmpty())
            <div class="text-center mt-4">
                <img src="{{ url('dist/img/no-data.svg') }}" style="width: 150px; opacity: 0.5;">
                <p class="text-muted mt-3">لا توجد أنشطة مضافة حتى الآن</p>
            </div>
            @endif
        </div>
    </section>
</div>

@push('styles')
<style>
    .activity-details p {
        margin-bottom: 0.5rem;
    }
    .activity-details i {
        width: 20px;
        text-align: center;
    }
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .small-box {
        border-radius: 0.5rem;
    }
</style>
@endpush

@endsection