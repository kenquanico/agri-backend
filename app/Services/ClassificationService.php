<?php

namespace App\Services;

use App\Http\Resources\ClassificationViewResource;
use App\Models\Classification;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class ClassificationService
{
  public function create(array $data)
  {
    try {
      $classification = Classification::create([
        'name' => $data['name'],
        'description' => $data['description'] ?? null,
        'severity' => $data['severity'],
        'type' => $data['type'],
        'detection_threshold' => $data['detectionThreshold'],
        'alarm_threshold' => $data['percentageThreshold'],
      ]);

      return response()->json([
        'message' => 'Classification created successfully',
        'data' => $classification
      ], 201);

    } catch (QueryException $e) {
      Log::error('Classification DB error', [
        'error' => $e->getMessage(),
        'data' => $data
      ]);

      return response()->json([
        'message' => 'Failed to create classification',
        'error' => 'Database error'
      ], 500);

    } catch (\Throwable $e) {
      Log::critical('Unexpected error creating classification', [
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
      ]);

      return response()->json([
        'message' => 'Something went wrong',
      ], 500);
    }
  }

  public function getAll()
  {
    return response()->json([
      'data' => ClassificationViewResource::collection(Classification::all())
    ], 200);
  }
}
