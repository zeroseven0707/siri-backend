<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function create(array $data): User
    {
        return User::create($data);
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function findByPhone(string $phone): ?User
    {
        return User::where('phone', $phone)->first();
    }

    public function findByEmailOrPhone(string $identifier): ?User
    {
        return User::where('email', $identifier)
            ->orWhere('phone', $identifier)
            ->first();
    }

    public function update(User $user, array $data): User
    {
        $user->update($data);
        return $user->fresh();
    }
}
