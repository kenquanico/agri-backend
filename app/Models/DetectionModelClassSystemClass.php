<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
class DetectionModelClassSystemClass extends Pivot
{
  protected $table = 'detection_model_class_system_classes';

  public $timestamps = false;

  protected $fillable = [
    'detection_model_class_id',
    'system_class_id',
  ];
}
