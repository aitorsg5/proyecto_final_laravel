<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CocheController;
use App\Http\Controllers\KitController;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\MotorController;
use App\Http\Controllers\CestaController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

use App\Http\Controllers\UserController;

Route::get('/users', [UserController::class, 'index']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/post', [UserController::class, 'store']);
Route::post('/login', [UserController::class, 'login']);


Route::middleware('auth:sanctum')->post('/logout', [UserController::class, 'logout']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/storage/coches/{filename}', function ($filename) {
    $path = storage_path("app/public/coches/{$filename}");
    return response()->file($path, ['Access-Control-Allow-Origin' => '*']);
});

Route::get('/kit', [KitController::class, 'index']);
Route::get('/caja', [CajaController::class, 'index']);
Route::get('/motor', [MotorController::class, 'index']);


Route::get('/coches/{id}', [CocheController::class, 'show']);

    Route::get('/coches', [CocheController::class, 'index']);
    Route::post('/añadir_coche', [CocheController::class, 'store']);




    Route::get('/cestas_get', [CestaController::class, 'index']);
    Route::post('/cestas_post', [CestaController::class, 'store']);
    Route::get('/cestas_get/{id}', [CestaController::class, 'show']);
    Route::put('/cestas/{id}', [CestaController::class, 'update']);
    Route::delete('/cestas_delet/{id}', [CestaController::class, 'destroy']);
    Route::post('/cestas/comprobar', [CestaController::class, 'existeCocheEnCesta']);

   // Route::get('/coches/{coche}', [CocheController::class, 'show']);
  //  Route::put('/coches/{coche}', [CocheController::class, 'update']);
