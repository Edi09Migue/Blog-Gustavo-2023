<?php

use App\Http\Controllers\Admin\Permisos;
use App\Http\Controllers\Admin\Roles;
use App\Http\Controllers\Admin\Usuarios;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'auth'], function () {
  Route::post('login', [AuthController::class, 'login'])->name('login');
  Route::post('register', [AuthController::class, 'register']);

  Route::group(['middleware' => 'auth:api'], function() {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);
  });
});

Route::group(['prefix' => 'admin','middleware' => 'auth:api'], function() {
  
      Route::resource('usuarios', Usuarios::class);
      Route::post('usuarios/validate/username',[Usuarios::class,'isUniqueUsername']);
      Route::post('usuarios/validate/email',[Usuarios::class,'isUniqueEmail']);
  
      Route::apiResource('roles',Roles::class);
      Route::apiResource('permisos',Permisos::class);
      
});