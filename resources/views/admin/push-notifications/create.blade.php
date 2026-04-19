@extends('admin.layout')
@section('title', 'Send Push Notification')
@section('page-title', 'Send Push Notification')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="uil uil-estate"></i>Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.push-notifications.index') }}">Push Notifications</a></li>
        <li class="breadcrumb-item active">Create</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h6 class="fw-500"><i class="uil uil-bell me-2"></i>Send New Push Notification</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.push-notifications.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-20">
                        <label class="color-dark fs-14 fw-500 align-center mb-10" for="title">Title <span class="color-danger">*</span></label>
                        <input type="text" id="notif-title" name="title" class="form-control" value="{{ old('title') }}" placeholder="e.g., New Promo Available!" required>
                    </div>
                    <div class="form-group mb-20">
                        <label class="color-dark fs-14 fw-500 align-center mb-10" for="body">Message <span class="color-danger">*</span></label>
                        <textarea id="notif-body" name="body" class="form-control" rows="4" placeholder="Enter notification message..." required>{{ old('body') }}</textarea>
                    </div>
                    <div class="form-group mb-20">
                        <label class="color-dark fs-14 fw-500 align-center mb-10" for="target">Send To <span class="color-danger">*</span></label>
                        <select id="target" name="target" class="form-control" required>
                            <option value="">Select Target</option>
                            <option value="all" {{ old('target') === 'all' ? 'selected' : '' }}>All Users</option>
                            <option value="users" {{ old('target') === 'users' ? 'selected' : '' }}>Customers Only</option>
                            <option value="drivers" {{ old('target') === 'drivers' ? 'selected' : '' }}>Drivers Only</option>
                        </select>
                    </div>
                    <div class="form-group mb-20">
                        <label class="color-dark fs-14 fw-500 align-center mb-10" for="scheduled_at">Schedule For (Optional)</label>
                        <input type="datetime-local" id="scheduled_at" name="scheduled_at" class="form-control" value="{{ old('scheduled_at') }}">
                        <small class="fs-12 color-light mt-5 d-block">Leave empty to send immediately</small>
                    </div>
                    <div class="button-group d-flex pt-25">
                        <button type="submit" class="btn btn-primary btn-default btn-squared text-capitalize">
                            <i class="uil uil-message me-1"></i> Send Notification
                        </button>
                        <a href="{{ route('admin.push-notifications.index') }}" class="btn btn-light btn-default btn-squared text-capitalize ms-15">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="fw-500"><i class="uil uil-eye me-2"></i>Live Preview</h6>
            </div>
            <div class="card-body">
                <div class="p-15" style="background: #f8f9fa; border-radius: 12px;">
                    <div class="d-flex align-items-center mb-10">
                        <div style="width:36px; height:36px; border-radius:8px; background: linear-gradient(135deg, #22C55E, #16A34A); display:flex; align-items:center; justify-content:center; margin-right:10px;">
                            <i class="uil uil-bell" style="color:white; font-size:18px;"></i>
                        </div>
                        <div>
                            <div class="fs-12 color-light">SIRI App</div>
                            <div class="fs-12 color-light">now</div>
                        </div>
                    </div>
                    <div class="fw-500 color-dark fs-14 mb-5" id="preview-title">Notification Title</div>
                    <div class="fs-13 color-light" id="preview-body">Notification message will appear here...</div>
                </div>
                <div class="mt-20">
                    <p class="fs-13 color-light">This is how your notification will appear on users' devices.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('notif-title').addEventListener('input', function(e) {
        document.getElementById('preview-title').textContent = e.target.value || 'Notification Title';
    });
    document.getElementById('notif-body').addEventListener('input', function(e) {
        document.getElementById('preview-body').textContent = e.target.value || 'Notification message will appear here...';
    });
</script>
@endpush
