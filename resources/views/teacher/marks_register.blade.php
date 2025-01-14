@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ __('messages.marks_register') }}</h1>
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
                <h3 class="card-title">{{ __('messages.search_marks_register') }}</h3>
              </div>
              <form method="get" action="">
                <div class="card-body">
                  <div class="row">
                    
                  
                  <div class="form-group col-md-3">
                    <label>{{ __('messages.exam') }}</label>
                    <select class="form-control" name="exam_id" required>
                        <option value="">{{__('messages.select')}}</option>     
                        @foreach($getExam as $exam)                                         
                          <option {{ (Request::get('exam_id') == $exam->exam_id) ? 'selected' : '' }} value="{{ $exam->exam_id }}">{{ $exam->exam_name }}</option>
                        @endforeach
                    </select>
                  </div>

                  <div class="form-group col-md-3">
                    <label>{{ __('messages.class') }}</label>
                    <select class="form-control" name="class_id" required>
                        <option value="">{{__('messages.select')}}</option>                                              
                        @foreach($getClass as $class)                                         
                          <option {{ (Request::get('class_id') == $class->class_id) ? 'selected' : '' }} value="{{ $class->class_id }}">{{ $class->class_name }}</option>
                        @endforeach
                    </select>
                  </div>
          

                  <div class="form-group col-md-3">
                    <button class="btn btn-primary" type="submit" style="margin-top: 30px;">{{ __('messages.search') }}</button>
                    <a href="{{ url('admin/examinations/marks_register') }}" class="btn btn-success" style="margin-top: 30px;">{{ __('messages.reset') }}</a>

                  </div>

                  </div>
                </div>
              </form>
            </div>
         


            @include('_message')
            

          @if(!empty($getSubject) && !empty($getSubject->count()))
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{ __('messages.marks_register') }}</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0" style="overflow: auto;">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>{{ __('messages.student_name') }}</th>
                      @foreach($getSubject as $subject)
                      <th>
                        {{ $subject->subject_name }}  <br />
                        ({{ $subject->subject_type }} : {{ $subject->passing_mark }} / {{ $subject->full_marks }})
                      </th>
                      @endforeach
                      <th>{{ __('messages.action') }}</th>                      
                    </tr>
                  </thead>
                  <tbody>
                      @if(!empty($getStudent) && !empty($getStudent->count()))
                          @foreach($getStudent as $student)
                          <form name="post" class="SubmitForm">
                              {{ csrf_field() }}
                              <input type="hidden" name="student_id" value="{{ $student->id }}">
                              <input type="hidden" name="exam_id" value="{{ Request::get('exam_id') }}">
                              <input type="hidden" name="class_id" value="{{ Request::get('class_id') }}">
                              
                            <tr>
                              <td>{{ $student->name }} {{ $student->last_name }}</td>
                              @php
                              $i = 1;
                              $totalStudentMark = 0;
                              $totalFullMarks = 0;
                              $totalPassingMark = 0;
                              $pass_fail_vali = 0; 
                              @endphp
                              @foreach($getSubject as $subject)

                                @php
                                    $totalMark = 0;
                                    $totalFullMarks = $totalFullMarks + $subject->full_marks;
                                    $totalPassingMark = $totalPassingMark + $subject->passing_mark;
                                    

                                    $getMark = $subject->getMark($student->id, Request::get('exam_id'), Request::get('class_id'), $subject->subject_id);

                                    if(!empty($getMark))
                                    {
                                        $totalMark = $getMark->class_work + $getMark->home_work + $getMark->test_work + $getMark->exam;
                                    }

                                    $totalStudentMark = $totalStudentMark+$totalMark;
                                @endphp

                                <td>
                                  <div style="margin-bottom: 10px;">
                                      {{__('messages.class_work')}}
                                      
                                      <input type="hidden" name="mark[{{ $i }}][full_marks]" value="{{ $subject->full_marks }}">
                                      <input type="hidden" name="mark[{{ $i }}][passing_mark]" value="{{ $subject->passing_mark }}">

                                      <input type="hidden" name="mark[{{ $i }}][id]" value="{{ $subject->id }}">
                                      <input type="hidden" name="mark[{{ $i }}][subject_id]" value="{{ $subject->subject_id }}">
                                      <input type="text" name="mark[{{ $i }}][class_work]" id="class_work_{{ $student->id }}{{ $subject->subject_id }}" style="width:200px;" placeholder="{{ __('messages.enter_marks') }}" value="{{ !empty($getMark->class_work) ? $getMark->class_work : ''  }}" class="form-control">
                                  </div>
                                  <div style="margin-bottom: 10px;">
                                      {{__('messages.home_work')}}
                                      <input type="text" id="home_work_{{ $student->id }}{{ $subject->subject_id }}" name="mark[{{ $i }}][home_work]" style="width:200px;" placeholder="{{ __('messages.enter_marks') }}" value="{{ !empty($getMark->home_work) ? $getMark->home_work : ''  }}" class="form-control">
                                  </div>

                                  <div style="margin-bottom: 10px;">
                                      {{__('messages.test_work')}}
                                      <input type="text" id="test_work_{{ $student->id }}{{ $subject->subject_id }}" name="mark[{{ $i }}][test_work]" style="width:200px;" placeholder="{{ __('messages.enter_marks') }}" value="{{ !empty($getMark->test_work) ? $getMark->test_work : ''  }}" class="form-control">
                                  </div>

                                  <div style="margin-bottom: 10px;">
                                      {{__('messages.exam')}}
                                      <input type="text" id="exam_{{ $student->id }}{{ $subject->subject_id }}" name="mark[{{ $i }}][exam]" style="width:200px;" placeholder="{{ __('messages.enter_marks') }}" class="form-control" value="{{ !empty($getMark->exam) ? $getMark->exam : ''  }}">
                                  </div>

                                  <div style="margin-bottom: 10px;">
                                    <button type="button" class="btn btn-primary SaveSingleSubject" id="{{ $student->id }}" data-val="{{ $subject->subject_id }}" data-exam="{{ Request::get('exam_id') }}" data-schedule="{{ $subject->id }}" data-class="{{ Request::get('class_id') }}">{{ __('messages.save') }}</button>
                                  </div>

                                  @if(!empty($getMark))
                                    <div style="margin-bottom: 10px;">

                                      @php
                                          $getLoopGrade = App\Models\MarksGradeModel::getGrade($totalMark);
                                      @endphp

                                      <b>{{__('messages.total_mark')}} :</b> {{ $totalMark }} <br />
                                      <b>{{__('messages.passing_mark')}} :</b> {{ $subject->passing_mark }} <br />
                                      @if(!empty($getLoopGrade))
                                         <b>{{__('messages.grade')}} :</b> {{ $getLoopGrade }} <br />
                                      @endif
                                      @if($totalMark >= $subject->passing_mark)
                                        {{__('messages.result')}} : <span style="color:green; font-weight: bold;">{{__('messages.pass')}}</span>
                                      @else
                                        {{__('messages.result')}} : <span style="color:red; font-weight: bold;">{{__('messages.fail')}}</span>
                                        @php
                                          $pass_fail_vali = 1;
                                        @endphp
                                      @endif
                                    </div>
                                  @endif
                                    

                                </td>
                              @php
                                $i++;
                              @endphp
                              @endforeach
                              <td style="min-width: 250px;">
                                <button type="submit" class="btn btn-success">{{__('messages.save')}}</button>

                                <a class="btn btn-primary" target="_blank" href="{{ url('teacher/my_exam_result/print?exam_id='.Request::get('exam_id').'&student_id='.$student->id) }}">{{__('messages.print')}}</a>

                                @if(!empty($totalStudentMark))
                                    <br >
                                    <br >
                                    <b>{{__('messages.total_subject_mark')}} :</b> {{ $totalFullMarks }}
                                    <br >
                                    <b>{{__('messages.total_passing_mark')}} :</b> {{ $totalPassingMark }} 
                                    <br />
                                    <b>{{__('messages.total_student_mark')}} :</b> {{ $totalStudentMark }} 
                                    <br />
                                    @php
                                      $percentage = ($totalStudentMark * 100) / $totalFullMarks;
                                      $getGrade = App\Models\MarksGradeModel::getGrade($percentage);
                                    @endphp
                                    <br>
                                    <b>{{__('messages.percentage')}} :</b> {{ round($percentage,2) }}%
                                    <br>
                                     @if(!empty($getGrade))
                                    <b>{{__('messages.grade')}} :</b> {{ $getGrade }}
                                    <br>
                                    @endif
                                    @if($pass_fail_vali == 0)
                                      {{__('messages.result')}} : <span style="color:green; font-weight: bold;">{{__('messages.pass')}}</span>
                                    @else
                                      {{__('messages.result')}} : <span style="color:red; font-weight: bold;">{{__('messages.fail')}}</span>
                                    @endif
                                @endif
                              </td>
                            </tr>
                            </form>
                          @endforeach
                      @endif
                  </tbody>
                </table>
              </div>
            </div>
          @endif
         


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

@section('script').

<script type="text/javascript">
  $('.SubmitForm').submit(function(e) {
      e.preventDefault();
      $.ajax({
          type: "POST",
          url: "{{ url('teacher/submit_marks_register') }}",
          data : $(this).serialize(),
          dataType : "json",
          success: function(data) {
              alert(data.message);
          }
      });
  });


  $('.SaveSingleSubject').click(function(e) {
    var student_id = $(this).attr('id');
    var subject_id = $(this).attr('data-val');
    var exam_id = $(this).attr('data-exam');
    var class_id = $(this).attr('data-class');
    var id = $(this).attr('data-schedule');
    
    var class_work = $('#class_work_'+student_id+subject_id).val();
    var home_work = $('#home_work_'+student_id+subject_id).val();
    var test_work = $('#test_work_'+student_id+subject_id).val();
    var exam = $('#exam_'+student_id+subject_id).val();


    $.ajax({
          type: "POST",
          url: "{{ url('teacher/single_submit_marks_register') }}",
          data : {
             "_token": "{{ csrf_token() }}",
            id : id,
            student_id : student_id,
            subject_id : subject_id,
            exam_id : exam_id,
            class_id : class_id,
            class_work : class_work,
            home_work : home_work,
            test_work : test_work,
            exam : exam
          },
          dataType : "json",
          success: function(data) {
              alert(data.message);
          }
      });

  });
  
</script>

@endsection