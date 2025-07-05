<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticationRequest;
use App\Http\Requests\RegistrationRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {}

    public function register(RegistrationRequest $request)
    {
        try {
            $data = $request->validatedData();
            $this->userRepository->store($data);
            return response()->json([
                'message' => 'Registration successful',
            ], 201);
        } catch (\Throwable $th) {
            Log::error('User registration error' . $th->getMessage());
            return response()->json([
                'error' => 'Refistration Failed.'
            ], 500);
        }
    }

    public function authenticate(AuthenticationRequest $request)
    {
        $credentials = $request->validatedData();

        if (!Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = Auth::user();

        return response()->json([
            'message' => 'Authentication successful',
            'data' => $user,
        ]);
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return response()->json(['message' => 'Logged out']);
    }

    public function user(Request $request)
    {
        return response()->json([
            'data' => $request->user(),
        ]);
    }
}
