@extends('layouts.principal')

@section('contenido')
    <h1>{{ lang('App.passwordPrompt') }}</h1>

    <form action="/profile/confirm" method="post" class="formulario">
        {!! csrf_field() !!}

        <label for="password">{{ lang('App.password') }}</label>
        <input type="password" id="password" name="password" required>

        <div class="botones">
            <button type="submit" class="boton-verde">{{ lang('App.send') }}</button>
            <a href="/profile" class="boton-rojo">{{ lang('App.cancel') }}</a>
        </div>
    </form>
@endsection
