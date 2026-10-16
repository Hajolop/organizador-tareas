<?php

use Illuminate\Container\Container;
use Jenssegers\Blade\Blade;
use Jenssegers\Blade\Container as ContenedorBlade;

if (! function_exists('blade')) {
    function blade(string $vista, array $datos = []): string
    {
        static $motor = null;

        if ($motor === null) {
            $cache = WRITEPATH . 'cache/blade';

            if (! is_dir($cache)) {
                mkdir($cache, 0775, true);
            }

            $contenedor = new ContenedorBlade();
            Container::setInstance($contenedor);

            $motor = new Blade(APPPATH . 'Views', $cache, $contenedor);
        }

        return $motor->render($vista, $datos);
    }
}
