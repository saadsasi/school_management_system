@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('messages.medical_info') }}</h1>
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
                            <h3 class="card-title">{{ $getRecord->name }} {{ $getRecord->last_name }}</h3>
                        </div>
                        <form method="post" action="{{ url('admin/student/medical-file/'.$getRecord->id) }}">
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ __('messages.height') }} (cm):</label>
                                            <input type="number" class="form-control" name="height" value="{{ $healthRecord->height ?? '' }}" step="0.01">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ __('messages.weight') }} (kg):</label>
                                            <input type="number" class="form-control" name="weight" value="{{ $healthRecord->weight ?? '' }}" step="0.01">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ __('messages.blood_group') }}:</label>
                                            <select class="form-control" name="blood_group">
                                                <option value="">{{ __('messages.select') }}</option>
                                                <option {{ ($healthRecord && $healthRecord->blood_group == 'A+') ? 'selected' : '' }} value="A+">A+</option>
                                                <option {{ ($healthRecord && $healthRecord->blood_group == 'A-') ? 'selected' : '' }} value="A-">A-</option>
                                                <option {{ ($healthRecord && $healthRecord->blood_group == 'B+') ? 'selected' : '' }} value="B+">B+</option>
                                                <option {{ ($healthRecord && $healthRecord->blood_group == 'B-') ? 'selected' : '' }} value="B-">B-</option>
                                                <option {{ ($healthRecord && $healthRecord->blood_group == 'O+') ? 'selected' : '' }} value="O+">O+</option>
                                                <option {{ ($healthRecord && $healthRecord->blood_group == 'O-') ? 'selected' : '' }} value="O-">O-</option>
                                                <option {{ ($healthRecord && $healthRecord->blood_group == 'AB+') ? 'selected' : '' }} value="AB+">AB+</option>
                                                <option {{ ($healthRecord && $healthRecord->blood_group == 'AB-') ? 'selected' : '' }} value="AB-">AB-</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ __('messages.allergies') }}:</label>
                                            <textarea class="form-control" name="allergies" rows="3">{{ $healthRecord->allergies ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ __('messages.medical_condition') }}:</label>
                                            <textarea class="form-control" name="medical_condition" rows="3">{{ $healthRecord->medical_condition ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ __('messages.save_medical_info') }}</button>
                            </div>
                        </form>
                    </div>

                    @if($getRecord->healthRecords->count() > 0)
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('messages.medical_history') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>{{ __('messages.record_date') }}</th>
                                            <th>{{ __('messages.height') }}</th>
                                            <th>{{ __('messages.weight') }}</th>
                                            <th>{{ __('messages.blood_group') }}</th>
                                            <th>{{ __('messages.created_by') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($getRecord->healthRecords()->orderBy('record_date', 'desc')->get() as $record)
                                        <tr>
                                            <td>{{ date('d-m-Y', strtotime($record->record_date)) }}</td>
                                            <td>{{ $record->height }} cm</td>
                                            <td>{{ $record->weight }} kg</td>
                                            <td>{{ $record->blood_group }}</td>
                                            <td>{{ $record->creator->name }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
@endsection