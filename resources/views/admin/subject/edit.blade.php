@extends('layouts.app')

@section('content')

 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ __('messages.edit_subject') }}</h1>
          </div>
    
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <div class="card card-primary">
              <form method="post" action="" enctype="multipart/form-data">
                 {{ csrf_field() }}
                <div class="card-body">
                  <div class="form-group">
                    <label>{{ __('messages.subject_name') }}</label>
                    <input type="text" class="form-control" name="name" value="{{ $getRecord->name }}" required placeholder="{{ __('messages.subject_name') }}">
                  </div>

                  <div class="form-group">
                    <label>{{ __('messages.curriculum_file') }}</label>
                    <input type="file" class="form-control" name="curriculum_file" accept=".pdf,.doc,.docx">
                    @if($getRecord->curriculum_file)
                      <p class="mt-2">
                        <a href="{{ url('uploads/curriculum/'.$getRecord->curriculum_file) }}" target="_blank" class="btn btn-info btn-sm">
                          <i class="fas fa-download"></i> {{ __('messages.download_current_file') }}
                        </a>
                      </p>
                    @endif
                    <small class="form-text text-muted">{{ __('messages.curriculum_file_help') }}</small>
                  </div>

                  <div class="form-group">
                    <label>{{ __('messages.grade_level') }}</label>
                    <select class="form-control" name="grade_level" required>
                        <option value="first_primary" {{ ($getRecord->grade_level == 'first_primary') ? 'selected' : '' }}>{{ __('messages.first_primary') }}</option>
                        <option value="second_primary" {{ ($getRecord->grade_level == 'second_primary') ? 'selected' : '' }}>{{ __('messages.second_primary') }}</option>
                        <option value="third_primary" {{ ($getRecord->grade_level == 'third_primary') ? 'selected' : '' }}>{{ __('messages.third_primary') }}</option>
                        <option value="fourth_primary" {{ ($getRecord->grade_level == 'fourth_primary') ? 'selected' : '' }}>{{ __('messages.fourth_primary') }}</option>
                        <option value="fifth_primary" {{ ($getRecord->grade_level == 'fifth_primary') ? 'selected' : '' }}>{{ __('messages.fifth_primary') }}</option>
                        <option value="sixth_primary" {{ ($getRecord->grade_level == 'sixth_primary') ? 'selected' : '' }}>{{ __('messages.sixth_primary') }}</option>
                        <option value="first_preparatory" {{ ($getRecord->grade_level == 'first_preparatory') ? 'selected' : '' }}>{{ __('messages.first_preparatory') }}</option>
                        <option value="second_preparatory" {{ ($getRecord->grade_level == 'second_preparatory') ? 'selected' : '' }}>{{ __('messages.second_preparatory') }}</option>
                        <option value="third_preparatory" {{ ($getRecord->grade_level == 'third_preparatory') ? 'selected' : '' }}>{{ __('messages.third_preparatory') }}</option>
                    </select>
                </div>

                 <div class="form-group">
                    <label>{{ __('messages.subject_type') }}</label>
                    <select class="form-control" name="type" required>
                    	  <option value="">{{ __('messages.select_type') }}</option>
                      	<option {{ ($getRecord->type == 'Theory') ? 'selected' : '' }} value="Theory">{{ __('messages.theory') }}</option>
                        <option {{ ($getRecord->type == 'Practical') ? 'selected' : '' }} value="Practical">{{ __('messages.practical') }}</option>
                    </select>
                    
                  </div>

                  <div class="form-group">
                    <label>{{ __('messages.status') }}</label>
                    <select class="form-control" name="status">
                        <option value="0" {{ ($getRecord->status == 0) ? 'selected' : '' }}>{{ __('messages.active') }}</option>
                        <option value="1" {{ ($getRecord->status == 1) ? 'selected' : '' }}>{{ __('messages.inactive') }}</option>
                    </select>
                    
                  </div>

                  <div class="form-group">
                    <label>{{ __('messages.curriculum_file') }}</label>
                    <input type="file" class="form-control" name="curriculum_file" accept=".pdf,.doc,.docx">
                    <small class="text-muted">{{ __('messages.curriculum_file_help') }}</small>
                    @if($getRecord->curriculum_file)
                        <div class="mt-2">
                            <a href="{{ url('admin/subject/download-curriculum/'.$getRecord->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-download"></i> {{ __('messages.download_current_file') }}
                            </a>
                            <span class="ml-2">{{ $getRecord->curriculum_file }}</span>
                        </div>
                    @endif
                </div>
              
                
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">{{ __('messages.update') }}</button>
                </div>
              </form>
            </div>
         

          </div>
          <!--/.col (left) -->
          <!-- right column -->
       
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection