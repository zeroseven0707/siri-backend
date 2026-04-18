<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'driver', 'foodItems.foodItem.store', 'service']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('order_number', 'like', '%' . $request->search . '%');
        }

        $orders = $query->latest()->paginate(15)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.orders.partials.table', compact('orders'))->render(),
                'pagination' => view('admin.partials.pagination', ['data' => $orders])->render(),
            ]);
        }

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'driver', 'items.foodItem.store', 'service']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,accepted,on_progress,completed,cancelled',
        ]);

        $order->update($validated);

        return redirect()->back()->with('success', 'Order status updated successfully');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order deleted successfully');
    }
}
