<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\FileModelRequest;
use App\Http\Requests\UploadModelRequest;
use App\Services\ModelService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ModelController extends Controller
{
  //
  public function upload(UploadModelRequest $request, ModelService $modelService)
  {
    return $modelService->handleUpload($request->validated());
  }

  public function checkClasses(FileModelRequest $request, ModelService $modelService)
  {
    return $modelService->handleCheckClasses($request->validated());
  }

  public function getAll(ModelService $modelService)
  {
    return $modelService->getAllModels();
  }
}
