<?php

namespace App\Services;

use App\Http\Resources\FieldLightViewResource;
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
  public function getAll(array $data)
  {
    $user = auth()->user();

    if (!$user) {
      return response()->json(['message' => 'Unauthorized'], 401);
    }

    $query = Field::query();

    if (!empty($data['search'])) {
      $search = $data['search'];
      $query->where(function ($q) use ($search) {
        $q->where('name', 'like', "%{$search}%")
          ->orWhere('description', 'like', "%{$search}%");
      });
    }

    $page = $data['page'] ?? 1;
    $perPage = $data['per_page'] ?? 15;
    $results = $query->paginate($perPage, ['*'], 'page', $page);

    return FieldLightViewResource::collection($results);
  }
}
