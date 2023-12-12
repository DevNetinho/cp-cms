<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; //USAMOS PARA ENCRIPITAR A SENHA


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return view('home_admin');
    }

    public function alterarSenha(Request $request) {
        
        $rules = [
            'senha' => 'required|min:3'
        ];

        $feedback = [
            'senha.required' => 'Campo de senha não preenchido',
            'senha.min' => 'A senha deve ter no mínimo 3 caracteres'
        ];

        $request->validate($rules, $feedback);


        $request->user()->fill([
            'password' => Hash::make($request->senha)
        ])->save();

        return response()->json(['mensagem' => 'Senha alterada com sucesso!']);
    }

    public function alterarUsuario(Request $request) {
        
        $rules = [
            'nome' => 'required|min:3'
        ];

        $feedback = [
            'senha.required' => 'Campo de nome não preenchido',
            'senha.min' => 'O nome deve ter no mínimo 3 caracteres'
        ];

        $request->validate($rules, $feedback);

        $request->user()->fill([
            'name' => $request->nome
        ])->save();

        return response()->json(['mensagem' => 'Nome de usuário alterado com sucesso!']);
    }
}