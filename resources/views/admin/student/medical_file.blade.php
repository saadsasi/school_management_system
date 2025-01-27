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
                            <div class="card-tools">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#medicalModal">
                                    {{ __('messages.add_edit_medical_info') }}
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            @if(!isset($healthRecord))
                                <div class="alert alert-info">
                                    {{ __('messages.no_medical_record') ?? 'No medical record found for this student.' }}
                                </div>
                            @else
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>{{ __('messages.height') }}:</strong> 
                                    {{ $healthRecord->height ?? '-' }} cm
                                </div>
                                <div class="col-md-6">
                                    <strong>{{ __('messages.weight') }}:</strong> 
                                    {{ $healthRecord->weight ?? '-' }} kg
                                </div>
                                <div class="col-md-6">
                                    <strong>{{ __('messages.blood_group') }}:</strong> 
                                    {{ $healthRecord->blood_group ?? '-' }}
                                </div>
                                <div class="col-md-6">
                                    <strong>{{ __('messages.vaccination_name') }}:</strong> 
                                    {{ $healthRecord->vaccination_name ?? '-' }}
                                </div>
                                <div class="col-md-6">
                                    <strong>{{ __('messages.vaccination_date') }}:</strong> 
                                    {{ !empty($healthRecord->vaccination_date) ? date('Y-m-d', strtotime($healthRecord->vaccination_date)) : '-' }}
                                </div>
                                <div class="col-md-6">
                                    <strong>{{ __('messages.allergy_type') }}:</strong> 
                                    {{ $healthRecord->allergy_type ?? '-' }}
                                </div>
                                <div class="col-md-6">
                                    <strong>{{ __('messages.allergy_severity') }}:</strong> 
                                    {{ $healthRecord->allergy_severity ?? '-' }}
                                </div>
                                <div class="col-md-6">
                                    <strong>{{ __('messages.disease_name') }}:</strong> 
                                    {{ $healthRecord->disease_name ?? '-' }}
                                </div>
                                <div class="col-md-6">
                                    <strong>{{ __('messages.disease_medications') }}:</strong> 
                                    {{ $healthRecord->disease_medications ?? '-' }}
                                </div>
                                <div class="col-md-12">
                                    <strong>{{ __('messages.medical_condition') }}:</strong> 
                                    {{ $healthRecord->medical_condition ?? '-' }}
                                </div>
                                <div class="col-md-12">
                                    <strong>{{ __('messages.notes') }}:</strong> 
                                    {{ $healthRecord->notes ?? '-' }}
                                </div>
                            </div>

                            @if($healthRecord && $healthRecord->visit_date)
                            <div class="mt-4">
                                <h4>{{ __('messages.last_medical_visit') }}</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>{{ __('messages.visit_date') }}:</strong> 
                                        {{ date('Y-m-d', strtotime($healthRecord->visit_date)) }}
                                    </div>
                                    <div class="col-md-6">
                                        <strong>{{ __('messages.visit_reason') }}:</strong> 
                                        {{ $healthRecord->visit_reason }}
                                    </div>
                                    <div class="col-md-6">
                                        <strong>{{ __('messages.visit_diagnosis') }}:</strong> 
                                        {{ $healthRecord->visit_diagnosis }}
                                    </div>
                                    <div class="col-md-6">
                                        <strong>{{ __('messages.visit_treatment') }}:</strong> 
                                        {{ $healthRecord->visit_treatment }}
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endif
                        </div>
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
                                            <th>{{ __('messages.vaccination_name') }}</th>
                                            <th>{{ __('messages.vaccination_date') }}</th>
                                            <th>{{ __('messages.allergy_type') }}</th>
                                            <th>{{ __('messages.allergy_severity') }}</th>
                                            <th>{{ __('messages.disease_name') }}</th>
                                            <th>{{ __('messages.disease_medications') }}</th>
                                            <th>{{ __('messages.visit_date') }}</th>
                                            <th>{{ __('messages.visit_reason') }}</th>
                                            <th>{{ __('messages.visit_diagnosis') }}</th>
                                            <th>{{ __('messages.visit_treatment') }}</th>
                                            <th>{{ __('messages.medical_condition') }}</th>
                                            <th>{{ __('messages.notes') }}</th>
                                            <th>{{ __('messages.created_by') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($getRecord->healthRecords()->orderBy('record_date', 'desc')->get() as $record)
                                        <tr>
                                            <td>{{ date('d-m-Y', strtotime($record->record_date)) }}</td>
                                            <td>{{ $record->height ? $record->height . ' cm' : '-' }}</td>
                                            <td>{{ $record->weight ? $record->weight . ' kg' : '-' }}</td>
                                            <td>{{ $record->blood_group ?? '-' }}</td>
                                            <td>{{ $record->vaccination_name ?? '-' }}</td>
                                            <td>{{ $record->vaccination_date ? date('d-m-Y', strtotime($record->vaccination_date)) : '-' }}</td>
                                            <td>{{ $record->allergy_type ?? '-' }}</td>
                                            <td>{{ $record->allergy_severity ?? '-' }}</td>
                                            <td>{{ $record->disease_name ?? '-' }}</td>
                                            <td>{{ $record->disease_medications ?? '-' }}</td>
                                            <td>{{ $record->visit_date ? date('d-m-Y', strtotime($record->visit_date)) : '-' }}</td>
                                            <td>{{ $record->visit_reason ?? '-' }}</td>
                                            <td>{{ $record->visit_diagnosis ?? '-' }}</td>
                                            <td>{{ $record->visit_treatment ?? '-' }}</td>
                                            <td>{{ $record->medical_condition ?? '-' }}</td>
                                            <td>{{ $record->notes ?? '-' }}</td>
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

<!-- Medical Info Modal -->
<div class="modal fade" id="medicalModal" tabindex="-1" role="dialog" aria-labelledby="medicalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="post" action="{{ url('admin/student/medical-file/'.$getRecord->id) }}">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" id="medicalModalLabel">{{ __('messages.medical_info') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
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
                                <label>{{ __('messages.vaccination_name') }}:</label>
                                <input type="text" class="form-control" name="vaccination_name" value="{{ $healthRecord->vaccination_name ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('messages.vaccination_date') }}:</label>
                                <input type="date" class="form-control" name="vaccination_date" value="{{ $healthRecord->vaccination_date ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('messages.allergy_type') }}:</label>
                                <input type="text" class="form-control" name="allergy_type" value="{{ $healthRecord->allergy_type ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('messages.allergy_severity') }}:</label>
                                <select class="form-control" name="allergy_severity">
                                    <option value="">{{ __('messages.select') }}</option>
                                    <option {{ ($healthRecord && $healthRecord->allergy_severity == 'mild') ? 'selected' : '' }} value="mild">{{ __('messages.mild') }}</option>
                                    <option {{ ($healthRecord && $healthRecord->allergy_severity == 'moderate') ? 'selected' : '' }} value="moderate">{{ __('messages.moderate') }}</option>
                                    <option {{ ($healthRecord && $healthRecord->allergy_severity == 'severe') ? 'selected' : '' }} value="severe">{{ __('messages.severe') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('messages.disease_name') }}:</label>
                                <input type="text" class="form-control" name="disease_name" value="{{ $healthRecord->disease_name ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('messages.disease_medications') }}:</label>
                                <input type="text" class="form-control" name="disease_medications" value="{{ $healthRecord->disease_medications ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('messages.visit_date') }}:</label>
                                <input type="date" class="form-control" name="visit_date" value="{{ $healthRecord->visit_date ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('messages.visit_reason') }}:</label>
                                <input type="text" class="form-control" name="visit_reason" value="{{ $healthRecord->visit_reason ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('messages.visit_diagnosis') }}:</label>
                                <input type="text" class="form-control" name="visit_diagnosis" value="{{ $healthRecord->visit_diagnosis ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('messages.visit_treatment') }}:</label>
                                <input type="text" class="form-control" name="visit_treatment" value="{{ $healthRecord->visit_treatment ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ __('messages.medical_condition') }}:</label>
                                <textarea class="form-control" name="medical_condition" rows="3">{{ $healthRecord->medical_condition ?? '' }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ __('messages.notes') }}:</label>
                                <textarea class="form-control" name="notes" rows="3">{{ $healthRecord->notes ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('messages.save_medical_info') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection