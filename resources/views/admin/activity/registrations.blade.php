@extends('layouts.app')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('messages.activity_registrations') }}</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            @include('_message')
            
            <!-- Stats Boxes -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $registrations->count() }}</h3>
                            <p>{{ __('messages.total_registrations') }}</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $registrations->where('status', 'approved')->count() }}</h3>
                            <p>{{ __('messages.approved_registrations') }}</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $registrations->where('status', 'pending')->count() }}</h3>
                            <p>{{ __('messages.pending_approval') }}</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Registrations List -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('messages.registrations_list') }}</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="{{ __('messages.search') }}...">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('messages.activity_name') }}</th>
                                <th>{{ __('messages.student') }}</th>
                                <th>{{ __('messages.registration_date') }}</th>
                                <th>{{ __('messages.status') }}</th>
                                <th>{{ __('messages.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($registrations as $registration)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $registration->activity->name ?? 'غير متوفر' }}</td>
                                <td>{{ $registration->student->name ?? 'غير متوفر' }}</td>
                                <td>{{ date('Y/m/d', strtotime($registration->created_at)) }}</td>
                                <td>
                                    @if($registration->status == 'pending')
                                        <span class="badge badge-warning">{{ __('messages.pending_review') }}</span>
                                    @elseif($registration->status == 'approved')
                                        <span class="badge badge-success">{{ __('messages.approved') }}</span>
                                    @elseif($registration->status == 'rejected')
                                        <span class="badge badge-danger">{{ __('messages.rejected') }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($registration->status == 'pending')
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-success approve-btn" data-id="{{ $registration->id }}">
                                            <i class="fas fa-check"></i> {{ __('messages.approve') }}
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger reject-btn" data-id="{{ $registration->id }}">
                                            <i class="fas fa-times"></i> {{ __('messages.reject') }}
                                        </button>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">{{ __('messages.no_registrations') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($registrations->hasPages())
                <div class="card-footer clearfix">
                    {{ $registrations->links() }}
                </div>
                @endif
            </div>
        </div>
    </section>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    function updateRegistrationStatus(id, status) {
        $.ajax({
            url: "{{ url('admin/activity/registration/update-status') }}/" + id,
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                status: status
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert(response.message || 'حدث خطأ ما');
                }
            },
            error: function() {
                alert('حدث خطأ ما');
            }
        });
    }

    $('.approve-btn').click(function() {
        if (confirm('هل أنت متأكد من قبول هذا التسجيل؟')) {
            updateRegistrationStatus($(this).data('id'), 'approved');
        }
    });

    $('.reject-btn').click(function() {
        if (confirm('هل أنت متأكد من رفض هذا التسجيل؟')) {
            updateRegistrationStatus($(this).data('id'), 'rejected');
        }
    });
});
</script>
@endpush