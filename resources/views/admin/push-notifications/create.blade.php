@extends('admin.layout')

@section('title', 'Send Push Notification')
@section('page-title', 'Send New Push Notification')

@section('content')
    <div class="card" style="max-width: 700px;">
        <form action="{{ route('admin.push-notifications.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label" for="title">Title *</label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    class="form-control"
                    value="{{ old('title') }}"
                    placeholder="e.g., New Promo Available!"
                    required
                >
            </div>

            <div class="form-group">
                <label class="form-label" for="body">Message *</label>
                <textarea
                    id="body"
                    name="body"
                    class="form-control"
                    rows="4"
                    placeholder="Enter notification message..."
                    required
                >{{ old('body') }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label" for="target">Send To *</label>
                <select id="target" name="target" class="form-control" required>
                    <option value="">Select Target</option>
                    <option value="all" {{ old('target') === 'all' ? 'selected' : '' }}>All Users</option>
                    <option value="users" {{ old('target') === 'users' ? 'selected' : '' }}>Customers Only</option>
                    <option value="drivers" {{ old('target') === 'drivers' ? 'selected' : '' }}>Drivers Only</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="scheduled_at">Schedule For (Optional)</label>
                <input
                    type="datetime-local"
                    id="scheduled_at"
                    name="scheduled_at"
                    class="form-control"
                    value="{{ old('scheduled_at') }}"
                >
                <small style="color: var(--gray); font-size: 0.8125rem;">Leave empty to send immediately</small>
            </div>

            <div style="padding: 1rem; background: var(--light); border-radius: 8px; margin-bottom: 1.5rem;">
                <strong style="display: block; margin-bottom: 0.5rem;">Preview:</strong>
                <div style="background: white; padding: 1rem; border-radius: 8px; border-left: 3px solid var(--primary);">
                    <div style="font-weight: 600; margin-bottom: 0.25rem;" id="preview-title">Notification Title</div>
                    <div style="color: var(--gray); font-size: 0.875rem;" id="preview-body">Notification message will appear here...</div>
                </div>
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary">Send Notification</button>
                <a href="{{ route('admin.push-notifications.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    // Live preview
    document.getElementById('title').addEventListener('input', function(e) {
        document.getElementById('preview-title').textContent = e.target.value || 'Notification Title';
    });

    document.getElementById('body').addEventListener('input', function(e) {
        document.getElementById('preview-body').textContent = e.target.value || 'Notification message will appear here...';
    });
</script>
@endpush
