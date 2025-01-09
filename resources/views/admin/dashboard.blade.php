@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0">{{ __('messages.dashboard') }}</h1>
          </div>
        </div>
      </div>
    </div>
    
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3>${{ number_format($getTotalFees, 2) }}</h3>
                <p>{{ __('messages.all_time_received_payment') }}</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="{{ url('admin/fees_collection/collect_fees_report') }}" class="small-box-footer">{{ __('messages.more_info') }} <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
   
          <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ $TotalStudent }}</h3>
                <p>{{ __('messages.total_student') }}</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{ url('admin/student/list') }}" class="small-box-footer">{{ __('messages.more_info') }} <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

           <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ $TotalTeacher }}</h3>
                <p>{{ __('messages.total_teacher') }}</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{ url('admin/teacher/list') }}" class="small-box-footer">{{ __('messages.more_info') }} <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
              <div class="inner">
                <h3>{{ $TotalParent }}</h3>
                <p>{{ __('messages.total_parent') }}</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{ url('admin/parent/list') }}" class="small-box-footer">{{ __('messages.more_info') }} <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ $TotalAdmin }}</h3>
                <p>{{ __('messages.total_admin') }}</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{ url('admin/admin/list') }}" class="small-box-footer">{{ __('messages.more_info') }} <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

@endsection