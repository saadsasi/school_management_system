@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ __('messages.edit_admin') }}</h1>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary">
              <form method="post" action="" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card-body">
                  <div class="form-group">
                    <label>{{ __('messages.name') }}</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name', $getRecord->name) }}" required placeholder="{{ __('messages.name') }}">
                  </div>
                  <div class="form-group">
                    <label>{{ __('messages.email') }}</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email', $getRecord->email) }}" required placeholder="{{ __('messages.email') }}">
                    <div style="color:red">{{ $errors->first('email') }}</div>                     
                  </div>
                  <div class="form-group">
                    <label>{{ __('messages.password') }}</label>
                    <input type="text" class="form-control" name="password" placeholder="{{ __('messages.password') }}">
                    <p>{{ __('messages.change_password_note') }}</p>
                  </div>

                  <div class="form-group">
                    <label>{{ __('messages.profile_pic') }}</label>
                    <input type="file" class="form-control" name="profile_pic">
                    <div style="color:red">{{ $errors->first('profile_pic') }}</div>
                    @if(!empty($getRecord->getProfile()))
                      <img src="{{ $getRecord->getProfile() }}" style="width: auto;height: 50px;"> 
                    @endif
                  </div>
                </div>

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">{{ __('messages.update') }}</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

@endsection