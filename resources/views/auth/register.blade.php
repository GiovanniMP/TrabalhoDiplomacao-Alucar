<body style="background-color: #E2E2E2">

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card mt-5">
                <div class="card-header"><h1 class="text-center">Sign Up</h1></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group row justify-content-center">
                            <div class="col-md-9">
                                <input placeholder="Nome" id="name" type="text" class="form-control border-top-0 border-right-0 border-left-0 rounded-0 border-dark shadow-none @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-md-9">
                                <input placeholder="Email" id="email" type="email" class="form-control border-top-0 border-right-0 border-left-0 rounded-0 border-dark shadow-none @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-md-9">
                                <input placeholder="Senha" id="password" type="password" class="form-control border-top-0 border-right-0 border-left-0 rounded-0 border-dark shadow-none @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-md-9">
                                <input placeholder="Confirmar senha" id="password-confirm" type="password" class="form-control border-top-0 border-right-0 border-left-0 rounded-0 border-dark shadow-none" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4 mt-4">
                                <button type="submit" class="btn btn-lg btn-primary rounded-pill">
                                    Cadastrar
                                </button>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-3 mt-3">
                                <a class="h3" href="{{ route('login')}}">Já possui conta?</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
    
</body>