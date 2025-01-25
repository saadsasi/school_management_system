@extends('layouts.app')

@section('style')
<style>
.modal-body p {
    margin-bottom: 1rem;
}
.modal-body .table {
    margin-top: 1rem;
}
.modal-body strong {
    font-weight: 600;
    color: #61a5e9;
}
</style>
@endsection

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ __('messages.student_list') }} ({{__('messages.total')}} : {{ $getRecord->total() }})</h1>
          </div>
          <div class="col-sm-6" style="text-align: right;">
              <a href="{{ url('admin/student/add') }}" class="btn btn-primary">{{ __('messages.add_new_student') }}</a>
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
                <h3 class="card-title">{{ __('messages.search_student') }}</h3>
              </div>
              <form method="get" action="">
                <div class="card-body">
                  <div class="row">
                    
                  
                  <div class="form-group col-md-4">
                    <label>{{ __('messages.name') }}</label>
                    <input type="text" class="form-control" value="{{ Request::get('name') }}" name="name"  placeholder="{{ __('messages.name') }}">
                  </div>

                  <div class="form-group col-md-4">
                    <label>{{ __('messages.last_name') }}</label>
                    <input type="text" class="form-control" value="{{ Request::get('last_name') }}" name="last_name"  placeholder="{{ __('messages.last_name') }}">
                  </div>


                  <div class="form-group col-md-3">
                    <button class="btn btn-primary" type="submit" style="margin-top: 30px;">{{ __('messages.search') }}</button>
                    <a href="{{ url('admin/student/list') }}" class="btn btn-success" style="margin-top: 30px;">{{ __('messages.reset') }}</a>

                  </div>

                  </div>
                </div>
              </form>
            </div>
          
         
         


            @include('_message')
            
            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{ __('messages.student_list') }}</h3>
                <form action="{{ url('admin/student/export_excel') }}" method="post" style="float: right;">
                    {{ csrf_field() }}
                    <input type="hidden" name="name" value="{{ Request::get('name') }}">
                    <input type="hidden" name="last_name" value="{{ Request::get('last_name') }}">
                    <input type="hidden" name="email" value="{{ Request::get('email') }}">
                    <input type="hidden" name="gender" value="{{ Request::get('gender') }}">
                    <input type="hidden" name="class" value="{{ Request::get('class') }}">
                    <input type="hidden" name="grade_level" value="{{ Request::get('grade_level') }}">
                    <input type="hidden" name="mobile_number" value="{{ Request::get('mobile_number') }}">
                    <input type="hidden" name="status" value="{{ Request::get('status') }}">
                    <input type="hidden" name="admission_date" value="{{ Request::get('admission_date') }}">
                    <input type="hidden" name="date" value="{{ Request::get('date') }}">
                    <button class="btn btn-primary">{{ __('messages.export_excel') }}</button>
                </form>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0" style="overflow: auto;">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>{{ __('messages.profile_pic') }}</th>
                      <th>{{ __('messages.student_name') }}</th>
                      <th>{{ __('messages.parent_name') }}</th>
                      <th>{{ __('messages.email') }}</th>
                      <th>{{ __('messages.class') }}</th>
                      <th>{{ __('messages.grade_level') }}</th>
                      <th>{{ __('messages.gender') }}</th>
                      <th>{{ __('messages.date_of_birth') }} </th>
                      <th>{{ __('messages.mobile_number') }}</th>
                      <th>{{ __('messages.admission_date') }}</th>
                      <th>{{ __('messages.status') }}</th>
                      <th>{{ __('messages.created_date') }}</th>
                      <th>{{ __('messages.action') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach($getRecord as $value)
                        <tr>
                          <td>{{ $value->id }}</td>
                          <td>
                            @if(!empty($value->getProfileDirect()))
                            <img src="{{ $value->getProfileDirect() }}" style="height: 50px; width:50px; border-radius: 50px;">
                            @endif
                          </td>

                          <td>{{ $value->name }} {{ $value->last_name }}</td>
                          <td>{{ $value->parent_name }} {{ $value->parent_last_name }}</td>
                          <td>{{ $value->email }}</td>
                          <td>{{ $value->class_name }}</td>
                          <td>{{ __('messages.'.$value->grade_level) }}</td>
                          <td>{{ __('messages.'.$value->gender) }}</td>
                          <td>
                              @if(!empty($value->date_of_birth))
                              {{ date('d-m-Y', strtotime($value->date_of_birth)) }}
                              @endif
                            </td>
                          <td>{{ $value->mobile_number }}</td>
                          <td>
                            @if(!empty($value->admission_date))
                              {{ date('d-m-Y', strtotime($value->admission_date)) }}
                              @endif
                          </td>
                          
                          <td>{{ ($value->status == 0) ? 'Active' : 'Inactive' }}</td>
                          

                          <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                          <td style="min-width: 270px;">
                            <a href="{{ url('admin/student/edit/'.$value->id) }}" class="btn btn-primary btn-sm">{{ __('messages.edit') }}</a>
                            <a href="{{ url('admin/student/delete/'.$value->id) }}" class="btn btn-danger btn-sm">{{ __('messages.delete') }}</a>
                            <a href="{{ url('chat?receiver_id='.base64_encode($value->id)) }}" class="btn btn-success btn-sm">{{ __('messages.send_message') }}</a>
                            <button type="button" class="btn btn-info btn-sm" onclick="showMedicalInfo({{ $value->id }})">
                              <i class="fas fa-notes-medical"></i> {{ __('messages.medical_file') }}
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
   
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

  <!-- Add Modal -->
  <div class="modal fade" id="medicalInfoModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.medical_info') }}</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>{{ __('messages.height') }}:</strong> <span id="modal-height"></span> cm</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>{{ __('messages.weight') }}:</strong> <span id="modal-weight"></span> kg</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>{{ __('messages.blood_group') }}:</strong> <span id="modal-blood-group"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>{{ __('messages.allergies') }}:</strong> <span id="modal-allergies"></span></p>
                    </div>
                    <div class="col-md-12">
                        <p><strong>{{ __('messages.medical_condition') }}:</strong> <span id="modal-medical-condition"></span></p>
                    </div>
                </div>

                <div class="table-responsive mt-4">
                    <h5>{{ __('messages.medical_history') }}</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('messages.record_date') }}</th>
                                <th>{{ __('messages.height') }}</th>
                                <th>{{ __('messages.weight') }}</th>
                                <th>{{ __('messages.blood_group') }}</th>
                                <th>{{ __('messages.created_by') }}</th>
                            </tr>
                        </thead>
                        <tbody id="medical-history-table">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" id="edit-medical-info" class="btn btn-primary">
                    <i class="fas fa-edit"></i> {{ __('messages.edit') }}
                </a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.close') }}</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>
function showMedicalInfo(studentId) {
    $.ajax({
        url: '/admin/student/medical-info/' + studentId,
        type: 'GET',
        success: function(response) {
            $('#modal-height').text(response.height || '-');
            $('#modal-weight').text(response.weight || '-');
            $('#modal-blood-group').text(response.blood_group || '-');
            $('#modal-allergies').text(response.allergies || '-');
            $('#modal-medical-condition').text(response.medical_condition || '-');
            
            $('#edit-medical-info').attr('href', '/admin/student/medical-file/' + studentId);
            
            let historyHtml = '';
            response.health_records.forEach(function(record) {
                historyHtml += `
                    <tr>
                        <td>${moment(record.record_date).format('DD-MM-YYYY')}</td>
                        <td>${record.height || '-'}  cm</td>
                        <td>${record.weight || '-'}  kg</td>
                        <td>${record.blood_group || '-'}</td>
                        <td>${record.creator_name}</td>
                    </tr>
                `;
            });
            $('#medical-history-table').html(historyHtml);
            
            $('#medicalInfoModal').modal('show');
        }
    });
}
</script>
@endsection