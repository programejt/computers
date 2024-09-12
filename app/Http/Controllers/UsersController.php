<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Computer;

class UsersController extends Controller
{
  public function show(User $user) {
    $computers = Computer::where('user_id', $user->id)->get();

    return view('users.show', [
      'title' => $user->name.' - Użytkownik',
      'user' => $user,
      'computers' => $computers
    ]);
  }
}
