<?php

namespace App\Controllers;

class Idioma extends BaseController
{
    public function cambiar(string $codigo)
    {
        if (in_array($codigo, ['es', 'en'], true)) {
            session()->set('idioma', $codigo);
        }

        return redirect()->back();
    }
}
