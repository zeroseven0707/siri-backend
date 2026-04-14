<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => \App\Models\User::count(),
            'total_orders' => \App\Models\Order::count(),
            'total_stores' => \App\Models\Store::count(),
            'total_revenue' => \App\Models\Transaction::sum('amount'),
            'pending_orders' => \App\Models\Order::where('status', 'pending')->count(),
            'completed_orders' => \App\Models\Order::where('status', 'completed')->count(),
        ];

        $recent_orders = \App\Models\Order::with(['user', 'driver', 'foodItems.foodItem.store'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_orders'));
    }

    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
