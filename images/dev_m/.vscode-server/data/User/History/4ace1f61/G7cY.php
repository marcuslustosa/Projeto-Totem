@extends('layouts.authentication.master')
@section('title', 'Login')

@section('css')
@endsection

@section('style')
@endsection

@section('content')
<div class="container-fluid p-0">
    <div class="row m-0">
        <div class="col-12 p-0">
            <div class="login-card">
                <div>
                    <div><a class="logo" href="{{ route('index') }}"><img class="img-fluid for-light"
                                src="{{asset('assets/images/logo/login.png')}}" alt="looginpage"><img
                                class="img-fluid for-dark" src="{{asset('assets/images/logo/logo_dark.png')}}"
                                alt="looginpage"></a></div>
                    <div class="login-main">

                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <!-- Validation Errors -->
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />


                        <form class="theme-form" method="POST" action="{{ route('login') }}">
                            @csrf
                            <h4>Acessar Conta</h4>
                            <p>Digite e-mail e senha para entrar</p>
                            <div class="form-group">
                                <label class="col-form-label">E-mail</label>
                                <input class="form-control" id="email" type="email" name="email" :value="old('email')"
                                    required autofocus placeholder="exemplo@gmail.com">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Senha</label>
                                <input class="form-control" id="password" type="password" name="password" required
                                    autocomplete="current-password" placeholder="*********">
                                <!--<div class="show-hide"><span class="show">                         </span></div>-->
                            </div>
                            <div class="form-group mb-0">
                                <div class="checkbox p-0">
                                    <input id="remember_me" type="checkbox" name="remember">
                                    <label class="text-muted" for="remember_me">Lembrar senha</label>
                                </div>
                                @if (Route::has('password.request'))
                                <a class="link" href="{{ route('password.request') }}">Esqueceu a sua senha?</a>
                                @endif
                                <button class="btn btn-primary btn-block" type="submit">Entrar</button>
                            </div>
                            <!--<h6 class="text-muted mt-4 or">Or Sign in with</h6>
                     <div class="social mt-4">
                        <div class="btn-showcase"><a class="btn btn-light" href="https://www.linkedin.com/login" target="_blank"><i class="txt-linkedin" data-feather="linkedin"></i> LinkedIn </a><a class="btn btn-light" href="https://twitter.com/login?lang=en" target="_blank"><i class="txt-twitter" data-feather="twitter"></i>twitter</a><a class="btn btn-light" href="https://www.facebook.com/" target="_blank"><i class="txt-fb" data-feather="facebook"></i>facebook</a></div>
                     </div>
                     <p class="mt-4 mb-0">Don't have account?<a class="ms-2" href="{{  route('sign-up') }}">Create Account</a></p> -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
@endsection
