@extends('admin.layout')

@section('title', 'Account Deletion Request')
@section('page-title', 'Account Deletion Request Details')

@section('content')
    <div class="card" style="max-width: 700px;">
        <div style="margin-bottom: 1.5rem;">
            <h3 style="font-size: 1.25rem; margin-bottom: 0.5rem;">Request #{{ $accountDeletion->id }}</h3>
            @if($accountDeletion->status === 'pending')
                <span class="badge badge-warning">Pending</span>
            @elseif($accountDeletion->status === 'approved')
                <span class="badge badge-success">Approved</span>
            @else
                <span class="badge badge-danger">Rejected</span>
            @endif
        </div>

        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <div>
                <div style="font-size: 0.875rem; color: var(--gray); margin-bottom: 0.5rem;">User Information</div>
                <div style="padding: 1rem; background: var(--light); border-radius: 8px;">
                    <div style="font-weight: 600; margin-bottom: 0.25rem;">{{ $accountDeletion->user->name ?? 'Deleted User' }}</div>
                    <div style="font-size: 0.875rem; color: var(--gray);">{{ $accountDeletion->user->email ?? '-' }}</div>
                    @if($accountDeletion->user)
                        <div style="font-size: 0.875rem; color: var(--gray);">Phone: {{ $accountDeletion->user->phone ?? '-' }}</div>
                    @endif
                </div>
            </div>

            <div>
                <div style="font-size: 0.875rem; color: var(--gray); margin-bottom: 0.5rem;">Deletion Reason</div>
                <div style="padding: 1rem; background: var(--light); border-radius: 8px;">
                    {{ $accountDeletion->reason }}
                </div>
            </div>

            @if($accountDeletion->rejection_reason)
                <div>
                    <div style="font-size: 0.875rem; color: var(--gray); margin-bottom: 0.5rem;">Rejection Reason</div>
                    <div style="padding: 1rem; background: rgba(239, 68, 68, 0.1); border-radius: 8px; color: var(--danger);">
                        {{ $accountDeletion->rejection_reason }}
                    </div>
                </div>
            @endif

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div>
                    <div style="font-size: 0.875rem; color: var(--gray); margin-bottom: 0.5rem;">Requested At</div>
                    <div>{{ $accountDeletion->created_at->format('d M Y H:i') }}</div>
                </div>
                @if($accountDeletion->processed_at)
                    <div>
                        <div style="font-size: 0.875rem; color: var(--gray); margin-bottom: 0.5rem;">Processed At</div>
                        <div>{{ $accountDeletion->processed_at->format('d M Y H:i') }}</div>
                    </div>
                @endif
            </div>
        </div>

        @if($accountDeletion->status === 'pending')
            <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border);">
                <div style="display: flex; gap: 1rem;">
                    <form action="{{ route('admin.account-deletions.approve', $accountDeletion) }}" method="POST" onsubmit="return confirm('Are you sure you want to approve this deletion? The user account will be permanently deleted.')">
                        @csrf
                        <button type="submit" class="btn btn-primary">✅ Approve Deletion</button>
                    </form>

                    <button type="button" class="btn btn-danger" onclick="document.getElementById('reject-form').style.display='block'">
                        ❌ Reject Request
                    </button>
                </div>

                <div id="reject-form" style="display: none; margin-top: 1.5rem; padding: 1.5rem; background: var(--light); border-radius: 8px;">
                    <form action="{{ route('admin.account-deletions.reject', $accountDeletion) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="form-label" for="rejection_reason">Rejection Reason *</label>
                            <textarea
                                id="rejection_reason"
                                name="rejection_reason"
                                class="form-control"
                                rows="3"
                                placeholder="Explain why this request is being rejected..."
                                required
                            ></textarea>
                        </div>
                        <div style="display: flex; gap: 1rem;">
                            <button type="submit" class="btn btn-danger">Submit Rejection</button>
                            <button type="button" class="btn btn-secondary" onclick="document.getElementById('reject-form').style.display='none'">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border);">
            <a href="{{ route('admin.account-deletions.index') }}" class="btn btn-secondary">← Back to Requests</a>
        </div>
    </div>
@endsection
