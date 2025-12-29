<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
  public function rules(): array
  {
    return [
      'firstName' => 'required|string|max:255',
      'lastName' => 'required|string|max:255',
      'email' => 'required|email|unique:users,email',
      'role' => 'required|string',
      'password' => 'required|string|min:8',
      'confirmPassword' => 'required|string|min:8',
      'idNumber' => 'required|string|unique:users,identifier',
    ];
  }
}
