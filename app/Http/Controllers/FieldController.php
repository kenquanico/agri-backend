<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexFieldRequest;
use App\Http\Requests\StoreFieldRequest;
use Illuminate\Http\Request;

class FieldController extends Controller
{
  //
  public function store(StoreFieldRequest $request, \App\Services\FieldService $fieldService)
  {
    return $fieldService->createField($request->validated());
  }

  public function getAll(IndexFieldRequest $request, \App\Services\FieldService $fieldService)
  {
    return $fieldService->getAll($request->validated());
  }
}
