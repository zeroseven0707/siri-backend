<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountDeletionRequest;
use Illuminate\Http\Request;

class AccountDeletionController extends Controller
{
    public function index(Request $request)
    {
        $query = AccountDeletionRequest::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $requests = $query->latest()->paginate(20);

        return view('admin.account-deletions.index', compact('requests'));
    }

    public function show(AccountDeletionRequest $accountDeletion)
    {
        $accountDeletion->load('user');
        return view('admin.account-deletions.show', compact('accountDeletion'));
    }

    public function approve(AccountDeletionRequest $accountDeletion)
    {
        $accountDeletion->update([
            'status' => 'approved',
            'processed_at' => now(),
        ]);

        // Soft delete the user account
        $accountDeletion->user->delete();

        return redirect()->route('admin.account-deletions.index')
            ->with('success', 'Account deletion request approved and user account deleted');
    }

    public function reject(Request $request, AccountDeletionRequest $accountDeletion)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $accountDeletion->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
            'processed_at' => now(),
        ]);

        return redirect()->route('admin.account-deletions.index')
            ->with('success', 'Account deletion request rejected');
    }
}
