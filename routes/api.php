<?php

use App\Http\Controllers\AlugadoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AvaliacaoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\VeiculoController;
use App\Http\Controllers\GrupoController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->middleware('jwt.auth')->group(function(){
    Route::apiResource('marca', MarcaController::class);
    Route::apiResource('modelo', ModeloController::class);
    Route::apiResource('veiculo', VeiculoController::class);
    Route::apiResource('grupos', GrupoController::class);
    Route::apiResource('avaliacao', AvaliacaoController::class);
    Route::apiResource('alugado', AlugadoController::class);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);
});

Route::post('login', [AuthController::class, 'login']);
Route::post('refresh', [AuthController::class, 'refresh']);

