<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFieldRequest extends FormRequest
{
  public function rules(): array
  {
    return [
      'fieldName' => 'required|string|max:255',
      'measurementUnit' => 'required|string|max:100',
      'area' => 'required|numeric|min:0',
      'crops' => 'integer',
    ];
  }
}
