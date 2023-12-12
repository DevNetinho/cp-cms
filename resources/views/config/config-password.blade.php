@extends('layouts.app')

@section('titulo', 'Alterar nome')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header fs-5"> Configurações de usuário:  </div>

                <div class="card-body">
                    <alter-component acao="password" user="{{ Auth::user()->name }}"></alter-component>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection