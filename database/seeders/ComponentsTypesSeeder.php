<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ComponentsTypes;

class ComponentsTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $types = [
        'Płyta główna',
        'Procesor',
        'Chłodzenie procesora',
        'Pamięć RAM',
        'Dyski',
        'Karta graficzna',
        'Karta dźwiękowa',
        'Zasilacz',
        'Obudowa'
      ];

      foreach ($types as $type) {
        $model = new ComponentsTypes();
        $model->name = $type;
        $model->save();
      }
    }
}
