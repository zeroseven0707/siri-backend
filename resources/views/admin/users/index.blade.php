@extends('admin.layout')

@section('title', 'Users')
@section('page-title', 'Users Management')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="uil uil-estate"></i>Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Users</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0">
                <div class="card-header">
                    <h6 class="fw-500">All Users</h6>
                    <div class="card-extra">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-primary">
                            <i class="uil uil-plus"></i> Add New User
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filters -->
                    <form method="GET" class="mb-25">
                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <input
                                    type="text"
                                    name="search"
                                    class="form-control"
                                    placeholder="Search by name or email..."
                                    value="{{ request('search') }}"
                                >
                            </div>
                            <div class="col-md-3 mb-3">
                                <select name="role" class="form-control">
                                    <option value="">All Roles</option>
                                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
                                    <option value="driver" {{ request('role') === 'driver' ? 'selected' : '' }}>Driver</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="uil uil-filter"></i> Filter
                                </button>
                            </div>
                            <div class="col-md-2 mb-3">
                                <a href="{{ route('admin.users.index') }}" class="btn btn-light w-100">
                                    <i class="uil uil-redo"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr class="userDatatable-header">
                                    <th><span class="userDatatable-title">ID</span></th>
                                    <th><span class="userDatatable-title">Name</span></th>
                                    <th><span class="userDatatable-title">Email</span></th>
                                    <th><span class="userDatatable-title">Phone</span></th>
                                    <th><span class="userDatatable-title">Role</span></th>
                                    <th><span class="userDatatable-title">Joined</span></th>
                                    <th><span class="userDatatable-title text-end">Actions</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>
                                            <div class="userDatatable-content">
                                                {{ $user->id }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content d-flex align-items-center">
                                                <div class="userDatatable-inline-title">
                                                    <a href="{{ route('admin.users.edit', $user) }}" class="text-dark fw-500">
                                                        <h6>{{ $user->name }}</h6>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content">
                                                {{ $user->email }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content">
                                                {{ $user->phone ?? '-' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content">
                                                @if($user->role === 'admin')
                                                    <span class="badge badge-round badge-danger">
                                                        <i class="uil uil-shield-check"></i> Admin
                                                    </span>
                                                @elseif($user->role === 'driver')
                                                    <span class="badge badge-round badge-primary">
                                                        <i class="uil uil-car"></i> Driver
                                                    </span>
                                                @else
                                                    <span class="badge badge-round badge-success">
                                                        <i class="uil uil-user"></i> User
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content">
                                                {{ $user->created_at->format('d M Y') }}
                                            </div>
                                        </td>
                                        <td>
                                            <ul class="orderDatatable_actions mb-0 d-flex flex-wrap justify-content-end">
                                                <li>
                                                    <a href="{{ route('admin.users.edit', $user) }}" class="edit">
                                                        <i class="uil uil-edit"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="remove" style="background: none; border: none; cursor: pointer; color: #e85347;">
                                                            <i class="uil uil-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div class="dm-empty text-center">
                                                <div class="dm-empty__text">
                                                    <p class="mb-0">No users found</p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($users->hasPages())
                        <div class="d-flex justify-content-end pt-30">
                            {{ $users->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .orderDatatable_actions {
        display: flex;
        gap: 10px;
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .orderDatatable_actions .edit,
    .orderDatatable_actions .remove {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }
    .orderDatatable_actions .edit {
        background: rgba(1, 104, 250, 0.1);
        color: #0168fa;
    }
    .orderDatatable_actions .edit:hover {
        background: #0168fa;
        color: #fff;
    }
    .orderDatatable_actions .remove {
        background: rgba(232, 83, 71, 0.1);
        color: #e85347;
    }
    .orderDatatable_actions .remove:hover {
        background: #e85347;
        color: #fff;
    }
</style>
@endpush
