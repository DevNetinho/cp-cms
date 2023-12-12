<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'texto', 'up', 'imagem'];

    public function rules() {
        return [
            'titulo' => 'required|max:100',
            'texto' => 'required',
            'up' => 'integer',
            'imagem' => 'mimes:png,jpg,jpeg,bmp'

        ];
    }

    public function feedback() {
        return [
            'titulo.required' => 'Título obrigatório',
            'titulo.max' => 'Título só pode ter no máximo 100 caracteres',
            'texto.required' => 'Obrigatório inserir um texto',
            'up.integer' => 'Ups necessitam ser em números',
            'imagem.mimes' => 'Formatos aceitos: png, jpg, jpeg, bmp'

        ];
    }

}
