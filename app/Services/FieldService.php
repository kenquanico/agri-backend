<?php

namespace App\Services;

use App\Models\Field;
use Illuminate\Support\Facades\Auth;

class FieldService
{
  /**
   * Create a new class instance.
   */
  public function __construct()
  {
    //
  }

  public function createField(array $data)
  {
    $user = auth()->user();

    if (!$user) {
      return response()->json(['message' => 'Unauthorized'], 401);
    }

    Field::create([
      'name' => $data['fieldName'],
      'measurement_unit' => $data['measurementUnit'],
      'area' => $data['area'],
      'made_by' => $user->id,
      'crops_planted' => $data['crops'],
    ]);

    return response()->json(['message' => 'Field created successfully'], 201);
  }

}
