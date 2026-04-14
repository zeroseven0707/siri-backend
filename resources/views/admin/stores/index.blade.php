@extends('admin.layout')

@section('title', 'Stores')
@section('page-title', 'Stores Management')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">All Stores</h2>
            <a href="{{ route('admin.stores.create') }}" class="btn btn-primary">
                <span>➕</span> Add New Store
            </a>
        </div>

        <!-- Search -->
        <form method="GET" style="padding: 0 1.5rem 1.5rem;">
            <div style="display: grid; grid-template-columns: 1fr 120px; gap: 1rem;">
                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Search stores..."
                    value="{{ request('search') }}"
                >
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stores as $store)
                        <tr>
                            <td>{{ $store->id }}</td>
                            <td><strong>{{ $store->name }}</strong></td>
                            <td>{{ Str::limit($store->address, 40) }}</td>
                            <td>{{ $store->phone }}</td>
                            <td>
                                @if($store->is_open)
                                    <span class="badge badge-success">Open</span>
                                @else
                                    <span class="badge badge-danger">Closed</span>
                                @endif
                            </td>
                            <td>{{ $store->created_at->format('d M Y') }}</td>
                            <td>
                                <div style="display: flex; gap: 0.5rem;">
                                    <a href="{{ route('admin.stores.edit', $store) }}" class="btn btn-secondary btn-sm">Edit</a>
                                    <form action="{{ route('admin.stores.destroy', $store) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 2rem; color: #9CA3AF;">
                                No stores found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($stores->hasPages())
            <div style="padding: 1.5rem;">
                {{ $stores->links() }}
            </div>
        @endif
    </div>
@endsection
