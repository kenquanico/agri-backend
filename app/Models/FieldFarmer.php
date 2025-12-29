<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FieldFarmer extends Model
{
  protected $filled = [
    'name',
    'field_id',
  ];
}
