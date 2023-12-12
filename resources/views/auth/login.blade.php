@extends('layouts.app')

@section('content')
<div class="container">
    
    
    <login-component token_csrf="{{ csrf_token() }}"> 
        <template v-slot:reset> 
            
            <a class="btn btn-link" href="{{ route('password.request') }}">
                Esqueceu a senha?
            </a> 

        </template>
    </login-component>

</div>
@endsection
