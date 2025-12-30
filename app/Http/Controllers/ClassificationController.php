<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateClassificationRequest;
use App\Services\ClassificationService;
use Illuminate\Http\Request;

class ClassificationController extends Controller
{
  public function add(CreateClassificationRequest $request, ClassificationService $service)
  {
    return $service->create($request->validated());
  }

  public function getAll(ClassificationService $service)
  {
    return $service->getAll();
  }
}
