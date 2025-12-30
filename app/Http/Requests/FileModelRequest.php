<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileModelRequest extends FormRequest
{
  public function rules(): array
  {
    return [
      'model' => ['required'],
    ];
  }
}
