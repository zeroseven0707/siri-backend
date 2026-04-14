@extends('admin.layout')

@section('title', 'Notification Details')
@section('page-title', 'Notification Details')

@section('content')
    <div class="card" style="max-width: 700px;">
        <div style="margin-bottom: 1.5rem;">
            <h3 style="font-size: 1.25rem; margin-bottom: 0.5rem;">{{ $pushNotification->title }}</h3>
            @if($pushNotification->status === 'sent')
                <span class="badge badge-success">Sent</span>
            @elseif($pushNotification->status === 'scheduled')
                <span class="badge badge-warning">Scheduled</span>
            @else
                <span class="badge badge-danger">Failed</span>
            @endif
        </div>

        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <div>
                <div style="font-size: 0.875rem; color: var(--gray); margin-bottom: 0.5rem;">Message</div>
                <div style="padding: 1rem; background: var(--light); border-radius: 8px;">
                    {{ $pushNotification->body }}
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div>
                    <div style="font-size: 0.875rem; color: var(--gray); margin-bottom: 0.5rem;">Target Audience</div>
                    <div style="font-weight: 600;">
                        <span class="badge badge-primary">{{ ucfirst($pushNotification->target) }}</span>
                    </div>
                </div>

                <div>
                    <div style="font-size: 0.875rem; color: var(--gray); margin-bottom: 0.5rem;">Recipients</div>
                    <div style="font-weight: 600;">{{ number_format($pushNotification->sent_count ?? 0) }} users</div>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div>
                    <div style="font-size: 0.875rem; color: var(--gray); margin-bottom: 0.5rem;">Created At</div>
                    <div>{{ $pushNotification->created_at->format('d M Y H:i') }}</div>
                </div>

                <div>
                    <div style="font-size: 0.875rem; color: var(--gray); margin-bottom: 0.5rem;">
                        @if($pushNotification->status === 'scheduled')
                            Scheduled For
                        @else
                            Sent At
                        @endif
                    </div>
                    <div>
                        @if($pushNotification->sent_at)
                            {{ $pushNotification->sent_at->format('d M Y H:i') }}
                        @elseif($pushNotification->scheduled_at)
                            {{ $pushNotification->scheduled_at->format('d M Y H:i') }}
                        @else
                            -
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border);">
            <a href="{{ route('admin.push-notifications.index') }}" class="btn btn-secondary">← Back to Notifications</a>
        </div>
    </div>
@endsection
