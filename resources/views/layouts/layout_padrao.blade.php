<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <title>@yield('titulo', 'Home')</title>
    <style>
        body {
            background-color: #ECECEC;
        }
        .ponteiro:hover {
            cursor: pointer;
        }

    </style>

</head>
<body>
    {{-- DIV APP PARA USARMOS O VUEJS --}}
    
    <div class="container">
        
        <div id="app">

            <nav class="navbar navbar-expand-lg navbar-dark bg-primary rounded">
                <div class="container-fluid">
                    <a class="navbar-brand fs-2" href="#">POSTUM</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">
                            <li class="nav-item">
                                <a class="nav-link active fs-5" aria-current="page" href="{{ route('home') }}">Home</a>
                            </li>

                        </ul>
            
                        {{-- <pesquisar-component> </pesquisar-component> --}}
                    </div>
                </div>
            </nav>

            @yield('conteudo')
            
        </div>
        
        <script src="{{ asset('js/app.js') }}" defer></script>
    </div>

</body>
</html>