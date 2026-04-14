<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with('user');

        if ($request->filled('search')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $transactions = $query->latest()->paginate(20);

        // Calculate summary stats
        $stats = [
            'total_amount' => Transaction::where('status', 'completed')->sum('amount'),
            'pending_count' => Transaction::where('status', 'pending')->count(),
            'completed_count' => Transaction::where('status', 'completed')->count(),
            'failed_count' => Transaction::where('status', 'failed')->count(),
        ];

        return view('admin.transactions.index', compact('transactions', 'stats'));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load('user');
        return view('admin.transactions.show', compact('transaction'));
    }
}
