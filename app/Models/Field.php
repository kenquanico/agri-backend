<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
  /** @use HasFactory<\Database\Factories\FieldFactory> */
  use HasFactory;
  protected $guarded = [];
  protected $fillable = [
    'name',
    'area',
    'measurement_unit',
    'made_by',
    'crops_planted',
  ];
}
