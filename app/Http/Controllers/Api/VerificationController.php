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
    public function verify(Request $request): JsonResponse
    {
        $user = \App\Models\User::findOrFail($request->route('id'));

        if (!hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            return $this->error('Invalid verification link', 403);
        }

        if ($user->hasVerifiedEmail()) {
            return $this->success(null, 'Email already verified');
        }

        if ($user->markEmailAsVerified()) {
            event(new \Illuminate\Auth\Events\Verified($user));
        }

        return $this->success(null, 'Email verified successfully');
    }
}
