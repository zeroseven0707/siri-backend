<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ApiResponse;

    public function __construct(private UserRepository $userRepo) {}

    public function profile(Request $request): JsonResponse
    {
        $user = $request->user()->load('driverProfile');

        return $this->success(new UserResource($user));
    }

    public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $data['profile_picture'] = $path;
        }

        $user = $this->userRepo->update($request->user(), $data);

        return $this->success(new UserResource($user), 'Profile updated');
    }

    public function updateFcmToken(Request $request): JsonResponse
    {
        $request->validate(['fcm_token' => 'required|string']);
        $request->user()->update(['fcm_token' => $request->fcm_token]);
        return $this->success(null, 'FCM token updated');
    }

    // GET /users/{id} — profil publik user
    public function show(string $id): JsonResponse
    {
        $user = \App\Models\User::find($id);
        if (!$user) return $this->error('User tidak ditemukan', 404);

        return $this->success([
            'id'              => $user->id,
            'name'            => $user->name,
            'profile_picture' => $user->profile_picture ? asset('storage/' . $user->profile_picture) : null,
            'photo_url'       => $user->profile_picture ? asset('storage/' . $user->profile_picture) : null,
            'posts_count'     => \App\Models\Post::where('user_id', $user->id)->count(),
        ]);
    }
}
