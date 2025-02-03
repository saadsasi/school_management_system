@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">تقرير الامتحانات - {{ $class->name }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-sm-left">
                            <a href="{{ route('reports.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-right ml-2"></i>رجوع
                            </a>
                            <button onclick="window.print()" class="btn btn-primary">
                                <i class="fas fa-print ml-2"></i>طباعة
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            @if ($reportType == 'results')
                                نتائج الامتحانات
                            @elseif($reportType == 'analysis')
                                تحليل الأداء
                            @else
                                مقارنة النتائج
                            @endif
                        </h3>
                    </div>
                    <div class="card-body">
                        @if ($reportType == 'results')
                            @foreach ($data as $examName => $results)
                                <h4 class="mt-4">{{ $examName }}</h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>اسم الطالب</th>
                                                <th>الدرجة</th>
                                                <th>الدرجة الكاملة</th>
                                                <th>النسبة</th>
                                                <th>التقدير</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($results as $result)
                                                <tr>
                                                    <td>{{ $result->student_name }}</td>
                                                    <td>{{ $result->marks }}</td>
                                                    <td>{{ $result->total_marks }}</td>
                                                    <td>
                                                        @php
                                                            $percentage = ($result->marks / $result->total_marks) * 100;
                                                        @endphp
                                                        {{ number_format($percentage, 2) }}%
                                                    </td>
                                                    <td>
                                                        @if ($percentage >= 90)
                                                            <span class="badge badge-success">ممتاز</span>
                                                        @elseif($percentage >= 80)
                                                            <span class="badge badge-info">جيد جداً</span>
                                                        @elseif($percentage >= 70)
                                                            <span class="badge badge-primary">جيد</span>
                                                        @elseif($percentage >= 60)
                                                            <span class="badge badge-warning">مقبول</span>
                                                        @else
                                                            <span class="badge badge-danger">راسب</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endforeach
                        @elseif($reportType == 'analysis')
                            <div class="row">
                                @foreach ($data as $exam)
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>{{ $exam->exam_name }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th>متوسط الدرجات</th>
                                                            <td>{{ number_format($exam->average_marks, 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>أعلى درجة</th>
                                                            <td>{{ $exam->highest_marks }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>أدنى درجة</th>
                                                            <td>{{ $exam->lowest_marks }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>عدد الطلاب</th>
                                                            <td>{{ $exam->total_students }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>عدد الناجحين</th>
                                                            <td>{{ $exam->passed_students }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>نسبة النجاح</th>
                                                            <td>
                                                                @php
                                                                    $passPercentage =
                                                                        ($exam->passed_students /
                                                                            $exam->total_students) *
                                                                        100;
                                                                @endphp
                                                                {{ number_format($passPercentage, 2) }}%
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="mt-4">
                                                    <canvas id="chart-{{ str_replace(' ', '-', $exam->exam_name) }}"
                                                        height="200"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>اسم الطالب</th>
                                            @foreach ($data as $exam)
                                                <th>{{ $exam->exam_name }}</th>
                                            @endforeach
                                            <th>المتوسط</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $studentName => $exams)
                                            <tr>
                                                <td>{{ $studentName }}</td>
                                                @php
                                                    $total = 0;
                                                    $count = 0;
                                                @endphp
                                                @foreach ($exams as $exam)
                                                    <td>{{ $exam->marks }}</td>
                                                    @php
                                                        $total += $exam->marks;
                                                        $count++;
                                                    @endphp
                                                @endforeach
                                                <td>{{ $count > 0 ? number_format($total / $count, 2) : 0 }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                <canvas id="comparison-chart" height="200"></canvas>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @if ($reportType == 'analysis' || $reportType == 'comparison')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            @if ($reportType == 'analysis')
                @foreach ($data as $exam)
                    new Chart(document.getElementById('chart-{{ str_replace(' ', '-', $exam->exam_name) }}').getContext(
                    '2d'), {
                        type: 'pie',
                        data: {
                            labels: ['ناجح', 'راسب'],
                            datasets: [{
                                data: [{{ $exam->passed_students }},
                                    {{ $exam->total_students - $exam->passed_students }}
                                ],
                                backgroundColor: ['#28a745', '#dc3545']
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }
                    });
                @endforeach
            @else
                new Chart(document.getElementById('comparison-chart').getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($data->first()->pluck('exam_name')) !!},
                        datasets: [
                            @foreach ($data as $studentName => $exams)
                                {
                                    label: '{{ $studentName }}',
                                    data: {{ json_encode($exams->pluck('marks')) }},
                                    fill: false,
                                    tension: 0.1
                                },
                            @endforeach
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            @endif
        </script>
    @endif
@endsection
