@extends('layouts.app')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('messages.add_new_activity') }}</h1>
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
                        <form method="post" action="{{ url('admin/activity/store') }}">
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="form-group">
                                    <label>{{ __('messages.activity_name') }} <span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" name="name" required placeholder="{{ __('messages.enter_activity_name') }}">
                                </div>

                                <div class="form-group">
                                    <label>{{ __('messages.description') }}</label>
                                    <textarea class="form-control" name="description" rows="3" placeholder="{{ __('messages.enter_activity_description') }}"></textarea>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('messages.start_date') }} <span style="color: red;">*</span></label>
                                    <input type="date" class="form-control" name="start_date" required>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('messages.end_date') }} <span style="color: red;">*</span></label>
                                    <input type="date" class="form-control" name="end_date" required>
                                </div>

                                <!-- Weekly Schedule Section -->
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">{{ __('messages.weekly_schedule') }}</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="schedule-container">
                                            <div class="schedule-row">
                                                <div class="form-group">
                                                    <label>{{ __('messages.day') }} <span style="color: red;">*</span></label>
                                                    <select class="form-control" name="schedule[0][week_id]" required>
                                                        <option value="">{{ __('messages.select_day') }}</option>
                                                        <option value="7">{{ __('messages.saturday') }}</option>
                                                        <option value="1">{{ __('messages.sunday') }}</option>
                                                        <option value="2">{{ __('messages.monday') }}</option>
                                                        <option value="3">{{ __('messages.tuesday') }}</option>
                                                        <option value="4">{{ __('messages.wednesday') }}</option>
                                                        <option value="5">{{ __('messages.thursday') }}</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ __('messages.start_time') }} <span style="color: red;">*</span></label>
                                                    <input type="time" class="form-control" name="schedule[0][start_time]" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ __('messages.end_time') }} <span style="color: red;">*</span></label>
                                                    <input type="time" class="form-control" name="schedule[0][end_time]" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ __('messages.location') }} <span style="color: red;">*</span></label>
                                                    <input type="text" class="form-control" name="schedule[0][location]" required placeholder="{{ __('messages.enter_activity_location') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-info mt-2" id="addScheduleRow">
                                            <i class="fas fa-plus"></i> {{ __('messages.add_schedule') }}
                                        </button>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('messages.max_students') }} <span style="color: red;">*</span></label>
                                    <input type="number" class="form-control" name="max_students" required min="0">
                                </div>

                                <div class="form-group">
                                    <label>{{ __('messages.cost') }} <span style="color: red;">*</span></label>
                                    <input type="number" class="form-control" name="cost" required min="0" step="0.01">
                                </div>

                                <div class="form-group">
                                    <label>{{ __('messages.status') }}</label>
                                    <select class="form-control" name="status">
                                        <option value="active">{{ __('messages.active') }}</option>
                                        <option value="inactive">{{ __('messages.inactive') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
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
    let scheduleCount = 1;
    const maxSchedules = 7; // Maximum one schedule per day
    
    // Validate form before submission
    $('form').on('submit', function(e) {
        const selectedDays = new Set();
        let hasError = false;
        $('.schedule-row').each(function() {
            const weekId = $(this).find('select[name*="[week_id]"]').val();
            const startTime = $(this).find('input[name*="[start_time]"]').val();
            const endTime = $(this).find('input[name*="[end_time]"]').val();
            const location = $(this).find('input[name*="[location]"]').val();

            // Check for duplicate days
            if (weekId && selectedDays.has(weekId)) {
                alert('{{ __("messages.duplicate_day_error") }}');
                hasError = true;
                return false;
            }
            selectedDays.add(weekId);

            // Validate required fields
            if (!weekId || !startTime || !endTime || !location) {
                alert('{{ __("messages.schedule_fields_required") }}');
                hasError = true;
                return false;
            }

            // Validate time
            if (startTime >= endTime) {
                alert('{{ __("messages.end_time_after_start_time") }}');
                hasError = true;
                return false;
            }
        });

        // Validate dates
        const startDate = new Date($('input[name="start_date"]').val());
        const endDate = new Date($('input[name="end_date"]').val());
        if (startDate >= endDate) {
            alert('{{ __("messages.end_date_after_start_date") }}');
            hasError = true;
        }

        if (hasError) {
            e.preventDefault();
            return false;
        }
    });
    
    $('#addScheduleRow').click(function() {
        if ($('.schedule-row').length >= maxSchedules) {
            alert('{{ __("messages.max_schedules_reached") }}');
            return;
        }
        
        const newRow = `
            <div class="schedule-row mt-3">
                <hr>
                <div class="form-group">
                    <label>{{ __('messages.day') }} <span style="color: red;">*</span></label>
                    <select class="form-control" name="schedule[${scheduleCount}][week_id]" required>
                        <option value="">{{ __('messages.select_day') }}</option>
                        <option value="7">{{ __('messages.saturday') }}</option>
                        <option value="1">{{ __('messages.sunday') }}</option>
                        <option value="2">{{ __('messages.monday') }}</option>
                        <option value="3">{{ __('messages.tuesday') }}</option>
                        <option value="4">{{ __('messages.wednesday') }}</option>
                        <option value="5">{{ __('messages.thursday') }}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>{{ __('messages.start_time') }} <span style="color: red;">*</span></label>
                    <input type="time" class="form-control" name="schedule[${scheduleCount}][start_time]" required>
                </div>
                <div class="form-group">
                    <label>{{ __('messages.end_time') }} <span style="color: red;">*</span></label>
                    <input type="time" class="form-control" name="schedule[${scheduleCount}][end_time]" required>
                </div>
                <div class="form-group">
                    <label>{{ __('messages.location') }} <span style="color: red;">*</span></label>
                    <input type="text" class="form-control" name="schedule[${scheduleCount}][location]" required placeholder="{{ __('messages.enter_activity_location') }}">
                </div>
                <button type="button" class="btn btn-danger remove-schedule">
                    <i class="fas fa-trash"></i> {{ __('messages.delete') }}
                </button>
            </div>
        `;
        
        $('.schedule-container').append(newRow);
        scheduleCount++;
    });
    
    // Fix the schedule indices when removing a row
    $(document).on('click', '.remove-schedule', function() {
        $(this).closest('.schedule-row').remove();
        // Reindex remaining schedules
        $('.schedule-row').each(function(index) {
            $(this).find('[name^="schedule["]').each(function() {
                const oldName = $(this).attr('name');
                const newName = oldName.replace(/schedule\[\d+\]/, `schedule[${index}]`);
                $(this).attr('name', newName);
            });
        });
    });
});
</script>
@endsection