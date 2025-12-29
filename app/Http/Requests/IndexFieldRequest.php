<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexFieldRequest extends FormRequest
{

  protected function prepareForValidation()
  {
    $this->merge($this->query());
  }

  public function rules(): array
  {
    return [
      'page' => ['sometimes', 'integer', 'min:1'],
      'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
      'search' => ['sometimes', 'string', 'max:255'],
    ];
  }
}
