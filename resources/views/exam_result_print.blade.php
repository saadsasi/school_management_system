<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{__('messages.Print_Exam_Result')}}</title>
	<style type="text/css">
		@page {
			size: 8.3in 11.7in;
		}
		@page {
			size: A4;
		}
		.margin-bottom
		{
			margin-bottom: 3px;
		}

		.table-bg {
			border-collapse: collapse;
			width: 100%;
			font-size: 15px;
			text-align: center;
		}
		.th {
			border: 1px solid #000;
			padding: 10px;
		}
		.td {
			border: 1px solid #000;
			padding: 3px;	
		}

		.text-container {
			text-align: left;
			padding-left: 5px;
		}

		@media print {
			@page {
				margin: 0px;
				margin-left: 20px;
				margin-right: 20px;
			}
		}
	</style>
</head>
<body>
		<div id="page">
				<table style="width: 100%; text-align: center;">
					<tr>
						<td width="5%"></td>
						<td width="15%"><img style="width: 110px;" src="{{ $getSetting->getLogo() }}"></td>
						<td align="left">
							<h1>{!! $getSetting->school_name !!}</h1>
						</td>
					</tr>
				</table>

				<table style="width: 100%;">
						<tr>
							<td width="5%"></td>
							<td width="70%">
								<table class="margin-bottom" style="width: 100%;">
									<tbody>
										<tr>
											<td width="27%">{{__('messages.name_of_the_student')}} : </td>
											<td style="border-bottom: 1px solid; width: 100%;">{{ $getStudent->name }} {{ $getStudent->last_name }}</td>
										</tr>
									</tbody>
								</table>

								<table class="margin-bottom" style="width: 100%;">
									<tbody>
										<tr>
											<td width="23%">{{__('messages.admission_number')}} : </td>
											<td style="border-bottom: 1px solid; width: 100%;">{{ $getStudent->admission_number }}</td>
										</tr>
									</tbody>
								</table>


								<table class="margin-bottom" style="width: 100%;">
									<tbody>
										<tr>
											<td width="23%">{{__('messages.class')}} : </td>
											<td style="border-bottom: 1px solid; width: 100%;">{{ $getClass->class_name }}</td>
										</tr>
									</tbody>
								</table>

								<table class="margin-bottom" style="width: 100%;">
									<tbody>
										<tr>
											
											<td width="11%">{{__('messages.term')}} : </td>
											<td style="border-bottom: 1px solid; width: 100%;">{{ $getExam->name }}</td>
										</tr>
									</tbody>
								</table>
							</td>
							<td width="5%"></td>
							<td width="20%" valign="top">
								<img src="{{ $getStudent->getProfileDirect() }}" style="border-radius: 6px;" height="100px" width="100px">
								<br>
								{{__('messages.gender')}} : {{ $getStudent->gender }}
							</td>
						</tr>
				</table>

				<br >
				<div>

						<table class="table-bg">
						   <thead>
						      <tr>
						         <th style="text-align: left;" class="th">{{__('messages.subject')}}</th>
						         <th class="th">{{__('messages.class_work')}}</th>
						         <th class="th">{{__('messages.test_work')}}</th>
						         <th class="th">{{__('messages.home_work')}}</th>
						         <th class="th">{{__('messages.exam')}}</th>
						         <th class="th">{{__('messages.total_score')}}</th>
						         <th class="th">{{__('messages.passing_marks')}}</th>
						         <th class="th">{{__('messages.full_marks')}}</th>
						         <th class="th">{{__('messages.result')}}</th>
						      </tr>
						   </thead>
				  <tbody>
                    @php
                      $total_score = 0;
                      $full_marks = 0;
                      $result_validation = 0;
                    @endphp
                    @foreach($getExamMark as $exam)
                        @php
                          $total_score = $total_score + $exam['total_score'];
                          $full_marks = $full_marks + $exam['full_marks'];
                        @endphp
                    <tr>
                      <td class="td" style="width: 300px; text-align: left;">{{ $exam['subject_name'] }}</td>
                      <td class="td">{{ $exam['class_work'] }}</td>
                      <td class="td">{{ $exam['test_work'] }}</td>
                      <td class="td">{{ $exam['home_work'] }}</td>
                      <td class="td">{{ $exam['exam'] }}</td>
                      <td class="td">{{ $exam['total_score'] }}</td>
                      <td class="td">{{ $exam['passing_mark'] }}</td>
                      <td class="td">{{ $exam['full_marks'] }}</td>
                      <td class="td">
                          @if($exam['total_score'] >= $exam['passing_mark'])
                            <span style="color: green; font-weight: bold;">{{__('messages.pass')}}</span>
                          @else
                            @php
                              $result_validation = 1;
                            @endphp
                            <span style="color: red; font-weight: bold;">{{__('messages.fail')}}</span>
                          @endif

                      </td>
                    </tr>
                    @endforeach

                    <tr>
                      <td class="td" colspan="2">
                        <b>{{__('messages.grand_total')}}: {{ $total_score }}/{{ $full_marks }}</b>
                      </td>
                      <td class="td" colspan="2">
                        @php
                          $percentage = ($total_score * 100) / $full_marks;
                          $getGrade = App\Models\MarksGradeModel::getGrade($percentage);
                        @endphp
                        <b>{{__('messages.percentage')}}: {{ round($percentage, 2) }}%</b>
                      </td>

                      <td class="td" colspan="2">
                        <b>{{__('messages.grade')}}: {{ $getGrade }}</b>
                      </td>
                      <td class="td" colspan="3">
                        <b>{{__('messages.result')}}:  @if($result_validation == 0) 
                                      <span style="color: green;">{{__('messages.pass')}}</span>  
                                    @else  
                                      <span style="color: red;">{{__('messages.fail')}}</span>
                                    @endif
                                  </b>
                      </td>
                    </tr>

                  </tbody>
						</table>

					
				</div>

				<div>
					<p>{{ $getSetting->exam_description }}</p>
				</div>

				<table class="margin-bottom" style="width: 100%;">
						<tbody>
							<tr>
								<td width="15%">{{__('messages.signature')}} : </td>
								<td style="border-bottom: 1px solid; width: 100%;"></td>
							</tr>
						</tbody>
				</table>
		</div>

		<script type="text/javascript">
			window.print();
		</script>
</body>
</html>