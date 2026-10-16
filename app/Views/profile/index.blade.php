@extends('layouts.principal')

@section('contenido')
    <h1>{{ lang('App.profileTitle') }}</h1>

    @if (! empty($usuario['profile_image']))
        <img class="avatar" src="/uploads/profile/{{ $usuario['profile_image'] }}" alt="{{ lang('App.profileImageAlt') }}">
        <p class="centrado"><a href="/profile/image/delete" class="boton-rojo">{{ lang('App.deleteImage') }}</a></p>
    @else
        <div class="avatar">{{ mb_strtoupper(mb_substr($usuario['name'], 0, 1)) }}</div>
    @endif

    <dl class="detalle">
        <dt>{{ lang('App.name') }}</dt>
        <dd>{{ $usuario['name'] }}</dd>
        <dt>{{ lang('App.email') }}</dt>
        <dd>{{ $usuario['email'] }}</dd>
    </dl>

    <div class="botones">
        <a href="/profile/confirm" class="boton-verde">{{ lang('App.edit') }}</a>
        <a href="/profile/password" class="boton-verde">{{ lang('App.changePassword') }}</a>
        <a href="/profile/image" class="boton-verde">{{ lang('App.changeImage') }}</a>
    </div>
@endsection
