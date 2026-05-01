<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DriverProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.users.partials.table', compact('users'))->render(),
                'pagination' => view('admin.partials.pagination', compact('users'))->render(),
            ]);
        }

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'phone' => 'nullable|string',
            'role' => 'required|in:admin,user,driver',
            'vehicle_type' => 'required_if:role,driver|nullable|string',
            'license_plate' => 'required_if:role,driver|nullable|string',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        DB::transaction(function() use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'phone' => $validated['phone'],
                'role' => $validated['role'],
                'email_verified_at' => now(), // Auto verify for admin-created users
            ]);

            if ($validated['role'] === 'driver') {
                DriverProfile::create([
                    'user_id' => $user->id,
                    'vehicle_type' => $validated['vehicle_type'],
                    'license_plate' => $validated['license_plate'],
                    'is_active' => true,
                ]);
            }
        });

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully');
    }

    public function edit(User $user)
    {
        $user->load('driverProfile');
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8',
            'phone' => 'nullable|string',
            'role' => 'required|in:admin,user,driver',
            'vehicle_type' => 'required_if:role,driver|nullable|string',
            'license_plate' => 'required_if:role,driver|nullable|string',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        DB::transaction(function() use ($validated, $user) {
            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'role' => $validated['role'],
            ] + (isset($validated['password']) ? ['password' => $validated['password']] : []));

            if ($validated['role'] === 'driver') {
                DriverProfile::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'vehicle_type' => $validated['vehicle_type'],
                        'license_plate' => $validated['license_plate'],
                    ]
                );
            } else {
                // If role changed from driver to something else, we might want to delete profile
                // but usually better to keep it or just leave it alone. 
                // For now, let's just leave it or deactivate it.
            }
        });

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully');
    }
}
