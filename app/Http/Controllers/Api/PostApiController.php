<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Posts;
use Illuminate\Http\Request;

class PostApiController extends Controller
{

    public function __construct(Posts $post) { //INSTÂNCIA GLOBAL DA CLASSE PARA MELHOR APROVEITAMENTO
        $this->post = $post;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() //ROTA GET
    {   
        $post = Posts::orderBy('created_at', 'desc')->paginate(5); //APRESENTAR DADOS DE FORMA DECRESCENTE DE ACORDO COM A DATA
        return response()->json($post, 200);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //Rota POST
    {
        
        $post = new Posts();
        
        $request->validate($post->rules(), $post->feedback());
        
        if($request->imagem === null) { //CASO O USUÁRIO NÃO ENCAMINHE UMA IMAGEM
            $imagem_urn = null;           
        } else { //CASO CAMINHE UMA IMAGEM
            $imagem = $request->file('imagem'); //OBTÉM A IMAGEM
            $imagem_urn = $imagem->store('imagens', 'public'); //CRIA O DIRETÓRIO CASO NÃO TENHA SIDO CRIADO E ARMAZENA A IMAGEM
        }
        
        
        
        $post = $post->create([ //REGISTRA TUDO NO BANCO DE DADOS
            'titulo' => $request->titulo,
            'texto' => $request->texto,
            'up' => $request->up,
            'imagem' => $imagem_urn
        ]);
        
        return response()->json($post, 200); //RESPONSE
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($palavra) //ROTA GET PARA PESQUISA E APRESENTAÇÃO DE REGISTROS
    {
        $post = $this->post->where('titulo', 'LIKE', '%' . $palavra . '%')->orWhere('texto', 'LIKE', '%'. $palavra . '%')->orderBy('created_at', 'desc')->paginate(5);
        
        if($post->isEmpty()) {
            return response()->json(['erro' => 'Recurso não encontrado'], 404);
        }

        return response()->json($post, 200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = $this->post->find($id);
        
                
        if($post === null) {
            return response()->json(['erro' => 'Post não encontrado para a atualização'], 404);
        }

        if($request->method() === 'PATCH') { //REALIZAR ATUALIZAÇÃO INDIVIDUAL
            
            $regrasDinamicas = array(); //ARRAY VAZIO PARA ARMAZENAR AS rules CRIADAS NO MODEL

            foreach($post->rules() as $input => $regra) {
                
                if(array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }                
            }
            
            $request->validate($regrasDinamicas, $post->feedback());         
               
        } else {
            $request->validate($post->rules(), $post->feedback());            
        }

        $post->fill($request->all());        
        
        if($request->file('imagem')) {
            Storage::disk('public')->delete($post->imagem);

            $imagem = $request->file('imagem');
            $imagem_urn = $imagem->store('imagens', 'public');
            $post->imagem = $imagem_urn;
        }

        $post->save();
        return response()->json($post, 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = $this->post->find($id);

        if($post === null) {
            return response()->json(['erro' => 'Post não encontrado'], 404);
        }

        Storage::disk('public')->delete($post->imagem); //deletando imagem do servidor
        
        $post->delete(); //deletando post do bd de acordo com id passado na request

        return response()->json(['deletado' => 'Registro deletado com sucesso!'], 200);



    }
}
