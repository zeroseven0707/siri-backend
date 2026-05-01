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

        $user->sendEmailVerificationNotification();

        $token = $this->createDeviceToken($user, $data, $request);
        $this->recordLogin($user, $data, $request, true);

        return ['user' => $user, 'token' => $token];
    }

    public function login(array $data, ?Request $request = null): array
    {
        $user = $this->userRepo->findByEmailOrPhone($data['identifier']);
        $success = $user && Hash::check($data['password'], $user->password);

        if (!$success) {
            if ($user) {
                $this->recordLogin($user, $data, $request, false);
            }
            throw ValidationException::withMessages([
                'identifier' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $this->createDeviceToken($user, $data, $request);
        $this->recordLogin($user, $data, $request, true);

        return ['user' => $user, 'token' => $token];
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }

    private function createDeviceToken(User $user, array $data, ?Request $request): string
    {
        $deviceName  = $data['device'] ?? $request?->userAgent() ?? 'auth_token';
        $platform    = $data['platform'] ?? null;
        $ipAddress   = $request?->ip();

        // Hapus token lama dari device yang sama agar tidak duplikat
        if ($deviceName !== 'auth_token') {
            $user->tokens()->where('device', $deviceName)->delete();
        }

        $token = $user->createToken($deviceName);

        $token->accessToken->forceFill([
            'device'     => $deviceName,
            'platform'   => $platform,
            'ip_address' => $ipAddress,
        ])->save();

        return $token->plainTextToken;
    }

    private function recordLogin(User $user, array $data, ?Request $request, bool $success): void
    {
        LoginHistory::create([
            'user_id'      => $user->id,
            'ip_address'   => $request?->ip(),
            'device'       => $data['device'] ?? $request?->userAgent(),
            'platform'     => $data['platform'] ?? null,
            'app_version'  => $data['app_version'] ?? null,
            'success'      => $success,
            'logged_in_at' => now(),
        ]);
    }
}
