<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\HandleCors as BaseHandleCors;

class CustomCors extends BaseHandleCors
{
  protected function corsConfig(): array
  {
    return [
      'paths' => ['api/*'], // apply only to API routes
      'allowed_methods' => ['*'],
      'allowed_origins' => ['http://192.168.1.14:5173'], // your frontend URL
      'allowed_origins_patterns' => [],
      'allowed_headers' => ['*'],
      'exposed_headers' => [],
      'max_age' => 0,
      'supports_credentials' => false,
    ];
  }
}
