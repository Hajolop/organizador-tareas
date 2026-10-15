<?php

namespace App\Controllers;

use App\Models\UserModel;

class Recuperar extends BaseController
{
    public function formulario(): string
    {
        return blade('auth.olvide');
    }

    public function enviar()
    {
        $reglas = [
            'email' => ['label' => 'App.email', 'rules' => 'required|valid_email'],
        ];

        if (! $this->validate($reglas)) {
            return redirect()->back()->withInput()->with('errores', $this->validator->getErrors());
        }

        $correo   = (string) $this->request->getPost('email');
        $usuarios = new UserModel();
        $usuario  = $usuarios->where('email', $correo)->first();

        if ($usuario !== null && (int) $usuario['active'] === 1) {
            $token = bin2hex(random_bytes(32));

            $usuarios->update($usuario['id'], [
                'reset_token'   => hash('sha256', $token),
                'reset_expires' => date('Y-m-d H:i:s', time() + 3600),
            ]);

            $this->enviarCorreo($correo, $token);
        }

        return redirect()->to('/login')->with('mensaje', lang('Mensajes.resetSent'));
    }

    public function restablecer(string $token)
    {
        if ($this->buscarPorToken($token) === null) {
            return redirect()->to('/forgot')->with('errores', [lang('Mensajes.resetInvalid')]);
        }

        return blade('auth.restablecer', ['token' => $token]);
    }

    public function guardar(string $token)
    {
        $usuario = $this->buscarPorToken($token);

        if ($usuario === null) {
            return redirect()->to('/forgot')->with('errores', [lang('Mensajes.resetInvalid')]);
        }

        $reglas = [
            'password'        => ['label' => 'App.password', 'rules' => 'required|min_length[8]'],
            'password_repeat' => ['label' => 'App.repeatPassword', 'rules' => 'required|matches[password]'],
        ];

        if (! $this->validate($reglas)) {
            return redirect()->back()->with('errores', $this->validator->getErrors());
        }

        (new UserModel())->update($usuario['id'], [
            'password'         => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'reset_token'      => null,
            'reset_expires'    => null,
            'remember_token'   => null,
            'remember_expires' => null,
        ]);

        return redirect()->to('/login')->with('mensaje', lang('Mensajes.resetDone'));
    }

    private function buscarPorToken(string $token): ?array
    {
        $usuario = (new UserModel())->where('reset_token', hash('sha256', $token))->first();

        if ($usuario === null || empty($usuario['reset_expires']) || strtotime($usuario['reset_expires']) < time()) {
            return null;
        }

        return $usuario;
    }

    private function enviarCorreo(string $correo, string $token): bool
    {
        $config = config('Email');
        $enlace = base_url('reset/' . $token);

        $email = service('email');
        $email->setFrom($config->fromEmail, $config->fromName);
        $email->setTo($correo);
        $email->setSubject(lang('Mensajes.resetSubject'));
        $email->setMessage(lang('Mensajes.resetBody', [$enlace]));

        if ($email->send()) {
            return true;
        }

        log_message('error', $email->printDebugger(['headers']));

        return false;
    }
}
