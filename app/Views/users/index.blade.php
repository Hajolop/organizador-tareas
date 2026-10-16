@extends('layouts.principal')

@section('contenido')
    <h1>{{ lang('App.usersTitle') }}</h1>

    <p><a href="/users/new" class="boton-verde">{{ lang('App.newUser') }}</a></p>

    <div class="tabla-contenedor">
        <table class="tabla">
            <thead>
                <tr>
                    <th>{{ lang('App.name') }}</th>
                    <th>{{ lang('App.email') }}</th>
                    <th>{{ lang('App.active') }}</th>
                    <th>{{ lang('App.administrator') }}</th>
                    <th>{{ lang('App.createdAt') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $u)
                    <tr>
                        <td><a href="/users/{{ $u['id'] }}">{{ $u['name'] }}</a></td>
                        <td>{{ $u['email'] }}</td>
                        <td>{{ $u['active'] ? lang('App.yes') : lang('App.no') }}</td>
                        <td>{{ $u['administrator'] ? lang('App.yes') : lang('App.no') }}</td>
                        <td>{{ $u['created_at'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @php
        $actual = $pager->getCurrentPage();
        $total  = $pager->getPageCount();
    @endphp
    <div class="botones">
        @if ($actual > 1)
            <a href="/users?page={{ $actual - 1 }}" class="boton-verde">{{ lang('App.newer') }}</a>
        @else
            <span class="boton-verde boton-apagado">{{ lang('App.newer') }}</span>
        @endif

        @if ($actual < $total)
            <a href="/users?page={{ $actual + 1 }}" class="boton-verde">{{ lang('App.older') }}</a>
        @else
            <span class="boton-verde boton-apagado">{{ lang('App.older') }}</span>
        @endif
    </div>
@endsection
