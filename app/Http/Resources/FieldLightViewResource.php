<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FieldLightViewResource extends JsonResource
{
  public function toArray(Request $request): array
  {
    return [
      'id' => $this->id,
      'fieldName' => $this->name,
      'farmers' => $this->farmers->isNotEmpty()
        ? $this->farmers->count()
        : 0,
      'area' => $this->area . ' ' . $this->measurement_unit,
      'crops' => $this->crops_planted,
      'status' => $this->currentDectect?->status ? 1 : 0
    ];
  }
}
