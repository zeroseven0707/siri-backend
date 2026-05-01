<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerificationController extends Controller
{
    use ApiResponse;

    /**
     * Resend verification email
     */
    public function resend(Request $request): JsonResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->error('Email already verified', 400);
        }

        $request->user()->sendEmailVerificationNotification();

        return $this->success(null, 'Verification link sent');
    }

    /**
     * Verify email
     */
    public function verify(Request $request)
    {
        $user = \App\Models\User::findOrFail($request->route('id'));

        if (!hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            return response()->view('auth.verify-error', ['message' => 'Link verifikasi tidak valid.'], 403);
        }

        if (!$user->hasVerifiedEmail()) {
            if ($user->markEmailAsVerified()) {
                event(new \Illuminate\Auth\Events\Verified($user));
            }
        }

        // Return success view which will attempt to open the app
        return view('auth.verify-success');
    }
}
