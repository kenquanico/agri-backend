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

  public function response()
  {

    $response = new StreamedResponse(function () {
      while (true) {
        $data = [
          'detected' => rand(0,1) === 1, // demo random
          'confidence' => rand(50, 100) / 100,
          'boxes' => []
        ];

        echo "data: " . json_encode($data) . "\n\n";
        ob_flush();
        flush();

        sleep(1); // send every second
      }
    });

    $response->headers->set('Content-Type', 'text/event-stream');
    $response->headers->set('Cache-Control', 'no-cache');
    $response->headers->set('Connection', 'keep-alive');

    return $response;
  }
}
