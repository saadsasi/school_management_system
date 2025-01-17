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
              <form method="post" action="">
                 {{ csrf_field() }}
                <div class="card-body">
                  <div class="form-group">
                    <label>{{ __('messages.subject_name') }}</label>
                    <input type="text" class="form-control" name="name" value="{{ $getRecord->name }}" required placeholder="{{ __('messages.subject_name') }}">
                  </div>

                  <div class="form-group">
                    <label>{{ __('messages.grade_level') }}</label>
                    <select class="form-control" name="grade_level" required>
                        <option value="first_primary" {{ ($getRecord->grade_level == 'first_primary') ? 'selected' : '' }}>الصف الأول الابتدائي</option>
                        <option value="second_primary" {{ ($getRecord->grade_level == 'second_primary') ? 'selected' : '' }}>الصف الثاني الابتدائي</option>
                        <option value="third_primary" {{ ($getRecord->grade_level == 'third_primary') ? 'selected' : '' }}>الصف الثالث الابتدائي</option>
                        <option value="fourth_primary" {{ ($getRecord->grade_level == 'fourth_primary') ? 'selected' : '' }}>الصف الرابع الابتدائي</option>
                        <option value="fifth_primary" {{ ($getRecord->grade_level == 'fifth_primary') ? 'selected' : '' }}>الصف الخامس الابتدائي</option>
                        <option value="sixth_primary" {{ ($getRecord->grade_level == 'sixth_primary') ? 'selected' : '' }}>الصف السادس الابتدائي</option>
                        <option value="first_preparatory" {{ ($getRecord->grade_level == 'first_preparatory') ? 'selected' : '' }}>الصف الأول الإعدادي</option>
                        <option value="second_preparatory" {{ ($getRecord->grade_level == 'second_preparatory') ? 'selected' : '' }}>الصف الثاني الإعدادي</option>
                        <option value="third_preparatory" {{ ($getRecord->grade_level == 'third_preparatory') ? 'selected' : '' }}>الصف الثالث الإعدادي</option>
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
                        <option {{ ($getRecord->status == 0) ? 'selected' : '' }} value="0">{{ __('messages.active') }}</option>
                        <option {{ ($getRecord->status == 1) ? 'selected' : '' }} value="1">{{ __('messages.inactive') }}</option>
                    </select>
                    
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