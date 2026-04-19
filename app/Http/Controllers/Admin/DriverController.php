<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('driverProfile')
            ->where('role', 'driver');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $drivers = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total'    => User::where('role', 'driver')->count(),
            'active'   => User::where('role', 'driver')->where('is_active', true)->count(),
            'inactive' => User::where('role', 'driver')->where('is_active', false)->count(),
        ];

        return view('admin.drivers.index', compact('drivers', 'stats'));
    }

    public function show(User $driver)
    {
        abort_if($driver->role !== 'driver', 404);
        $driver->load('driverProfile');

        $orders = Order::where('driver_id', $driver->id)
            ->with('user', 'service')
            ->latest()
            ->paginate(10);

        $earnings = Order::where('driver_id', $driver->id)
            ->where('status', 'completed')
            ->sum('delivery_fee');

        $completedCount = Order::where('driver_id', $driver->id)
            ->where('status', 'completed')
            ->count();

        return view('admin.drivers.show', compact('driver', 'orders', 'earnings', 'completedCount'));
    }

    public function toggleActive(User $driver)
    {
        abort_if($driver->role !== 'driver', 404);
        $driver->update(['is_active' => !$driver->is_active]);

        $status = $driver->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "Driver {$driver->name} berhasil {$status}.");
    }

    public function destroy(User $driver)
    {
        abort_if($driver->role !== 'driver', 404);
        $driver->delete();
        return redirect()->route('admin.drivers.index')->with('success', 'Driver berhasil dihapus.');
    }
}
