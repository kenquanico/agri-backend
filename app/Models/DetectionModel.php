<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetectionModel extends Model
{
  protected $fillable = [
    'name',
    'description',
    'file_path',
  ];
  public function classes()
  {
    return $this->hasMany(DetectionModelClass::class, 'model_id');
  }
}
