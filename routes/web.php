<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;

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
Route::get('/registro', [ApplicationController::class, 'front_ce'])->name('front.home');
Route::get('/registro/{any}', [ApplicationController::class, 'front_ce'])->where('any', '.*');

Route::get('/{any}', [ApplicationController::class, 'index'])->where('any', '.*');
// Route::get('/admin', [ApplicationController::class, 'index'])->where('any', '.*')->name('admin');
// Route::get('/', [ApplicationController::class, 'index'])->where('any', '.*');



// Route::get('/{any}/registro', [ApplicationController::class, 'index'])->where('any', '.*');


Route::view('/registro/actas', [ApplicationController::class, 'front_ce']);
Route::view('/registro/votos', [ApplicationController::class, 'front_ce']);
Route::view('/registro/home', [ApplicationController::class, 'front_ce']);

Route::get('/reset-password/{token}', function ($token) {
    return  $token;
})->name('password.reset');

