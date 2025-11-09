<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:6',
        ], [
            'name.required' => 'O nome é obrigatório.',
            'name.min' => 'O nome deve ter pelo menos 2 caracteres.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'O e-mail deve ser um endereço válido.',
            'email.unique' => 'Este e-mail já está cadastrado.',
            'email.max' => 'O e-mail não pode ter mais de 255 caracteres.',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres.',
        ]);

        $user = $this->authService->register($validated);

        return response()->json([
            'status' => 'success',
            'data' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $data = $this->authService->login(
            $request->email,
            $request->password
        );

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function user(Request $request)
    {
        $user = $this->authService->getUser($request->user());

        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request->user());
        
        return response()->json([
            'status' => 'success',
            'message' => 'Logout realizado com sucesso'
        ]);
    }
}
