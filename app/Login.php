<?php

namespace App;

use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class Login
{
  public function post(Request $request, AuthService $authService) {
    $validator = Validator::make($request->all(), [
      'email' => 'required|email',
      'password' => 'required|string',
    ]);

    if ($validator->fails()) {
      return response()->json([
      'message' => 'Validation failed',
        'errors' => $validator->errors(),
      ], 422);
    }

    $token = $authService->login($request->email, $request->password);

    if (!$token) {
      return response()->json(['message' => 'Invalid credentials'], 401);
    }

    return response()->json([
      'message' => 'Login successful',
      'token' => $token,
    ]);
  }

  public function register(RegisterRequest $request, AuthService $authService)
  {
    Log::info('Registering user with data: ', $request->validated());
    return $authService->register(
      $request->validated()
    );
  }
}
