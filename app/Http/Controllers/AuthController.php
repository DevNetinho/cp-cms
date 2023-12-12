<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request) {
        $credenciais = $request->all(['email', 'password']);

        //AUTENTICAÇÃO POR API
        $token = auth('api')->attempt($credenciais);
        
        if($token) { //AUTENTICAÇÃO FEITA COM SUCESSO
            return response()->json(['token' => $token]);
        } else {
            return response()->json(['erro' => 'Usuário ou senha inválidos!'], 403);
        }        
    }

    public function logout() {
        auth('api')->logout();

        return response()->json(['mensagem' => 'Logout relizado com sucesso!'], 200);
    }

    public function refresh() {
        $token = auth('api')->refresh(); //ATUALIZA O TOKEN JWT

        return response()->json(['token' => $token], 200); //RETORNA O NOVO TOKEN JWT
    }

    public function me() {
        return response()->json(auth()->user(), 200);
    }
}
