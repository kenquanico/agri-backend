<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\MonitoringRequest;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DetectionController extends Controller
{
  public function detect(MonitoringRequest $request)
  {
    $validated = $request->validated();
    $file = $validated['image']; // UploadedFile

    $client = new Client([
      'base_uri' => 'http://127.0.0.1:8000',
      'timeout' => 60.0,
    ]);

    $response = $client->post('/detect', [
      'json' => [
        'image' => $file,
      ],
    ]);

    $result = json_decode($response->getBody()->getContents(), true);

    Log::info('Detection result:', $result);

    return response()->json([
      'message' => 'Detection complete',
      'data' => $result,
    ]);
  }

}
