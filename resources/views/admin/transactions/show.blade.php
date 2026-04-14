@extends('admin.layout')

@section('title', 'Transaction Details')
@section('page-title', 'Transaction Details')

@section('content')
    <div class="card" style="max-width: 700px;">
        <div style="margin-bottom: 1.5rem;">
            <h3 style="font-size: 1.25rem; margin-bottom: 0.5rem;">Transaction #{{ $transaction->id }}</h3>
            @if($transaction->status === 'completed')
                <span class="badge badge-success">Completed</span>
            @elseif($transaction->status === 'pending')
                <span class="badge badge-warning">Pending</span>
            @else
                <span class="badge badge-danger">Failed</span>
            @endif
        </div>

        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div>
                    <div style="font-size: 0.875rem; color: var(--gray); margin-bottom: 0.5rem;">User</div>
                    <div style="font-weight: 600;">{{ $transaction->user->name }}</div>
                    <div style="font-size: 0.875rem; color: var(--gray);">{{ $transaction->user->email }}</div>
                </div>
                <div>
                    <div style="font-size: 0.875rem; color: var(--gray); margin-bottom: 0.5rem;">Type</div>
                    <div><span class="badge badge-primary">{{ ucfirst(str_replace('_', ' ', $transaction->type)) }}</span></div>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div>
                    <div style="font-size: 0.875rem; color: var(--gray); margin-bottom: 0.5rem;">Amount</div>
                    <div style="font-size: 1.5rem; font-weight: 700; color: var(--primary);">Rp {{ number_format($transaction->amount) }}</div>
                </div>
                <div>
                    <div style="font-size: 0.875rem; color: var(--gray); margin-bottom: 0.5rem;">Payment Method</div>
                    <div style="font-weight: 600;">{{ $transaction->payment_method ?? '-' }}</div>
                </div>
            </div>

            @if($transaction->description)
                <div>
                    <div style="font-size: 0.875rem; color: var(--gray); margin-bottom: 0.5rem;">Description</div>
                    <div style="padding: 1rem; background: var(--light); border-radius: 8px;">{{ $transaction->description }}</div>
                </div>
            @endif

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div>
                    <div style="font-size: 0.875rem; color: var(--gray); margin-bottom: 0.5rem;">Created At</div>
                    <div>{{ $transaction->created_at->format('d M Y H:i:s') }}</div>
                </div>
                <div>
                    <div style="font-size: 0.875rem; color: var(--gray); margin-bottom: 0.5rem;">Updated At</div>
                    <div>{{ $transaction->updated_at->format('d M Y H:i:s') }}</div>
                </div>
            </div>
        </div>

        <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border);">
            <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">← Back to Transactions</a>
        </div>
    </div>
@endsection
