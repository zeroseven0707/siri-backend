@extends('admin.layout')

@section('title', 'Home Sections')
@section('page-title', 'Home Sections Management')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">All Home Sections</h2>
            <a href="{{ route('admin.home-sections.create') }}" class="btn btn-primary">
                <span>➕</span> Add New Section
            </a>
        </div>

        <!-- Search -->
        <form method="GET" style="padding: 0 1.5rem 1.5rem;">
            <div style="display: grid; grid-template-columns: 1fr 120px; gap: 1rem;">
                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Search sections..."
                    value="{{ request('search') }}"
                >
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sections as $section)
                        <tr>
                            <td><strong>{{ $section->order }}</strong></td>
                            <td>
                                <strong>{{ $section->title }}</strong>
                                @if($section->subtitle)
                                    <br><small style="color: var(--gray);">{{ $section->subtitle }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-primary">{{ ucfirst($section->type) }}</span>
                            </td>
                            <td>
                                @if($section->is_active)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $section->created_at->format('d M Y') }}</td>
                            <td>
                                <div style="display: flex; gap: 0.5rem;">
                                    <a href="{{ route('admin.home-sections.edit', $section) }}" class="btn btn-secondary btn-sm">Edit</a>
                                    <form action="{{ route('admin.home-sections.destroy', $section) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 2rem; color: #9CA3AF;">
                                No home sections found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($sections->hasPages())
            <div style="padding: 1.5rem;">
                {{ $sections->links() }}
            </div>
        @endif
    </div>
@endsection
