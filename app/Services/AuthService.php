<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{

  public function login(string $email, string $password): ?string
  {
    if (!Auth::attempt(['email' => $email, 'password' => $password])) {
      return null;
    }

    $user = Auth::user();

    return $user->createToken('api_token')->plainTextToken;
  }

  public function register(array $data)
  {
    User::create([
      'name' => $data['firstName'] . ' ' . $data['lastName'],
      'first_name' => $data['firstName'],
      'last_name' => $data['lastName'],
      'email' => $data['email'],
      'password' => $data['password'],
      'identifier' => $data['idNumber'],
    ]);

    return response()->json([
      'message' => 'Registration successful',
    ], 201);
  }
}
