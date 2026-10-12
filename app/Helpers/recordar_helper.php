<?php

use App\Models\UserModel;

if (! function_exists('intentar_recordarme')) {
    function intentar_recordarme(): void
    {
        if (session()->get('logueado')) {
            return;
        }

        $cookie = (string) service('request')->getCookie('recordarme');

        if ($cookie === '' || substr_count($cookie, ':') !== 1) {
            return;
        }

        [$id, $token] = explode(':', $cookie);

        $usuario = (new UserModel())->find((int) $id);

        if (
            $usuario === null
            || (int) $usuario['active'] !== 1
            || empty($usuario['remember_token'])
            || empty($usuario['remember_expires'])
            || strtotime($usuario['remember_expires']) < time()
            || ! hash_equals($usuario['remember_token'], hash('sha256', $token))
        ) {
            return;
        }

        session()->set([
            'logueado'      => true,
            'user_id'       => $usuario['id'],
            'user_name'     => $usuario['name'],
            'administrator' => (int) $usuario['administrator'],
        ]);
    }
}
