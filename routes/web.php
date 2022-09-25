<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


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

Route::get('/', function () {
    return view('welcome');
});

//Route::post("/login", [AuthController::class, 'login']);

//Route::post("/upload_profile_pic", [AuthController::class, 'uploadProfilePicture']);

Route::controller(AuthController::class)->group(function () {

    Route::post('login', 'login');
    Route::post('upload_profile_picture', 'uploadProfilePicture');
    Route::post('register', 'register');

});