@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ __('messages.parent_my_student') }}</h1>
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
                <h3 class="card-title">{{ __('messages.parent_my_student') }}</h3>
              </div>
              <div class="card-body p-0" style="overflow: auto;">
                 <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>{{ __('messages.parent_profile_pic') }}</th>
                      <th>{{ __('messages.parent_student_name') }}</th>
                      <th>{{ __('messages.parent_email') }}</th>
                      <th>{{ __('messages.parent_class') }}</th>
                      <th>{{ __('messages.parent_admission_date') }}</th>
                      <th>{{ __('messages.parent_created_date') }}</th>
                      <th>{{ __('messages.parent_action') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                     @foreach($getRecord as $value)
                        <tr>
                          <td>
                            @if(!empty($value->getProfile()))
                            <img src="{{ $value->getProfile() }}" style="height: 50px; width:50px; border-radius: 50px;">
                            @endif
                          </td>
                          <td>{{ $value->name }} {{ $value->last_name }}</td>
                          <td>{{ $value->email }}</td>
                          <td>{{ $value->class_name }}</td>
                          <td>
                            @if(!empty($value->admission_date))
                              {{ date('d-m-Y', strtotime($value->admission_date)) }}
                            @endif
                          </td>
                          <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                          <td class="p-3" style="width: 1%; white-space: nowrap;">
                            <div class="d-flex flex-column gap-3">
                              <div class="d-flex justify-content-end gap-3">
                                <a class="btn btn-success btn-sm px-1 mx-1" href="{{ url('parent/my_student/subject/'.$value->id) }}">
                                  <i class="fas fa-book me-1"></i> {{ __('messages.subjects') }}
                                </a>
                                <a class="btn btn-info btn-sm px-1 mx-1" href="{{ url('parent/my_student/my_exam_result/'.$value->id) }}">
                                  <i class="fas fa-graduation-cap me-1"></i> {{ __('messages.my_exam_result') }}
                                </a>
                                <a class="btn btn-warning btn-sm px-1 mx-1" href="{{ url('parent/my_student/my_exam_timetable/'.$value->id) }}">
                                  <i class="fas fa-clock me-1"></i> {{ __('messages.my_exam_timetable') }}
                                </a>
                                <a class="btn btn-primary btn-sm px-1 mx-1" href="{{ url('parent/my_student/attendance/'.$value->id) }}">
                                  <i class="fas fa-user-check me-1"></i> {{ __('messages.attendance') }}
                                </a>
                              </div>
                              <div class="d-flex justify-content-end gap-3 mt-3">
                                <a class="btn btn-warning btn-sm px-1 mx-1" href="{{ url('parent/my_student/calendar/'.$value->id) }}">
                                  <i class="fas fa-calendar me-1"></i> {{ __('messages.calendar') }}
                                </a>
                                <a class="btn btn-success btn-sm px-1 mx-1" href="{{ url('parent/my_student/fees_collection/'.$value->id) }}">
                                  <i class="fas fa-money-bill me-1"></i> {{ __('messages.fees_collection') }}
                                </a>
                                <a class="btn btn-info btn-sm px-1 mx-1" href="{{ url('chat?receiver_id='.base64_encode($value->id)) }}">
                                  <i class="fas fa-comments me-1"></i> {{ __('messages.send_message') }}
                                </a>
                              </div>
                            </div>
                          </td>
                        </tr>
                      @endforeach
                  </tbody>
                </table>
                <div style="padding: 10px; float: right;"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
</div>
@endsection
