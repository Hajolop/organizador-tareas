<!DOCTYPE html>
<html lang="{{ service('language')->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ lang('App.appName') }}</title>
    <link rel="stylesheet" href="/css/estilos.css">
</head>
<body>
    <nav>
        <div>
            <a href="/">{{ lang('App.home') }}</a>
            <a href="/idioma/en">English</a>
            <a href="/idioma/es">Español</a>
        </div>
        <div>
            @if (session()->get('logueado'))
                <span>{{ lang('App.hello') }}, {{ session()->get('user_name') }}</span>
                <a href="/profile">{{ lang('App.profile') }}</a>
                @if ((int) session()->get('administrator') === 1)
                    <a href="/users">{{ lang('App.users') }}</a>
                @endif
                <a href="/tasks">{{ lang('App.tasks') }}</a>
                <a href="/logout">{{ lang('App.logout') }}</a>
            @else
                <a href="/registro">{{ lang('App.signup') }}</a>
                <a href="/login">{{ lang('App.login') }}</a>
            @endif
        </div>
    </nav>

    <main>
        @if (session()->getFlashdata('mensaje'))
            <div class="alerta alerta-ok">{{ session()->getFlashdata('mensaje') }}</div>
        @endif

        @if (session()->getFlashdata('errores'))
            <div class="alerta alerta-error">
                <ul>
                    @foreach (session()->getFlashdata('errores') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('contenido')
    </main>
</body>
</html>
