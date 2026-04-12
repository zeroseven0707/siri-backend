<?php

namespace App\Services;

use App\Models\LoginHistory;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function __construct(private UserRepository $userRepo) {}

    public function register(array $data, ?Request $request = null): array
    {
        $user = $this->userRepo->create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'phone'    => $data['phone'],
            'password' => $data['password'],
            'role'     => $data['role'] ?? 'user',
        ]);

        $tokenName = $data['device'] ?? 'auth_token';
        $token = $user->createToken($tokenName);

        // Simpan device info ke token
        if ($request) {
            $this->attachDeviceInfo($token->accessToken, $data, $request);
        }

        // Catat login history
        $this->recordLogin($user, $data, $request, true);

        return ['user' => $user, 'token' => $token->plainTextToken];
    }

    public function login(array $data, ?Request $request = null): array
    {
        $user = $this->userRepo->findByEmailOrPhone($data['identifier']);
        $success = $user && Hash::check($data['password'], $user->password);

        if (!$success) {
            // Catat gagal login kalau user ditemukan
            if ($user) {
                $this->recordLogin($user, $data, $request, false);
            }
            throw ValidationException::withMessages([
                'identifier' => ['The provided credentials are incorrect.'],
            ]);
        }

        $tokenName = $data['device'] ?? 'auth_token';
        $token = $user->createToken($tokenName);

        // Simpan device info ke token
        if ($request) {
            $this->attachDeviceInfo($token->accessToken, $data, $request);
        }

        // Catat login history
        $this->recordLogin($user, $data, $request, true);

        return ['user' => $user, 'token' => $token->plainTextToken];
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }

    private function attachDeviceInfo($accessToken, array $data, Request $request): void
    {
        $accessToken->forceFill([
            'device'     => $data['device'] ?? $request->userAgent(),
            'platform'   => $data['platform'] ?? null,
            'ip_address' => $request->ip(),
        ])->save();
    }

    private function recordLogin(User $user, array $data, ?Request $request, bool $success): void
    {
        LoginHistory::create([
            'user_id'     => $user->id,
            'ip_address'  => $request?->ip(),
            'device'      => $data['device'] ?? $request?->userAgent(),
            'platform'    => $data['platform'] ?? null,
            'app_version' => $data['app_version'] ?? null,
            'success'     => $success,
            'logged_in_at' => now(),
        ]);
    }
}
