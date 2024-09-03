<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'App\Http\Controllers\ComputersController@index')->name('home');
Route::get('/computer/{id}', 'App\Http\Controllers\ComputersController@show');


Route::middleware('auth')->group(function () {
  Route::get('/logout', 'App\Http\Controllers\LoginController@logout')->name('logout');

  Route::get('/computer/add', 'App\Http\Controllers\ComputersController@add');
  Route::get('/computer/edit/{id}', 'App\Http\Controllers\ComputersController@edit');
  Route::match(['post', 'put'], '/computer/store', 'App\Http\Controllers\ComputersController@store');
  Route::get('/computer/delete/{computer}', 'App\Http\Controllers\ComputersController@delete');
  Route::delete('/computer/remove', 'App\Http\Controllers\ComputersController@remove');
});

Route::middleware('App\Http\Middleware\RedirectIfAuthenticated')->group(function () {
  Route::get('/login', 'App\Http\Controllers\LoginController@index')->name('login');
  Route::post('/authenticate', 'App\Http\Controllers\LoginController@authenticate');
});

// Auth::routes();
