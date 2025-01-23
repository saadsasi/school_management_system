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
                                            <input type="number" class="form-control" name="height" value="{{ $getRecord->height }}" step="0.01">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ __('messages.weight') }} (kg):</label>
                                            <input type="number" class="form-control" name="weight" value="{{ $getRecord->weight }}" step="0.01">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ __('messages.blood_group') }}:</label>
                                            <select class="form-control" name="blood_group">
                                                <option value="">{{ __('messages.select') }}</option>
                                                <option {{ ($getRecord->blood_group == 'A+') ? 'selected' : '' }} value="A+">A+</option>
                                                <option {{ ($getRecord->blood_group == 'A-') ? 'selected' : '' }} value="A-">A-</option>
                                                <option {{ ($getRecord->blood_group == 'B+') ? 'selected' : '' }} value="B+">B+</option>
                                                <option {{ ($getRecord->blood_group == 'B-') ? 'selected' : '' }} value="B-">B-</option>
                                                <option {{ ($getRecord->blood_group == 'O+') ? 'selected' : '' }} value="O+">O+</option>
                                                <option {{ ($getRecord->blood_group == 'O-') ? 'selected' : '' }} value="O-">O-</option>
                                                <option {{ ($getRecord->blood_group == 'AB+') ? 'selected' : '' }} value="AB+">AB+</option>
                                                <option {{ ($getRecord->blood_group == 'AB-') ? 'selected' : '' }} value="AB-">AB-</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ __('messages.allergies') }}:</label>
                                            <textarea class="form-control" name="allergies" rows="3">{{ $getRecord->allergies }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ __('messages.medical_condition') }}:</label>
                                            <textarea class="form-control" name="medical_condition" rows="3">{{ $getRecord->medical_condition }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ __('messages.save_medical_info') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection