<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateClassificationRequest extends FormRequest
{
  public function rules(): array
  {
    return [
      'name' => ['required', 'string', 'max:255', 'unique:classifications,name'],
      'type' => ['required', 'string', 'in:pest,disease'],
      'severity' => ['nullable', 'string', 'in:low,medium,high,critical'],
      'description' => ['required', 'string'],
      'detectionThreshold' => ['required', 'numeric', 'between:0,1'],
      'percentageThreshold' => ['required', 'numeric', 'between:0,1'],
    ];
  }
}
