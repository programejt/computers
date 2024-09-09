<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComputersComponent extends Model
{
    use HasFactory;

    protected $table = 'computers_components as cc';

    public static function getForComputer(int $computerId) {
      return self::select(
        'ct.name as type_name',
        'cc.name as component_name'
      )
      ->join('components_types as ct', 'ct.id', '=', 'cc.type_id')
      ->where('computer_id', $computerId)
      ->get();
    }
}
