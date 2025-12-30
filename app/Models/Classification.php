<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
  protected $fillable = [
    'name',
    'description',
    'type',
    'severity',
    'detection_threshold',
    'alarm_threshold',
  ];
  public function detectionModelClasses()
  {
    return $this->belongsToMany(
      \App\Models\DetectionModelClass::class,
      'detection_model_class_system_classes',
      'system_class_id',
      'detection_model_class_id'
    );
  }
}
