@extends('layouts.app')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>طلبات التسجيل الجديدة</h1>
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
                            <h3 class="card-title">قائمة طلبات التسجيل</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>الاسم</th>
                                        <th>البريد الإلكتروني</th>
                                        <th>نوع المستخدم</th>
                                        <th>رقم الجوال</th>
                                        <th>تاريخ التسجيل</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($registrations as $key => $user)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $user->name }} {{ $user->last_name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if($user->user_type == 2)
                                                    معلم
                                                @elseif($user->user_type == 3)
                                                    طالب
                                                @elseif($user->user_type == 4)
                                                    ولي أمر
                                                @endif
                                            </td>
                                            <td>{{ $user->mobile_number }}</td>
                                            <td>{{ date('d-m-Y', strtotime($user->created_at)) }}</td>
                                            <td>
                                                <a href="{{ url('admin/registration/approve/'.$user->id) }}" class="btn btn-success btn-sm">قبول</a>
                                                <a href="{{ url('admin/registration/reject/'.$user->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من رفض هذا التسجيل؟')">رفض</a>
                                                
                                                @if($user->user_type == 3)
                                                    <!-- معلومات إضافية للطلاب -->
                                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#studentInfo{{ $user->id }}">
                                                        عرض التفاصيل
                                                    </button>
                                                    
                                                    <!-- نافذة معلومات الطالب -->
                                                    <div class="modal fade" id="studentInfo{{ $user->id }}">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">تفاصيل الطالب</h4>
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p><strong>رقم القبول:</strong> {{ $user->admission_number }}</p>
                                                                    <p><strong>الصف:</strong> {{ $user->class_id }}</p>
                                                                    <p><strong>رقم التسجيل:</strong> {{ $user->roll_number }}</p>
                                                                    <p><strong>تاريخ الميلاد:</strong> {{ $user->date_of_birth }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif($user->user_type == 2)
                                                    <!-- معلومات إضافية للمعلمين -->
                                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#teacherInfo{{ $user->id }}">
                                                        عرض التفاصيل
                                                    </button>
                                                    
                                                    <!-- نافذة معلومات المعلم -->
                                                    <div class="modal fade" id="teacherInfo{{ $user->id }}">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">تفاصيل المعلم</h4>
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p><strong>المؤهل:</strong> {{ $user->qualification }}</p>
                                                                    <p><strong>الخبرة:</strong> {{ $user->work_experience }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif($user->user_type == 4)
                                                    <!-- معلومات إضافية لولي الامر -->
                                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#parentInfo{{ $user->id }}">
                                                        عرض التفاصيل
                                                    </button>
                                                    
                                                    <!-- نافذة معلومات ولي الامر -->
                                                    <div class="modal fade" id="parentInfo{{ $user->id }}">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">تفاصيل ولي الامر</h4>
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p><strong>الاسم:</strong> {{ $user->name }}</p>
                                                                    <p><strong>الهاتف:</strong> {{ $user->mobile_number}}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                    @if(count($registrations) == 0)
                                        <tr>
                                            <td colspan="7" class="text-center">لا توجد طلبات تسجيل جديدة</td>
                                        </tr>
                                    @endif
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