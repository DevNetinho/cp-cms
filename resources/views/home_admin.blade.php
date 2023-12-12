@extends('layouts.app')

@section('titulo', 'Novo post')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header fs-5"> Preencha os campos abaixo para criar um novo post </div>

                <div class="card-body">
                    <post-admin-component> </post-admin-component>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
