@extends('layouts.app')

@section('content')



<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1> {{__('messages.parent_list')}} ({{__('messages.total')}} : {{ $getRecord->total() }})</h1>
          </div>
          <div class="col-sm-6" style="text-align: right;">
              <a href="{{ url('admin/parent/add') }}" class="btn btn-primary"> {{__('messages.add_new_parent')}}</a>
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
                <h3 class="card-title"> {{__('messages.search_parent')}} </h3>
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
                    <button class="btn btn-primary" type="submit" style="margin-top: 30px;"> {{__('messages.search')}} </button>
                    <a href="{{ url('admin/parent/list') }}" class="btn btn-success" style="margin-top: 30px;"> {{__('messages.reset')}} </a>

                  </div>

                  </div>
                </div>
              </form>
            </div>


            @include('_message')
            
            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title"> {{__('messages.parent_list')}}</h3>
                 <form action="{{ url('admin/parent/export_excel') }}" method="post" style="float: right;">
                    {{ csrf_field() }}
                    <input type="hidden" name="name" value="{{ Request::get('name') }}">
                    <input type="hidden" name="last_name" value="{{ Request::get('last_name') }}">
                    <input type="hidden" name="email" value="{{ Request::get('email') }}">
                    <input type="hidden" name="gender" value="{{ Request::get('gender') }}">
                    <input type="hidden" name="occupation" value="{{ Request::get('occupation') }}">
                    <input type="hidden" name="address" value="{{ Request::get('address') }}">
                    <input type="hidden" name="mobile_number" value="{{ Request::get('mobile_number') }}">
                    <input type="hidden" name="status" value="{{ Request::get('status') }}">
                    <input type="hidden" name="date" value="{{ Request::get('date') }}">
                    <button class="btn btn-primary">Export Excel</button>
                </form>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th> {{__('messages.profile_pic')}} </th>
                      <th> {{__('messages.name')}} </th>
                      <th> {{__('messages.email')}} </th>
                      <th> {{__('messages.gender')}} </th>
                      <th> {{__('messages.mobile_number')}} </th>
                      <th> {{__('messages.occupation')}} </th>
                      <th> {{__('messages.address')}} </th>
                      <th> {{__('messages.status')}} </th>
                      <th> {{__('messages.created_date')}} </th>
                      <th> {{__('messages.action')}} </th>
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
                           <td>{{ $value->email }}</td>
                           <td>{{ $value->gender }}</td>
                           <td>{{ $value->mobile_number }}</td>
                           <td>{{ $value->occupation }}</td>
                           <td>{{ $value->address }}</td>
                           <td>{{ ($value->status == 0) ? 'Active' : 'Inactive' }}</td>
                           
                          <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                          <td>
                            <a href="{{ url('admin/parent/edit/'.$value->id) }}" class="btn btn-primary"> {{__('messages.edit')}} </a>
                            <a href="{{ url('admin/parent/delete/'.$value->id) }}" class="btn btn-danger"> {{__('messages.delete')}} </a>
                            <a href="{{ url('admin/parent/my-student/'.$value->id) }}" class="btn btn-secondary"> {{__('messages.my_student')}} </a>
                            <a href="{{ url('chat?receiver_id='.base64_encode($value->id)) }}" class="btn btn-success"> {{__('messages.send_message')}} </a>
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

@endsection