@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('messages.edit') }}</h1>
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
                        <form method="post" action="{{ url('admin/activity/update/'.$activity->id) }}">
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="form-group">
                                    <label>{{ __('messages.name') }} <span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" name="name" value="{{ $activity->name }}" required placeholder="{{ __('messages.enter_activity_name') }}">
                                </div>

                                <div class="form-group">
                                    <label>{{ __('messages.description') }}</label>
                                    <textarea class="form-control" name="description" rows="3" placeholder="{{ __('messages.enter_activity_description') }}">{{ $activity->description }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('messages.start_date') }} <span style="color: red;">*</span></label>
                                    <input type="date" class="form-control" name="start_date" value="{{ $activity->start_date }}" required>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('messages.end_date') }} <span style="color: red;">*</span></label>
                                    <input type="date" class="form-control" name="end_date" value="{{ $activity->end_date }}" required>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('messages.max_students') }} <span style="color: red;">*</span></label>
                                    <input type="number" class="form-control" name="max_students" value="{{ $activity->max_students }}" required>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('messages.cost') }} <span style="color: red;">*</span></label>
                                    <input type="number" step="0.01" class="form-control" name="cost" value="{{ $activity->cost }}" required>
                                </div>

                                <!-- Weekly Schedule Section -->
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">{{ __('messages.activity_weekly_schedule') }}</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="schedule-container">
                                            @foreach($activity->schedules as $index => $schedule)
                                            <div class="schedule-row">
                                                <div class="form-group">
                                                    <label>{{ __('messages.day') }}</label>
                                                    <select class="form-control" name="schedule[{{ $index }}][week_id]">
                                                        <option value="">{{ __('messages.select_day') }}</option>
                                                        <option value="1" {{ $schedule->week_id == 1 ? 'selected' : '' }}>{{ __('messages.sunday') }}</option>
                                                        <option value="2" {{ $schedule->week_id == 2 ? 'selected' : '' }}>{{ __('messages.monday') }}</option>
                                                        <option value="3" {{ $schedule->week_id == 3 ? 'selected' : '' }}>{{ __('messages.tuesday') }}</option>
                                                        <option value="4" {{ $schedule->week_id == 4 ? 'selected' : '' }}>{{ __('messages.wednesday') }}</option>
                                                        <option value="5" {{ $schedule->week_id == 5 ? 'selected' : '' }}>{{ __('messages.thursday') }}</option>
                                                        <option value="6" {{ $schedule->week_id == 6 ? 'selected' : '' }}>{{ __('messages.friday') }}</option>
                                                        <option value="7" {{ $schedule->week_id == 7 ? 'selected' : '' }}>{{ __('messages.saturday') }}</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ __('messages.start_time') }}</label>
                                                    <input type="time" class="form-control" name="schedule[{{ $index }}][start_time]" value="{{ $schedule->start_time }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ __('messages.end_time') }}</label>
                                                    <input type="time" class="form-control" name="schedule[{{ $index }}][end_time]" value="{{ $schedule->end_time }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ __('messages.location') }}</label>
                                                    <input type="text" class="form-control" name="schedule[{{ $index }}][location]" value="{{ $schedule->location }}" placeholder="{{ __('messages.activity_location') }}">
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        <button type="button" class="btn btn-info mt-2" id="addScheduleRow">
                                            {{ __('messages.add_new_schedule') }}
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ __('messages.save_changes') }}</button>
                                <a href="{{ url('admin/activities') }}" class="btn btn-default">{{ __('messages.cancel') }}</a>
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
<script>
$(document).ready(function() {
    let scheduleIndex = {{ count($activity->schedules) }};
    
    $('#addScheduleRow').click(function() {
        const newRow = `
            <div class="schedule-row">
                <div class="form-group">
                    <label>{{ __('messages.day') }}</label>
                    <select class="form-control" name="schedule[${scheduleIndex}][week_id]">
                        <option value="">{{ __('messages.select_day') }}</option>
                        <option value="1">{{ __('messages.sunday') }}</option>
                        <option value="2">{{ __('messages.monday') }}</option>
                        <option value="3">{{ __('messages.tuesday') }}</option>
                        <option value="4">{{ __('messages.wednesday') }}</option>
                        <option value="5">{{ __('messages.thursday') }}</option>
                        <option value="6">{{ __('messages.friday') }}</option>
                        <option value="7">{{ __('messages.saturday') }}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>{{ __('messages.start_time') }}</label>
                    <input type="time" class="form-control" name="schedule[${scheduleIndex}][start_time]">
                </div>
                <div class="form-group">
                    <label>{{ __('messages.end_time') }}</label>
                    <input type="time" class="form-control" name="schedule[${scheduleIndex}][end_time]">
                </div>
                <div class="form-group">
                    <label>{{ __('messages.location') }}</label>
                    <input type="text" class="form-control" name="schedule[${scheduleIndex}][location]" placeholder="{{ __('messages.activity_location') }}">
                </div>
            </div>
        `;
        $('.schedule-container').append(newRow);
        scheduleIndex++;
    });
});
</script>
@endsection