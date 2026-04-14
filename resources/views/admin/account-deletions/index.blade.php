@extends('admin.layout')

@section('title', 'Account Deletion Requests')
@section('page-title', 'Account Deletion Requests')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Account Deletion Requests</h2>
        </div>

        <form method="GET" style="padding: 0 1.5rem 1.5rem;">
            <div style="display: grid; grid-template-columns: 1fr 120px; gap: 1rem;">
                <select name="status" class="form-control">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
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
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Requested</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $request)
                        <tr>
                            <td><strong>#{{ $request->id }}</strong></td>
                            <td>
                                <strong>{{ $request->user->name ?? 'Deleted User' }}</strong>
                                <br><small style="color: var(--gray);">{{ $request->user->email ?? '-' }}</small>
                            </td>
                            <td>{{ Str::limit($request->reason, 50) }}</td>
                            <td>
                                @if($request->status === 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($request->status === 'approved')
                                    <span class="badge badge-success">Approved</span>
                                @else
                                    <span class="badge badge-danger">Rejected</span>
                                @endif
                            </td>
                            <td>{{ $request->created_at->format('d M Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.account-deletions.show', $request) }}" class="btn btn-secondary btn-sm">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 2rem; color: #9CA3AF;">No deletion requests found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($requests->hasPages())
            <div style="padding: 1.5rem;">{{ $requests->links() }}</div>
        @endif
    </div>
@endsection
