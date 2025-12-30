<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetectionModelClass extends Model
{
  protected $fillable = [
    'name',
    'model_id',
  ];

  public $timestamps = false;
  public function systemClasses()
  {
    return $this->belongsToMany(
      \App\Models\Classification::class,
      'detection_model_class_system_classes',
      'detection_model_class_id',
      'system_class_id'
    );
  }
}
