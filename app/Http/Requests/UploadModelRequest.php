<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadModelRequest extends FormRequest
{
  public function rules(): array
  {
    return [
      'model' => ['required', 'file'],
      'name' => ['required', 'string', 'max:255'],
      'description' => ['nullable', 'string'],
      'classes' => ['required', 'array'],
      'classes.*' => ['array', 'max:255'],
      'classes.*.model_class_name' => ['required', 'string'],
      'classes.*.system_class_id' => ['required', 'integer'],
    ];
  }
}
