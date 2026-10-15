@extends('layouts.principal')

@section('contenido')
    <h1>{{ lang('App.loginTitle') }}</h1>

    <form action="/login" method="post" class="formulario">
        {!! csrf_field() !!}

        <label for="email">{{ lang('App.email') }}</label>
        <input type="email" id="email" name="email" value="{!! old('email') !!}" required>

        <label for="password">{{ lang('App.password') }}</label>
        <input type="password" id="password" name="password" required>

        <label class="casilla">
            <input type="checkbox" name="remember" value="1">
            {{ lang('App.rememberMe') }}
        </label>

        <div class="botones">
            <button type="submit" class="boton-verde">{{ lang('App.loginButton') }}</button>
            <a href="/forgot" class="enlace">{{ lang('App.forgotPassword') }}</a>
        </div>
    </form>
@endsection
