@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ __('messages.my_timetable') }}</h1>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            @include('_message')
            
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{ __('messages.weekly_schedule') }}</h3>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>{{ __('messages.week') }}</th>
                        @php
                          $timeSlots = [];
                          // Collect all unique time slots
                          foreach($getRecord as $subject) {
                            foreach($subject['week'] as $weekDay) {
                              if(!empty($weekDay['start_time']) && !empty($weekDay['end_time'])) {
                                $timeSlot = $weekDay['start_time'] . ' - ' . $weekDay['end_time'];
                                if(!in_array($timeSlot, $timeSlots)) {
                                  $timeSlots[] = $timeSlot;
                                }
                              }
                            }
                          }
                          // Sort time slots
                          sort($timeSlots);
                        @endphp
                        @foreach($timeSlots as $timeSlot)
                          <th>{{ date('h:i A', strtotime(explode(' - ', $timeSlot)[0])) }} - {{ date('h:i A', strtotime(explode(' - ', $timeSlot)[1])) }}</th>
                        @endforeach
                      </tr>
                    </thead>
                    <tbody>
                      @php
                        // Define the order of days starting from Saturday
                        $dayOrder = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday'];
                        // Create an associative array of week data for easier access
                        $weekData = [];
                        foreach($getRecord[0]['week'] as $weekIndex => $week) {
                          $weekData[$week['week_name']] = ['index' => $weekIndex, 'data' => $week];
                        }
                      @endphp

                      @foreach($dayOrder as $dayName)
                        @if(isset($weekData[$dayName]))
                          <tr>
                            <td><strong>{{ __('messages.'.strtolower($dayName)) }}</strong></td>
                            @foreach($timeSlots as $timeSlot)
                              <td>
                                @foreach($getRecord as $subject)
                                  @php
                                    $weekIndex = $weekData[$dayName]['index'];
                                    $currentWeek = $subject['week'][$weekIndex];
                                    $currentTimeSlot = (!empty($currentWeek['start_time']) && !empty($currentWeek['end_time'])) ? 
                                      $currentWeek['start_time'] . ' - ' . $currentWeek['end_time'] : '';
                                  @endphp
                                  @if($currentTimeSlot == $timeSlot)
                                    <div>
                                      <strong>{{ $subject['name'] }}</strong>
                                      @if(!empty($currentWeek['room_number']))
                                        <br><small>{{ __('messages.room') }}: {{ $currentWeek['room_number'] }}</small>
                                      @endif
                                    </div>
                                  @endif
                                @endforeach
                              </td>
                            @endforeach
                          </tr>
                        @endif
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

@endsection