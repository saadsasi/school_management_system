@extends('layouts.app')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> {{__('messages.new_registrations')}} </h1>
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
                            <h3 class="card-title"> {{__('messages.registration_list')}} </h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th> {{__('messages.name')}} </th>
                                        <th> {{__('messages.email')}} </th>
                                        <th> {{__('messages.user_type')}} </th>
                                        <th> {{__('messages.mobile')}} </th>
                                        <th> {{__('messages.registered_date')}} </th>
                                        <th> {{__('messages.action')}} </th>
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
                                                    {{__('messages.teacher')}}
                                                @elseif($user->user_type == 3)
                                                    {{__('messages.student')}}
                                                @elseif($user->user_type == 4)
                                                    {{__('messages.parent')}}
                                                @endif
                                            </td>
                                            <td>{{ $user->mobile_number }}</td>
                                            <td>{{ date('d-m-Y', strtotime($user->created_at)) }}</td>
                                            <td>
                                                <a href="{{ url('admin/registration/approve/'.$user->id) }}" class="btn btn-success btn-sm"> {{__('messages.approve')}} </a>
                                                <a href="{{ url('admin/registration/reject/'.$user->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('{{__('messages.are_you_sure_to_reject')}}')"> {{__('messages.reject')}} </a>
                                                
                                                @if($user->user_type == 3)
                                                    <!-- معلومات إضافية للطلاب -->
                                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#studentInfo{{ $user->id }}">
                                                        {{__('messages.details')}} 
                                                    </button>
                                                    
                                                    <!-- نافذة معلومات الطالب -->
                                                    <div class="modal fade" id="studentInfo{{ $user->id }}">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title"> {{__('messages.student_details')}} </h4>
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p><strong> {{__('messages.admission_number')}}:</strong> {{ $user->admission_number }}</p>
                                                                    <p><strong> {{__('messages.grade_level')}}:</strong> {{ $user->grade_level }}</p>
                                                                    <p><strong> {{__('messages.roll_number')}}:</strong> {{ $user->roll_number }}</p>
                                                                    <p><strong> {{__('messages.date_of_birth')}}:</strong> {{ $user->date_of_birth }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif($user->user_type == 2)
                                                    <!-- معلومات إضافية للمعلمين -->
                                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#teacherInfo{{ $user->id }}">
                                                        {{__('messages.details')}} 
                                                    </button>
                                                    
                                                    <!-- نافذة معلومات المعلم -->
                                                    <div class="modal fade" id="teacherInfo{{ $user->id }}">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title"> {{__('messages.teacher_details')}} </h4>
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p><strong> {{__('messages.qualification')}}:</strong> {{ $user->qualification }}</p>
                                                                    <p><strong> {{__('messages.work_experience')}}:</strong> {{ $user->work_experience }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif($user->user_type == 4)
                                                    <!-- معلومات إضافية لولي الامر -->
                                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#parentInfo{{ $user->id }}">
                                                        {{__('messages.details')}} 
                                                    </button>
                                                    
                                                    <!-- نافذة معلومات ولي الامر -->
                                                    <div class="modal fade" id="parentInfo{{ $user->id }}">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title"> {{__('messages.parent_details')}} </h4>
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p><strong> {{__('messages.name')}}:</strong> {{ $user->name }}</p>
                                                                    <p><strong> {{__('messages.mobile_number')}}:</strong> {{ $user->mobile_number}}</p>
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
                                            <td colspan="7" class="text-center">{{__('messages.no_registrations_found')}}</td>
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