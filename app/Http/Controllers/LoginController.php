<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index() {
      return view('auth.login', ['title' => 'Logowanie']);
    }

    public function authenticate(Request $req) {
      $credentials = [
        'login' => $req->input('login'),
        'password' => $req->input('password')
      ];

      if (Auth::attempt($credentials)) {
        $req->session()->regenerate();

        return redirect('/');
      }

      return back()->withErrors([
          'login' => 'Nieprawidłowe dane logowania.',
      ]);
    }

    public function logout(Request $req) {
      Auth::logout();
      $session = $req->session();

      $session->invalidate();
      $session->regenerateToken();

      return redirect('/');
    }
}
