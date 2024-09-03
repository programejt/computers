<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $user = new User();
      $user->name = 'Viperproo';
      $user->login = 'viperproo';
      $user->email = 'viperproo@computers.com';
      $user->password = bcrypt('admin');
      $user->save();
    }
}
