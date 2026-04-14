@extends('admin.layout')

@section('title', 'Services')
@section('page-title', 'Services Management')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">All Services</h2>
            <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
                <span>➕</span> Add New Service
            </a>
        </div>

        <form method="GET" style="padding: 0 1.5rem 1.5rem;">
            <div style="display: grid; grid-template-columns: 1fr 120px; gap: 1rem;">
                <input type="text" name="search" class="form-control" placeholder="Search services..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Base Price</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                        <tr>
                            <td>
                                <strong>{{ $service->name }}</strong>
                                @if($service->description)
                                    <br><small style="color: var(--gray);">{{ Str::limit($service->description, 50) }}</small>
                                @endif
                            </td>
                            <td><strong>Rp {{ number_format($service->base_price) }}</strong></td>
                            <td>
                                @if($service->is_active)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $service->created_at->format('d M Y') }}</td>
                            <td>
                                <div style="display: flex; gap: 0.5rem;">
                                    <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-secondary btn-sm">Edit</a>
                                    <form action="{{ route('admin.services.destroy', $service) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 2rem; color: #9CA3AF;">No services found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($services->hasPages())
            <div style="padding: 1.5rem;">{{ $services->links() }}</div>
        @endif
    </div>
@endsection
