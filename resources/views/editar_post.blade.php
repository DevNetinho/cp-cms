@extends('layouts.app')

@section('titulo', 'Editar post')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header fs-5"> Editar post </div>

                <div class="card-body">
                    <post-component acao="editar"> </post-component>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
