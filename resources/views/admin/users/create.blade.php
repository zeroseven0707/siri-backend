@extends('admin.layout')

@section('title', 'Create User')
@section('page-title', 'Create New User')

@section('content')
    <div class="card" style="max-width: 600px;">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label" for="name">Full Name *</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="form-control"
                    value="{{ old('name') }}"
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
                    value="{{ old('email') }}"
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
                    value="{{ old('phone') }}"
                    placeholder="+62"
                >
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password *</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    required
                >
            </div>

            <div class="form-group">
                <label class="form-label" for="role">Role *</label>
                <select id="role" name="role" class="form-control" required>
                    <option value="">Select Role</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
                    <option value="driver" {{ old('role') === 'driver' ? 'selected' : '' }}>Driver</option>
                </select>
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary">Create User</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
