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

        // Only show pending requests (no status filter needed)
        $requests = $query->latest()->paginate(15)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.account-deletions.partials.table', compact('requests'))->render(),
                'pagination' => view('admin.partials.pagination', ['data' => $requests])->render(),
            ]);
        }

        return view('admin.account-deletions.index', compact('requests'));
    }

    public function show(AccountDeletionRequest $accountDeletion)
    {
        $accountDeletion->load('user');
        return view('admin.account-deletions.show', compact('accountDeletion'));
    }

    public function approve(AccountDeletionRequest $accountDeletion)
    {
        // Soft delete the user account immediately
        $accountDeletion->user->delete();

        // Delete the deletion request record
        $accountDeletion->delete();

        return redirect()->route('admin.account-deletions.index')
            ->with('success', 'User account has been deleted successfully');
    }
}
