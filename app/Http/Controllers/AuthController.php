<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $authService
    ){}

    public function store(Request $request) : JsonResponse 
    {
        $validated = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:30', 'unique:users', 'regex:/^[a-zA-Z0-9._-]+$/'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ])->validate();

        ['user' => $user, 'token' => $token] = $this->authService->store($validated);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
            'token' => $token->plainTextToken,
        ], 201);
    }

    public function authenticate(Request $request): JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'identity' => ['required', 'string'],
            'password' => ['required', 'string'],
        ])->validate();

        ['user' => $user, 'token' => $token] = $this->authService->authenticate(
            $validated['identity'],
            $validated['password']
        );

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token->plainTextToken,
        ]);
    }

    public function destroy(Request $request): JsonResponse
    {
        $request->user()?->currentAccessToken()?->delete();
        return response()->json(['message' => 'Logged out']);
    }

    public function destroyAll(Request $request): JsonResponse
    {
        $request->user()?->tokens()->delete();
        return response()->json(['message' => 'Logged out from all devices']);
    }

    public function user(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }
}
