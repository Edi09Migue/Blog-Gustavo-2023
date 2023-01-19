<?php

use App\Http\Controllers\Admin\Configuraciones;
use App\Http\Controllers\Admin\Permisos;
use App\Http\Controllers\Admin\Roles;
use App\Http\Controllers\Admin\UserProfileCtrl;
use App\Http\Controllers\Admin\Usuarios;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ControlElectoral\Actas;
use App\Http\Controllers\ControlElectoral\DashboardAdmin;
use App\Http\Controllers\ControlElectoral\Juntas;
use App\Http\Controllers\ControlElectoral\Recintos;
use App\Http\Controllers\ControlElectoral\Resultados;
use App\Http\Controllers\Geo\Cantones;
use App\Http\Controllers\Geo\Paises;
use App\Http\Controllers\Geo\Parroquias;
use App\Http\Controllers\Geo\Provincias;
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

Route::get('settings', [Configuraciones::class, 'mainSettings']);

Route::get('/testResetPasswordEmail', [AuthController::class, 'testResetPasswordEmail']);
Route::get('/testWelcomeEmail', [AuthController::class, 'testWelcomeEmail']);

Route::group(['prefix' => 'auth'], function () {
  Route::post('login', [AuthController::class, 'login'])->name('login');
  Route::post('register', [AuthController::class, 'register']);

  Route::post('reset-password', [AuthController::class, 'resetPassword']);
  Route::post('reset-password-user', [AuthController::class, 'resetPasswordPost']);

  Route::group(['middleware' => 'auth:api'], function () {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);
    Route::get('notifications', [AuthController::class, 'notifications']);
  });
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth:api'], function () {

  Route::get('users/dropdownOptions', [Usuarios::class, 'dropdownOptions']);
  Route::resource('usuarios', Usuarios::class);
  Route::post('usuarios/validate/username', [Usuarios::class, 'isUniqueUsername']);
  Route::put('usuario/{id}/updatePassword', [Usuarios::class, 'updatePassword']);
  Route::post('usuarios/validate/email', [Usuarios::class, 'isUniqueEmail']);
  Route::post('usuarios/import', [Usuarios::class, 'importExcel']);
  Route::post('usuarios/reportes', [Usuarios::class, 'reportes']);

  Route::put('profile/updatePassword', [UserProfileCtrl::class, 'updatePassword']);
  Route::put('profile/update', [UserProfileCtrl::class, 'update']);

  Route::get('roles/dropdownOptions', [Roles::class, 'dropdownOptions']);
  Route::apiResource('roles', Roles::class);
  Route::post('roles/validate/{field}', [Roles::class, 'isUniqueField']);

  Route::get('permisos/dropdownOptions', [Permisos::class, 'dropdownOptions']);
  Route::apiResource('permisos', Permisos::class);
  Route::post('permisos/validate/{field}', [Permisos::class, 'isUniqueField']);


  Route::get('permisos/dropdownOptions',[Permisos::class, 'dropdownOptions']);
  Route::apiResource('permisos',Permisos::class);
  Route::post('permisos/validate/{field}',[Permisos::class,'isUniqueField']);
  
  
  Route::apiResource('configs',Configuraciones::class);
  Route::post('configs/validate/{field}',[Configuraciones::class,'isUniqueField']);
  
  
  //Rutas geo
  Route::get('paises/dropdownOptions',[Paises::class,'dropdownOptions']);
  Route::apiResource('paises',Paises::class,['only'=>['index']]);
  
  Route::get('provincias/dropdownOptions',[Provincias::class,'dropdownOptions']);
  Route::apiResource('provincias',Provincias::class,['only'=>['index','show','update']]);
  
  Route::get('cantones/dropdownOptions',[Cantones::class,'dropdownOptions']);
  Route::apiResource('cantones',Cantones::class,['except'=>['destroy']]);
  
  Route::get('parroquias/dropdownOptions',[Parroquias::class,'dropdownOptions']);
  Route::get('parroquias/parroquiasOptionsActas',[Parroquias::class,'parroquiasOptionsActas']);
  Route::apiResource('parroquias',Parroquias::class,['except'=>['destroy']]);
      
  Route::apiResource('configs', Configuraciones::class);
  Route::post('configs/validate/{field}', [Configuraciones::class, 'isUniqueField']);

});


Route::group(['prefix' => 'control-electoral', 'middleware' => 'auth:api'], function () {

  Route::get('counters', [DashboardAdmin::class, 'counters']);
  
  Route::get('actas/dropdownOptions', [Actas::class, 'dropdownOptions']);
  Route::get('last-acta', [Actas::class, 'lastActa']);
  Route::apiResource('actas', Actas::class, ['parameters' => ['actas' => 'acta']]);
  Route::post('actas/{acta}/restore', [Actas::class,'restore']);


  Route::get('recintos/dropdownOptions', [Recintos::class, 'dropdownOptions']);
  Route::apiResource('recintos', Recintos::class, ['parameters' => ['recintos' => 'recinto']]);

  Route::get('juntas/dropdownOptions', [Juntas::class, 'dropdownOptions']);
  
  //rutas para resultados
  Route::get('resultados/totales-por-candidato', [Resultados::class, 'totalesPorCandidato']);
  Route::get('resultados/totales-por-candidato-parroquia', [Resultados::class, 'totalesPorCandidatoParroquia']);
  Route::get('resultados/totales-por-tipo-voto', [Resultados::class, 'totalesPorTipoVoto']);

  
});
