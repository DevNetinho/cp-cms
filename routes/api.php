<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\PostApiController;
use App\Http\Controllers\AdminController;



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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->middleware('jwt.auth')->group(function() { //ROTAS PROTEGIDAS POR AUTENTICAÇÃO COM TOKEN JWT
    Route::post('alterar-senha', [AdminController::class, 'alterarSenha']);
    Route::post('alterar-usuario', [AdminController::class, 'alterarUsuario']);
    Route::apiResource('post', PostApiController::class)->except('show');
    Route::post('me', [AuthController::class, 'me']); //retorna dados do usuário logado na api
    Route::post('refresh', [AuthController::class, 'refresh']); //atualiza o token jwt
    Route::post('logout', [AuthController::class, 'logout']); //invalida um token jwt
});

Route::prefix('v1')->group(function() { //ROTAS QUE NÃO EXIGEM AUTENTICAÇÃO
    Route::get('post', [PostApiController::class, 'index']);
    Route::get('post/pesquisar/{palavra}', [PostApiController::class, 'show']);

});

//ROTAS DE AUTENTICAÇÃO E AUTORIZAÇÃO
Route::post('login', [AuthController::class, 'login']);





