@extends('layouts.app')

@section('content')



<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1> {{__('messages.my_kids_list')}} ({{ $getParent->name }} {{ $getParent->last_name }})</h1>
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
                <h3 class="card-title"> {{__('messages.search_student')}} </h3>
              </div>
              <form method="get" action="">
                <div class="card-body">
                  <div class="row">
                    


                  <div class="form-group col-md-4">
                    <label> {{__('messages.name')}} </label>
                    <input type="text" class="form-control" value="{{ Request::get('name') }}" name="name"  placeholder=" {{__('messages.name')}} ">
                  </div>

                  <div class="form-group col-md-4">
                    <label> {{__('messages.last_name')}} </label>
                    <input type="text" class="form-control" value="{{ Request::get('last_name') }}" name="last_name"  placeholder=" {{__('messages.last_name')}} ">
                  </div>



              

                  <div class="form-group col-md-3">
                    <button class="btn btn-primary" type="submit" style="margin-top: 30px;">{{ __('messages.search') }}</button>
                    <a href="{{ url('admin/parent/my-student/'.$parent_id) }}" class="btn btn-success" style="margin-top: 30px;">{{ __('messages.reset') }}</a>

                  </div>

                  </div>
                </div>
              </form>
            </div>


            @include('_message')
            
            <!-- /.card -->

@if(!empty($getSearchStudent))
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"> {{__('messages.student_list')}} </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th> {{__('messages.profile_pic')}} </th>
                      <th> {{__('messages.student_name')}} </th>
                      <th> {{__('messages.email')}} </th>
                      <th> {{__('messages.parent_name')}} </th>
                      <th> {{__('messages.relationship_type')}} </th>
                      <th> {{__('messages.created_date')}} </th>
                      <th> {{__('messages.action')}} </th>
                    </tr>
                  </thead>
                  <tbody>
                     @foreach($getSearchStudent as $value)
                        <tr>
                          <td>{{ $value->id }}</td>
                          <td>
                            @if(!empty($value->getProfile()))
                            <img src="{{ $value->getProfile() }}" style="height: 50px; width:50px; border-radius: 50px;">
                            @endif
                          </td>
                          <td>{{ $value->name }} {{ $value->last_name }}</td>
                          <td>{{ $value->email }}</td>
                          <td>{{ $value->parent_name }}</td>
                          <td>{{ !empty($value->relationship_type) ? __('messages.'.$value->relationship_type) : '' }}</td>
                          <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                          <td style="min-width: 150px;">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#assignModal{{ $value->id }}">
                              {{__('messages.add_student_to_parent')}}
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="assignModal{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="assignModalLabel{{ $value->id }}" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="assignModalLabel{{ $value->id }}">{{__('messages.select_relationship_type')}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <form method="post" action="{{ url('admin/parent/assign_student_parent/'.$value->id.'/'.$parent_id) }}">
                                    {{ csrf_field() }}
                                    <div class="modal-body">
                                      <div class="form-group">
                                        <label>{{__('messages.relationship_type')}} <span style="color: red;">*</span></label>
                                        <select class="form-control" required name="relationship_type">
                                          <option value="">{{__('messages.select_relationship_type')}}</option>
                                          <option value="father">{{__('messages.father')}}</option>
                                          <option value="grandfather">{{__('messages.grandfather')}}</option>
                                          <option value="brother">{{__('messages.brother')}}</option>
                                          <option value="uncle">{{__('messages.uncle')}}</option>
                                          <option value="maternal_uncle">{{__('messages.maternal_uncle')}}</option>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('messages.close')}}</button>
                                      <button type="submit" class="btn btn-primary">{{__('messages.assign')}}</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </td>
                        </tr>
                      @endforeach
                  </tbody>
                </table>
                <div style="padding: 10px; float: right;">
                  
                </div>

              </div>

              <!-- /.card-body -->
            </div>
@endif



             <div class="card">
              <div class="card-header">
                <h3 class="card-title"> {{__('messages.parent_student_list')}} </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                 <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th> {{__('messages.profile_pic')}} </th>
                      <th> {{__('messages.student_name')}} </th>
                      <th> {{__('messages.email')}} </th>
                      <th> {{__('messages.parent_name')}} </th>
                      <th> {{__('messages.relationship_type')}} </th>
                      <th> {{__('messages.created_date')}} </th>
                      <th> {{__('messages.action')}} </th>
                    </tr>
                  </thead>
                  <tbody>
                     @foreach($getRecord as $value)
                        <tr>
                          <td>{{ $value->id }}</td>
                          <td>
                            @if(!empty($value->getProfile()))
                            <img src="{{ $value->getProfile() }}" style="height: 50px; width:50px; border-radius: 50px;">
                            @endif
                          </td>
                          <td>{{ $value->name }} {{ $value->last_name }}</td>
                          <td>{{ $value->email }}</td>
                          <td>{{ $value->parent_name }}</td>
                          <td>{{ !empty($value->relationship_type) ? __('messages.'.$value->relationship_type) : '' }}</td>
                          <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                          <td style="min-width: 150px;">

                            <a href="{{ url('admin/parent/assign_student_parent_delete/'.$value->id) }}" class="btn btn-danger"> {{__('messages.delete_student')}} </a>
                        
                          </td>
                        </tr>
                      @endforeach
                  </tbody>
                </table>
                <div style="padding: 10px; float: right;">
                  
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

@endsection