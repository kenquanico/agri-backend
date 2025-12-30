<?php

namespace App\Services;

use App\Http\Resources\DetectionModelViewResource;
use App\Models\Classification;
use App\Models\DetectionModel;
use App\Models\DetectionModelClass;
use GuzzleHttp\Client;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ModelService
{
  public function handleUpload(array $data)
  {
    $file = $data['model'];

    DB::beginTransaction();

    try {
      // Store the uploaded model file
      $path = $file->store('detection-models', 'public');
      Log::info('Model file stored at: ' . $path);

      $model = DetectionModel::create([
        'name'        => $data['name'],
        'description' => $data['description'] ?? null,
        'file_path'   => $path,
      ]);
      Log::info('Created DetectionModel with ID: ' . $model->id);

      foreach ($data['classes'] as $classData) {
        $modelClass = DetectionModelClass::create([
          'name'     => $classData['model_class_name'],
          'model_id' => $model->id,
        ]);

        Log::info('Created DetectionModelClass with ID: ' . $modelClass->id);

        if (!empty($classData['system_class_id'])) {
          $modelClass->systemClasses()->attach($classData['system_class_id']);
          Log::info('Attached system class: ' . $classData['system_class_id']);
        }
      }

      DB::commit();

      return response()->json([
        'message' => 'Model uploaded successfully',
        'data' => [
          'model' => $model->load('classes.systemClasses'),
          'file'  => $path,
        ],
      ], 201);

    } catch (\Throwable $e) {
      DB::rollBack();
      Log::error('Model upload failed', ['error' => $e->getMessage()]);

      return response()->json([
        'error' => 'Failed to upload model',
      ], 500);
    }
  }


  public function handleCheckClasses(array $data)
  {
    Log::info('Checking model classes with data:', $data);

    if (!isset($data['model'])) {
      return response()->json([
        'error' => 'No model provided'
      ], 400);
    }

    try {
      $client = new Client(['base_uri' => 'http://127.0.0.1:8000']);

      if ($data['model'] instanceof UploadedFile) {
        $file = $data['model'];

        $response = $client->request('POST', '/get-classes', [
          'multipart' => [
            [
              'name'     => 'model_file',
              'contents' => fopen($file->getPathname(), 'r'),
              'filename' => $file->getClientOriginalName(),
            ],
          ],
        ]);
      }
      elseif (is_string($data['model'])) {
        if (!file_exists($data['model'])) {
          return response()->json(['error' => 'Model file does not exist'], 400);
        }

        $response = $client->request('POST', '/get-classes', [
          'multipart' => [
            [
              'name'     => 'model_file',
              'contents' => fopen($data['model'], 'r'),
              'filename' => basename($data['model']),
            ],
          ],
        ]);
      }
      else {
        return response()->json([
          'error' => 'Invalid model format'
        ], 400);
      }

      return response()->json(
        json_decode((string) $response->getBody(), true),
        $response->getStatusCode(),
        [
          'systemClasses' => DetectionModelClass::all()->pluck(['name', 'id'])->toArray(),
        ]
      );
    } catch (\Throwable $e) {
      return response()->json([
        'error' => $e->getMessage(),
      ], 500);
    }
  }

  public function getAllModels()
  {
    return response()->json([
      'data' => DetectionModelViewResource::collection(DetectionModel::all()),
    ], 200);
  }
}
