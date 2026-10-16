@extends('layouts.principal')

@section('contenido')
    <h1>{{ lang('App.userTitle') }}</h1>
    <p><a href="/users" class="enlace">{!! lang('App.backToIndex') !!}</a></p>

    <dl class="detalle">
        <dt>{{ lang('App.name') }}</dt>
        <dd>{{ $usuario['name'] }}</dd>
        <dt>{{ lang('App.email') }}</dt>
        <dd>{{ $usuario['email'] }}</dd>
        <dt>{{ lang('App.active') }}</dt>
        <dd>{{ $usuario['active'] ? lang('App.yes') : lang('App.no') }}</dd>
        <dt>{{ lang('App.administrator') }}</dt>
        <dd>{{ $usuario['administrator'] ? lang('App.yes') : lang('App.no') }}</dd>
        <dt>{{ lang('App.createdAt') }}</dt>
        <dd>{{ $usuario['created_at'] }}</dd>
        <dt>{{ lang('App.updatedAt') }}</dt>
        <dd>{{ $usuario['updated_at'] }}</dd>
    </dl>

    <div class="botones">
        <a href="/users/{{ $usuario['id'] }}/edit" class="boton-verde">{{ lang('App.edit') }}</a>
        <form action="/users/{{ $usuario['id'] }}/delete" method="post" onsubmit="return confirm({{ json_encode(lang('App.confirmDeleteUser'), JSON_UNESCAPED_UNICODE) }});">
            {!! csrf_field() !!}
            <button type="submit" class="boton-rojo">{{ lang('App.delete') }}</button>
        </form>
    </div>
@endsection
