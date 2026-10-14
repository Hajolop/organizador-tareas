<?php

namespace App\Filters;

use App\Models\UserModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        helper('recordar');
        intentar_recordarme();
        $this->aplicarIdioma();

        if (! session()->get('logueado')) {
            return redirect()->to('/login')->with('errores', [lang('Mensajes.mustLogin')]);
        }

        $usuario = (new UserModel())->find(session()->get('user_id'));

        if ($usuario === null || (int) $usuario['active'] !== 1 || (int) $usuario['administrator'] !== 1) {
            return redirect()->to('/')->with('errores', [lang('Mensajes.noPermission')]);
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
