<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function register(array $validated): array
    {
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $token = $user->createToken('api_token')->plainTextToken;

        return [
            'token' => $token,
            'user' => $user
        ];
    }

    public function login(string $email, string $password): array
    {
        $user = User::where('email', $email)->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['As credenciais estão incorretas.'],
            ]);
        }

        $token = $user->createToken('api_token')->plainTextToken;

        return [
            'token' => $token,
            'user' => $user
        ];
    }

    public function logout(User $user): bool
    {
        return $user->tokens()->delete();
    }

    public function getUser(User $user): User
    {
        return $user;
    }
}

