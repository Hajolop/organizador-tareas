<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profile extends BaseController
{
    private UserModel $usuarios;

    public function __construct()
    {
        $this->usuarios = new UserModel();
    }

    public function index(): string
    {
        return view('profile/index', ['usuario' => $this->usuarioActual()]);
    }

    public function confirmar(): string
    {
        return view('profile/confirmar');
    }

    public function verificar()
    {
        $usuario = $this->usuarioActual();

        if (! password_verify((string) $this->request->getPost('password'), $usuario['password'])) {
            return redirect()->back()->with('errores', [lang('Mensajes.wrongPassword')]);
        }

        session()->set('perfil_confirmado', time());

        return redirect()->to('/profile/edit');
    }

    public function editar()
    {
        if (! $this->confirmado()) {
            return redirect()->to('/profile/confirm');
        }

        return view('profile/editar', ['usuario' => $this->usuarioActual()]);
    }

    public function actualizar()
    {
        if (! $this->confirmado()) {
            return redirect()->to('/profile/confirm');
        }

        $id = (int) session()->get('user_id');

        $reglas = [
            'name'  => ['label' => 'App.name', 'rules' => 'required|min_length[3]|max_length[100]'],
            'email' => ['label' => 'App.email', 'rules' => 'required|valid_email|max_length[150]|is_unique[users.email,id,' . $id . ']'],
        ];

        if (! $this->validate($reglas)) {
            return redirect()->back()->withInput()->with('errores', $this->validator->getErrors());
        }

        $this->usuarios->update($id, [
            'name'  => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
        ]);

        session()->set('user_name', $this->request->getPost('name'));
        session()->remove('perfil_confirmado');

        return redirect()->to('/profile')->with('mensaje', lang('Mensajes.profileUpdated'));
    }

    public function clave(): string
    {
        return view('profile/clave');
    }

    public function guardarClave()
    {
        $reglas = [
            'current_password'    => ['label' => 'App.currentPassword', 'rules' => 'required'],
            'new_password'        => ['label' => 'App.newPassword', 'rules' => 'required|min_length[8]'],
            'new_password_repeat' => ['label' => 'App.repeatNewPassword', 'rules' => 'required|matches[new_password]'],
        ];

        if (! $this->validate($reglas)) {
            return redirect()->back()->with('errores', $this->validator->getErrors());
        }

        $usuario = $this->usuarioActual();

        if (! password_verify($this->request->getPost('current_password'), $usuario['password'])) {
            return redirect()->back()->with('errores', [lang('Mensajes.currentPasswordWrong')]);
        }

        $this->usuarios->update($usuario['id'], [
            'password'         => password_hash($this->request->getPost('new_password'), PASSWORD_DEFAULT),
            'remember_token'   => null,
            'remember_expires' => null,
        ]);

        return redirect()->to('/profile')->with('mensaje', lang('Mensajes.passwordUpdated'));
    }

    public function imagen(): string
    {
        return view('profile/imagen');
    }

    public function guardarImagen()
    {
        $reglas = [
            'imagen' => [
                'label' => 'App.changeImage',
                'rules' => 'uploaded[imagen]|is_image[imagen]|mime_in[imagen,image/jpg,image/jpeg,image/png,image/webp]|max_size[imagen,2048]',
            ],
        ];

        if (! $this->validate($reglas)) {
            return redirect()->back()->with('errores', $this->validator->getErrors());
        }

        $archivo = $this->request->getFile('imagen');
        $nombre  = $archivo->getRandomName();
        $archivo->move(FCPATH . 'uploads/profile', $nombre);

        $usuario = $this->usuarioActual();
        $this->borrarArchivo($usuario['profile_image']);
        $this->usuarios->update($usuario['id'], ['profile_image' => $nombre]);

        return redirect()->to('/profile')->with('mensaje', lang('Mensajes.imageUpdated'));
    }

    public function confirmarEliminarImagen(): string
    {
        return view('profile/eliminar_imagen');
    }

    public function eliminarImagen()
    {
        $usuario = $this->usuarioActual();
        $this->borrarArchivo($usuario['profile_image']);
        $this->usuarios->update($usuario['id'], ['profile_image' => null]);

        return redirect()->to('/profile')->with('mensaje', lang('Mensajes.imageDeleted'));
    }

    private function usuarioActual(): array
    {
        return $this->usuarios->find(session()->get('user_id'));
    }

    private function confirmado(): bool
    {
        $momento = (int) session()->get('perfil_confirmado');

        return $momento > 0 && (time() - $momento) < 600;
    }

    private function borrarArchivo(?string $nombre): void
    {
        if ($nombre !== null && $nombre !== '') {
            $ruta = FCPATH . 'uploads/profile/' . basename($nombre);

            if (is_file($ruta)) {
                unlink($ruta);
            }
        }
    }
}
