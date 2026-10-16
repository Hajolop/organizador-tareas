@extends('layouts.principal')

@section('contenido')
    <h1>{{ lang('App.taskTitle') }}</h1>
    <p><a href="/tasks" class="enlace">{!! lang('App.backToIndex') !!}</a></p>

    <dl class="detalle">
        <dt>ID</dt>
        <dd>{{ $tarea['id'] }}</dd>
        <dt>{{ lang('App.description') }}</dt>
        <dd>{{ $tarea['description'] }}</dd>
        <dt>{{ lang('App.createdAt') }}</dt>
        <dd>{{ $tarea['created_at'] }}</dd>
        <dt>{{ lang('App.updatedAt') }}</dt>
        <dd>{{ $tarea['updated_at'] }}</dd>
    </dl>

    <div class="botones">
        <a href="/tasks/{{ $tarea['id'] }}/edit" class="boton-verde">{{ lang('App.edit') }}</a>
        <form action="/tasks/{{ $tarea['id'] }}/delete" method="post" onsubmit="return confirm({{ json_encode(lang('App.confirmDeleteTask'), JSON_UNESCAPED_UNICODE) }});">
            {!! csrf_field() !!}
            <button type="submit" class="boton-rojo">{{ lang('App.delete') }}</button>
        </form>
    </div>
@endsection
