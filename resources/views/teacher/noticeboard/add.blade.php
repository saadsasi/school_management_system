@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('messages.add_new_notice') }}</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <form method="post" action="{{ url('teacher/noticeboard/store') }}">
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="form-group">
                                    <label>{{ __('messages.notice_title') }}</label>
                                    <input type="text" class="form-control" name="title" required>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('messages.notice_date') }}</label>
                                    <input type="date" class="form-control" name="notice_date" required>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('messages.publish_date') }}</label>
                                    <input type="date" class="form-control" name="publish_date" required>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('messages.message_to') }}</label>
                                    <div>
                                        <label style="margin-right: 20px;">
                                            <input type="checkbox" value="2" name="message_to[]"> {{ __('messages.teacher') }}
                                        </label>
                                        <label style="margin-right: 20px;">
                                            <input type="checkbox" value="3" name="message_to[]"> {{ __('messages.student') }}
                                        </label>
                                        <label style="margin-right: 20px;">
                                            <input type="checkbox" value="4" name="message_to[]"> {{ __('messages.parent') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('messages.notice_message') }}</label>
                                    <textarea id="compose-textarea" name="message" class="form-control" style="height: 300px"></textarea>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ __('messages.submit') }}</button>
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
<script type="text/javascript">
    $(function () {
        $('#compose-textarea').summernote({
            height: 200
        });
    });
</script>
@endsection