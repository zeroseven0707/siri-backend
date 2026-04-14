@extends('admin.layout')

@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')
    <div class="card" style="max-width: 600px;">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label" for="name">Full Name *</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="form-control"
                    value="{{ old('name', $user->name) }}"
                    required
                >
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Email Address *</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control"
                    value="{{ old('email', $user->email) }}"
                    required
                >
            </div>

            <div class="form-group">
                <label class="form-label" for="phone">Phone Number</label>
                <input
                    type="text"
                    id="phone"
                    name="phone"
                    class="form-control"
                    value="{{ old('phone', $user->phone) }}"
                    placeholder="+62"
                >
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    placeholder="Leave blank to keep current password"
                >
            </div>

            <div class="form-group">
                <label class="form-label" for="role">Role *</label>
                <select id="role" name="role" class="form-control" required>
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
                    <option value="driver" {{ old('role', $user->role) === 'driver' ? 'selected' : '' }}>Driver</option>
                </select>
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary">Update User</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
