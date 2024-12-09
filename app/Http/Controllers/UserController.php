<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\JwtService;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $userService;
    protected $jwtService;

    public function __construct(UserService $userService, JwtService $jwtService)
    {
        $this->userService = $userService;
        $this->jwtService = $jwtService;
    }

    // Crear un nuevo usuario
    public function createUser(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string',
        'username' => 'required|string|unique:users,username',
        'password' => 'required|string|min:6',
        'email' => 'required|email|unique:users,email',
        'identification' => 'required|string|unique:users,identification',
        'role' => 'required|string|in:admin,user',
        'address' => 'required|string',
        'termsAndConditions' => 'required|accepted',
    ]);

    try {
        $validated['password'] = Hash::make($validated['password']);
        $this->userService->createUser($validated);

        return response()->json([
            'message' => 'User created successfully!',
        ], 201);
    } catch (\Exception $e) {
        // Registrar el error completo en los logs
        \Log::error('Error creating user: ' . $e->getMessage());

        return response()->json([
            'message' => 'An error occurred while creating the user. Please try again later.',
            'error' => $e->getMessage(),  // Incluir el mensaje de error
        ], 500);
    }
}

    // Login del usuario
    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        try {
            $user = $this->userService->findByUsername($validated['username']);

            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            if (!Hash::check($validated['password'], $user->password)) {
                return response()->json(['msg' => 'Invalid credentials'], 400);
            }

            $token = $this->jwtService->generateToken(['id' => $user->id, 'username' => $user->username]);

            return response()->json([
                'msg' => 'Login successful',
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'fullName' => $user->name,
                    'role' => $user->role,
                ],
                'token' => $token,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Something went wrong during login',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
