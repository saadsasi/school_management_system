@extends('layouts.app')
@section('style')
 <link rel="stylesheet" href="{{ url('plugins/select2/css/select2.min.css') }}">
 <style type="text/css">
   .select2-container .select2-selection--single 
   {
      height: 40px;
   }
 </style>
@endsection
@section('content')

 <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ __('messages.send_email') }}</h1>
          </div>
    
        </div>
      </div>
    </section>

    
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
             @include('_message')
            <div class="card card-primary">
              <form method="post" action="">
                 {{ csrf_field() }}
                <div class="card-body">

                  <div class="form-group">
                    <label>{{ __('messages.subject') }}</label>
                    <input type="text" class="form-control" name="subject" required placeholder=" {{ __('messages.subject') }}">
                  </div>


                  <div class="form-group">
                    <label>User (Student / Parent / Teacher)</label>
                    <select name="user_id" class="form-control select2" style="width: 100%;">
                      <option value="">{{ __('messages.select') }}</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label style="display: block;">{{ __('messages.send_to') }} </label>
                    <label style="margin-right: 50px;"><input type="checkbox" value="3" name="message_to[]"> {{ __('messages.student') }}</label>
                    <label style="margin-right: 50px;"><input type="checkbox" value="4" name="message_to[]"> {{ __('messages.parent') }}</label>
                    <label><input type="checkbox" value="2" name="message_to[]"> {{ __('messages.teacher') }}</label>
                  </div>


                  <div class="form-group">
                    <label>{{ __('messages.message') }}</label>
                    <textarea id="compose-textarea" name="message" class="form-control" style="height: 300px"></textarea>
                  </div>
                
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">{{ __('messages.send') }} {{ __('messages.email') }}</button>
                </div>
              </form>
            </div>
         

          </div>
        </div>

      </div>
    </section>

  </div>

@endsection

@section('script')

	<script src="{{ url('plugins/summernote/summernote-bs4.min.js') }}"></script>
  <script src="{{ url('plugins/select2/js/select2.full.min.js') }}"></script>

	<script type="text/javascript">	
	
		  $(function () {

      $('.select2').select2({
          ajax: {
              url: '{{ url('admin/communicate/search_user') }}',
              dataType: 'json',
              delay: 250,
              data: function (data) {
                  return {
                      search: data.term,
                  };
              },
              processResults: function (response) {
                  return {
                      results:response
                  };
              },
          }
       });
         

	  	$('#compose-textarea').summernote({
			  height: 200
			});
		    
		  
	  });

	</script>
@endsection