<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Alucar</title>
</head>
<body >
    <div >
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}"><img src="{{asset('imagens/Logo.png')}}" style="width: 6rem"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @if (Route::has('login'))
                            <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                                @auth
                                    <a href="{{ url('/home') }}" class="text-sm text-gray-700 underline">Home</a>
                                @else
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}"  class="text-dark mr-3">Sign up</a>
                                    @endif
                                    <a href="{{ route('login') }}"  class="text-dark">Login</a>
                                @endauth
                            </div>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>  
    <div>
        <img src=" {{ asset('imagens/landing1.png') }}" class="img-fluid" alt="Landing">
        <h1 class="text-center" style="font-family: Playfair">Encontre o carro perfeito para seu negócio</h1>
    </div>                    
</body>
</html>