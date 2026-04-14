@extends('admin.layout')

@section('title', 'Transactions')
@section('page-title', 'Transactions')

@section('content')
    <!-- Stats -->
    <div class="stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); margin-bottom: 2rem;">
        <div class="stat-card">
            <div class="stat-label">Total Amount</div>
            <div class="stat-value" style="font-size: 1.5rem; color: var(--primary);">Rp {{ number_format($stats['total_amount']) }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Pending</div>
            <div class="stat-value" style="font-size: 1.5rem; color: var(--warning);">{{ number_format($stats['pending_count']) }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Completed</div>
            <div class="stat-value" style="font-size: 1.5rem; color: var(--success);">{{ number_format($stats['completed_count']) }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Failed</div>
            <div class="stat-value" style="font-size: 1.5rem; color: var(--danger);">{{ number_format($stats['failed_count']) }}</div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">All Transactions</h2>
        </div>

        <form method="GET" style="padding: 0 1.5rem 1.5rem;">
            <div style="display: grid; grid-template-columns: 1fr 150px 150px 120px; gap: 1rem;">
                <input type="text" name="search" class="form-control" placeholder="Search by user..." value="{{ request('search') }}">
                <select name="type" class="form-control">
                    <option value="">All Types</option>
                    <option value="top_up" {{ request('type') === 'top_up' ? 'selected' : '' }}>Top Up</option>
                    <option value="payment" {{ request('type') === 'payment' ? 'selected' : '' }}>Payment</option>
                    <option value="refund" {{ request('type') === 'refund' ? 'selected' : '' }}>Refund</option>
                </select>
                <select name="status" class="form-control">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                        <tr>
                            <td><strong>#{{ $transaction->id }}</strong></td>
                            <td>{{ $transaction->user->name ?? 'N/A' }}</td>
                            <td><span class="badge badge-primary">{{ ucfirst(str_replace('_', ' ', $transaction->type)) }}</span></td>
                            <td><strong>Rp {{ number_format($transaction->amount) }}</strong></td>
                            <td>
                                @if($transaction->status === 'completed')
                                    <span class="badge badge-success">Completed</span>
                                @elseif($transaction->status === 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @else
                                    <span class="badge badge-danger">Failed</span>
                                @endif
                            </td>
                            <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.transactions.show', $transaction) }}" class="btn btn-secondary btn-sm">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 2rem; color: #9CA3AF;">No transactions found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($transactions->hasPages())
            <div style="padding: 1.5rem;">{{ $transactions->links() }}</div>
        @endif
    </div>
@endsection
