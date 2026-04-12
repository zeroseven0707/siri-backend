<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LoginHistory;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AccountController extends Controller
{
    use ApiResponse;

    // Ganti password
    public function changePassword(Request $request): JsonResponse
    {
        $request->validate([
            'current_password' => 'required|string',
            'password'         => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return $this->error('Password saat ini tidak sesuai', 422);
        }

        $user->update(['password' => Hash::make($request->password)]);

        // Revoke semua token kecuali yang sedang dipakai
        $currentTokenId = $user->currentAccessToken()->id;
        $user->tokens()->where('id', '!=', $currentTokenId)->delete();

        return $this->success(null, 'Password berhasil diubah. Semua sesi lain telah dikeluarkan.');
    }

    // Riwayat login
    public function loginHistory(Request $request): JsonResponse
    {
        $histories = LoginHistory::where('user_id', $request->user()->id)
            ->orderByDesc('logged_in_at')
            ->limit(20)
            ->get()
            ->map(fn ($h) => [
                'id'          => $h->id,
                'ip_address'  => $h->ip_address,
                'device'      => $h->device,
                'platform'    => $h->platform,
                'app_version' => $h->app_version,
                'success'     => $h->success,
                'logged_in_at' => $h->logged_in_at->toISOString(),
            ]);

        return $this->success($histories);
    }

    // List perangkat aktif (token yang masih valid)
    public function activeDevices(Request $request): JsonResponse
    {
        $currentTokenId = $request->user()->currentAccessToken()->id;

        // Hapus token yang tidak pernah dipakai lebih dari 7 hari
        $request->user()->tokens()
            ->whereNull('last_used_at')
            ->where('created_at', '<', now()->subDays(7))
            ->delete();

        $devices = $request->user()->tokens()
            ->orderByDesc('last_used_at')
            ->orderByDesc('created_at')
            ->get()
            ->map(fn ($token) => [
                'id'           => $token->id,
                'device'       => $this->resolveDeviceName($token),
                'platform'     => $token->platform,
                'ip_address'   => $token->ip_address,
                'last_used_at' => $token->last_used_at?->toISOString(),
                'created_at'   => $token->created_at->toISOString(),
                'is_current'   => $token->id === $currentTokenId,
            ]);

        return $this->success($devices);
    }

    private function resolveDeviceName($token): string
    {
        // Kalau device sudah diisi dari kolom baru, pakai itu
        if ($token->device && $token->device !== 'auth_token') {
            return $token->device;
        }

        // Fallback: parse dari nama token atau user agent
        $name = $token->name ?? '';
        if (str_contains(strtolower($name), 'postman')) return 'Postman';
        if (str_contains(strtolower($name), 'okhttp')) return 'Android App';
        if (str_contains(strtolower($name), 'dart')) return 'Flutter App';
        if (str_contains(strtolower($name), 'mozilla')) return 'Web Browser';
        if (str_contains(strtolower($name), 'axios')) return 'Mobile App';
        if (str_contains(strtolower($name), 'expo')) return 'Expo App';
        if ($name && $name !== 'auth_token') return $name;

        return 'Unknown Device';
    }

    // Cabut akses perangkat tertentu
    public function revokeDevice(Request $request, int $tokenId): JsonResponse
    {
        $currentTokenId = $request->user()->currentAccessToken()->id;

        if ($tokenId === $currentTokenId) {
            return $this->error('Tidak bisa mencabut sesi yang sedang aktif', 422);
        }

        $deleted = $request->user()->tokens()->where('id', $tokenId)->delete();

        if (!$deleted) {
            return $this->error('Perangkat tidak ditemukan', 404);
        }

        return $this->success(null, 'Akses perangkat berhasil dicabut');
    }

    // Cabut semua perangkat kecuali yang sedang aktif
    public function revokeAllDevices(Request $request): JsonResponse
    {
        $currentTokenId = $request->user()->currentAccessToken()->id;

        $request->user()->tokens()->where('id', '!=', $currentTokenId)->delete();

        return $this->success(null, 'Semua sesi lain berhasil dikeluarkan');
    }
}
