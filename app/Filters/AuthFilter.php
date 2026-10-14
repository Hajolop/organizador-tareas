<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        helper('recordar');
        intentar_recordarme();

        if (! session()->get('logueado')) {
            $this->aplicarIdioma();

            return redirect()->to('/login')->with('errores', [lang('Mensajes.mustLogin')]);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }

    private function aplicarIdioma(): void
    {
        $idioma = session()->get('idioma');

        if (in_array($idioma, ['es', 'en'], true)) {
            service('language')->setLocale($idioma);
        }
    }
}
