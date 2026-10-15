<?php

use Jenssegers\Blade\Blade;

if (! function_exists('blade')) {
    function blade(string $vista, array $datos = []): string
    {
        static $motor = null;

        if ($motor === null) {
            $cache = WRITEPATH . 'cache/blade';

            if (! is_dir($cache)) {
                mkdir($cache, 0775, true);
            }

            $motor = new Blade(APPPATH . 'Views', $cache);
        }

        return $motor->render($vista, $datos);
    }
}
