<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function() {
    return redirect("login");
});

Route::get('login', 'App\Http\Controllers\LoginController@login_form');
Route::post('login', 'App\Http\Controllers\LoginController@login_do');

Route::get('signup', 'App\Http\Controllers\LoginController@signup_form');
Route::post('signup', 'App\Http\Controllers\LoginController@signup_do');
Route::get('signup/check_username/{username}', 'App\Http\Controllers\LoginController@check_username');
Route::get('signup/check_email/{email}', 'App\Http\Controllers\LoginController@check_email');

Route::get('logout', 'App\Http\Controllers\LoginController@logout');

Route::get('terms', function() {
    return view("terms");
});

Route::get('home', 'App\Http\Controllers\HomeController@home');

Route::get('profilo', 'App\Http\Controllers\ProfiloController@profilo');


Route::get('cerca_img/{query}', 'App\Http\Controllers\HomeController@cerca_img');
Route::get('cerca_db/{query}', 'App\Http\Controllers\HomeController@cerca_db');
Route::post('salva_img/{img_id}', 'App\Http\Controllers\HomeController@salva_img');

Route::get('carica_db', 'App\Http\Controllers\ProfiloController@carica_db');
Route::get('carica_upload', 'App\Http\Controllers\ProfiloController@carica_upload');
Route::get('cancella_img/{img_id}', 'App\Http\Controllers\ProfiloController@cancella_img');
Route::get('cancella_account', 'App\Http\Controllers\ProfiloController@cancella_account');

Route::get('upload', 'App\Http\Controllers\UploadController@upload_form');
Route::post('upload', 'App\Http\Controllers\UploadController@upload_do');