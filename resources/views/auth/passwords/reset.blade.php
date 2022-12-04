@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 mt-3">
            <div class="card">
                <div class="card-header"><h2 class="text-center">Redefinir senha</h2></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row justify-content-center">
                            <div class="col-md-9">
                                <input placeholder="Email" id="email" type="email" class="form-control border-top-0 border-right-0 border-left-0 rounded-0 border-dark shadow-none @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-md-9">
                                <input placeholder="Nova senha" id="password" type="password" class="form-control border-top-0 border-right-0 border-left-0 rounded-0 border-dark shadow-none @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
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

                        <div class="form-group row mb-0 mt-5">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary btn-lg rounded-pill" >
                                    {{ __('Redefinir senha') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
