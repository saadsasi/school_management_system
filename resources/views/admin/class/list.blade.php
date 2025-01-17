@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ __('messages.class_list') }}</h1>
          </div>
          <div class="col-sm-6" style="text-align: right;">
              <a href="{{ url('admin/class/add') }}" class="btn btn-primary">{{ __('messages.add_new_class') }}</a>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- /.col -->
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{ __('messages.search_class') }}</h3>
              </div>
              <form method="get" action="">
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label>{{ __('messages.name') }}</label>
                      <input type="text" class="form-control" value="{{ Request::get('name') }}" name="name"  placeholder="{{ __('messages.name') }}">
                    </div>


                    <div class="form-group col-md-4">
                      <label>{{ __('messages.grade_level') }}</label>
                      <select class="form-control" name="grade_level">
                          <option value="">{{ __('messages.select_grade_level') }}</option>
                          <option {{ (Request::get('grade_level') == 'first_primary') ? 'selected' : '' }} value="first_primary">الصف الأول الابتدائي</option>
                          <option {{ (Request::get('grade_level') == 'second_primary') ? 'selected' : '' }} value="second_primary">الصف الثاني الابتدائي</option>
                          <option {{ (Request::get('grade_level') == 'third_primary') ? 'selected' : '' }} value="third_primary">الصف الثالث الابتدائي</option>
                          <option {{ (Request::get('grade_level') == 'fourth_primary') ? 'selected' : '' }} value="fourth_primary">الصف الرابع الابتدائي</option>
                          <option {{ (Request::get('grade_level') == 'fifth_primary') ? 'selected' : '' }} value="fifth_primary">الصف الخامس الابتدائي</option>
                          <option {{ (Request::get('grade_level') == 'sixth_primary') ? 'selected' : '' }} value="sixth_primary">الصف السادس الابتدائي</option>
                          <option {{ (Request::get('grade_level') == 'first_preparatory') ? 'selected' : '' }} value="first_preparatory">الصف الأول الإعدادي</option>
                          <option {{ (Request::get('grade_level') == 'second_preparatory') ? 'selected' : '' }} value="second_preparatory">الصف الثاني الإعدادي</option>
                          <option {{ (Request::get('grade_level') == 'third_preparatory') ? 'selected' : '' }} value="third_preparatory">الصف الثالث الإعدادي</option>
                      </select>
                  </div>
 
                    <div class="form-group col-md-4">
                      <button class="btn btn-primary" type="submit" style="margin-top: 30px;">{{ __('messages.search') }}</button>
                      <a href="{{ url('admin/class/list') }}" class="btn btn-success" style="margin-top: 30px;">{{ __('messages.reset') }}</a>
                    </div>
                  </div>
                </div>
              </form>
            </div>

            @include('_message')
            
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{ __('messages.class_list') }}</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>{{ __('messages.name') }}</th>
                      <th>{{ __('messages.grade_level') }}</th>
                      <th>{{ __('messages.amount') }}</th>
                      <th>{{ __('messages.status') }}</th>
                      <th>{{ __('messages.created_by') }}</th>
                      <th>{{ __('messages.created_date') }}</th>
                      <th>{{ __('messages.action') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($getRecord as $value)
                      <tr>
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->name }}</td>
                        <td>
                          @switch($value->grade_level)
                              @case('first_primary')
                                  الصف الأول الابتدائي
                                  @break
                              @case('second_primary')
                                  الصف الثاني الابتدائي
                                  @break
                              @case('third_primary')
                                  الصف الثالث الابتدائي
                                  @break
                              @case('fourth_primary')
                                  الصف الرابع الابتدائي
                                  @break
                              @case('fifth_primary')
                                  الصف الخامس الابتدائي
                                  @break
                              @case('sixth_primary')
                                  الصف السادس الابتدائي
                                  @break
                              @case('first_preparatory')
                                  الصف الأول الإعدادي
                                  @break
                              @case('second_preparatory')
                                  الصف الثاني الإعدادي
                                  @break
                              @case('third_preparatory')
                                  الصف الثالث الإعدادي
                                  @break
                          @endswitch
                        </td>
                        <td>${{ number_format($value->amount, 2) }}</td>
                        <td>
                          @if($value->status == 0)
                              {{ __('messages.active') }}
                          @else
                              {{ __('messages.inactive') }}
                          @endif
                        </td>
                        <td>{{ $value->created_by_name }}</td>
                        <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                        <td>
                          <a href="{{ url('admin/class/edit/'.$value->id) }}" class="btn btn-primary">{{ __('messages.edit') }}</a>
                          <a href="{{ url('admin/class/delete/'.$value->id) }}" class="btn btn-danger">{{ __('messages.delete') }}</a>
                          <button type="button" class="btn btn-info" data-toggle="modal" data-target="#subjectsModal{{ $value->id }}">
                            {{ __('messages.view_subjects') }}
                          </button>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
                <div style="padding: 10px; float: right;">
                  {!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Subjects Modals -->
    @foreach($getRecord as $value)
      <div class="modal fade" id="subjectsModal{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="subjectsModalLabel{{ $value->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="subjectsModalLabel{{ $value->id }}">{{ __('messages.assigned_subjects_for') }} {{ $value->name }}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              @if(count($value->subjects) > 0)
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>{{ __('messages.subject_name') }}</th>
                        <th>{{ __('messages.subject_type') }}</th>
                        <th>{{ __('messages.status') }}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($value->subjects as $subject)
                        <tr>
                          <td>{{ $subject->subject_name }}</td>
                          <td>{{ $subject->subject_type }}</td>
                          <td>
                            @if($subject->status == 0)
                                {{ __('messages.active') }}
                            @else
                                {{ __('messages.inactive') }}
                            @endif
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              @else
                <p>{{ __('messages.no_subjects_assigned') }}</p>
              @endif
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.close') }}</button>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
@endsection
