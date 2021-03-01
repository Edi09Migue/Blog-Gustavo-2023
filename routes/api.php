<?php

use App\Http\Controllers\Admin\Configuraciones;
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

Route::get('settings',[Configuraciones::class,'mainSettings']);

Route::group(['prefix' => 'auth'], function () {
  Route::post('login', [AuthController::class, 'login'])->name('login');
  Route::post('register', [AuthController::class, 'register']);
  
  Route::post('reset-password', [AuthController::class, 'resetPassword']);
  Route::post('reset-password-user', [AuthController::class, 'resetPasswordPost']);

  Route::group(['middleware' => 'auth:api'], function() {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);
  });
});

Route::group(['prefix' => 'admin','middleware' => 'auth:api'], function() {
  
      Route::resource('usuarios', Usuarios::class);
      Route::post('usuarios/validate/username',[Usuarios::class,'isUniqueUsername']);
      Route::post('usuarios/validate/email',[Usuarios::class,'isUniqueEmail']);
  
      Route::get('roles/dropdownOptions',[Roles::class,'dropdownOptions']);
      Route::apiResource('roles',Roles::class);
      Route::post('roles/validate/{field}',[Roles::class,'isUniqueField']);

      Route::get('permisos/dropdownOptions',[Permisos::class, 'dropdownOptions']);
      Route::apiResource('permisos',Permisos::class);
      Route::post('permisos/validate/{field}',[Permisos::class,'isUniqueField']);
      
      
      Route::apiResource('configs',Configuraciones::class);
      Route::post('configs/validate/{field}',[Configuraciones::class,'isUniqueField']);
      
});