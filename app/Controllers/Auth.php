<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function registro(): string
    {
        return view('auth/registro');
    }

    public function guardarRegistro()
    {
        $reglas = [
            'name'            => 'required|min_length[3]|max_length[100]',
            'email'           => 'required|valid_email|max_length[150]|is_unique[users.email]',
            'password'        => 'required|min_length[8]',
            'password_repeat' => 'required|matches[password]',
        ];

        if (! $this->validate($reglas)) {
            return redirect()->back()->withInput()->with('errores', $this->validator->getErrors());
        }

        $correo = (string) $this->request->getPost('email');
        $token  = bin2hex(random_bytes(32));

        $usuarios = new UserModel();
        $usuarios->insert([
            'name'             => $this->request->getPost('name'),
            'email'            => $correo,
            'password'         => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'active'           => 0,
            'administrator'    => 0,
            'activation_token' => $token,
        ]);

        $enviado = $this->enviarCorreoActivacion($correo, $token);

        $mensaje = $enviado
            ? 'Cuenta creada. Revisa tu correo para activarla.'
            : 'Cuenta creada, pero no se pudo enviar el correo de activación.';

        return redirect()->to('/')->with('mensaje', $mensaje);
    }

    public function activar(string $token)
    {
        $usuarios = new UserModel();
        $usuario = $usuarios->where('activation_token', $token)->first();

        if ($usuario === null) {
            return redirect()->to('/')->with('errores', ['El enlace de activación no es válido o ya fue usado.']);
        }

        $usuarios->update($usuario['id'], [
            'active'           => 1,
            'activation_token' => null,
        ]);

        return redirect()->to('/')->with('mensaje', 'Cuenta activada. Ya puedes iniciar sesión.');
    }

    public function login(): string
    {
        return view('auth/login');
    }

    public function iniciarSesion()
    {
        $reglas = [
            'email'    => 'required|valid_email',
            'password' => 'required',
        ];

        if (! $this->validate($reglas)) {
            return redirect()->back()->withInput()->with('errores', $this->validator->getErrors());
        }

        $usuarios = new UserModel();
        $usuario = $usuarios->where('email', $this->request->getPost('email'))->first();

        if ($usuario === null || ! password_verify($this->request->getPost('password'), $usuario['password'])) {
            return redirect()->back()->withInput()->with('errores', ['Correo o contraseña incorrectos.']);
        }

        if ((int) $usuario['active'] !== 1) {
            return redirect()->back()->withInput()->with('errores', ['La cuenta aún no está activada. Revisa tu correo.']);
        }

        session()->regenerate();
        session()->set([
            'logueado'      => true,
            'user_id'       => $usuario['id'],
            'user_name'     => $usuario['name'],
            'administrator' => (int) $usuario['administrator'],
        ]);

        $respuesta = redirect()->to('/')->with('mensaje', 'Inicio de sesión exitoso. ¡Bienvenido!');

        if ($this->request->getPost('remember')) {
            $token = bin2hex(random_bytes(32));

            $usuarios->update($usuario['id'], [
                'remember_token'   => hash('sha256', $token),
                'remember_expires' => date('Y-m-d H:i:s', time() + 30 * 86400),
            ]);

            $this->response->setCookie([
                'name'     => 'recordarme',
                'value'    => $usuario['id'] . ':' . $token,
                'expire'   => 30 * 86400,
                'httponly' => true,
                'samesite' => 'Lax',
            ]);

            return $respuesta->withCookies();
        }

        return $respuesta;
    }

    public function cerrarSesion()
    {
        $id = session()->get('user_id');

        if ($id) {
            (new UserModel())->update($id, [
                'remember_token'   => null,
                'remember_expires' => null,
            ]);
        }

        session()->remove(['logueado', 'user_id', 'user_name', 'administrator', 'perfil_confirmado']);
        $this->response->deleteCookie('recordarme');

        return redirect()->to('/')->with('mensaje', 'Sesión cerrada correctamente.')->withCookies();
    }

    private function enviarCorreoActivacion(string $correo, string $token): bool
    {
        $config = config('Email');
        $enlace = base_url('activar/' . $token);

        $email = service('email');
        $email->setFrom($config->fromEmail, $config->fromName);
        $email->setTo($correo);
        $email->setSubject('Activa tu cuenta');
        $email->setMessage("Hola,\n\nPara activar tu cuenta entra a este enlace:\n\n" . $enlace . "\n\nSi no creaste esta cuenta, ignora este mensaje.");

        if ($email->send()) {
            return true;
        }

        log_message('error', $email->printDebugger(['headers']));

        return false;
    }
}
