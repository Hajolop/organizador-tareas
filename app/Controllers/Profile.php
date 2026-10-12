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
            return redirect()->back()->with('errores', ['La contraseña es incorrecta.']);
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
            'name'  => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|max_length[150]|is_unique[users.email,id,' . $id . ']',
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

        return redirect()->to('/profile')->with('mensaje', 'Perfil actualizado correctamente.');
    }

    public function clave(): string
    {
        return view('profile/clave');
    }

    public function guardarClave()
    {
        $reglas = [
            'current_password'    => 'required',
            'new_password'        => 'required|min_length[8]',
            'new_password_repeat' => 'required|matches[new_password]',
        ];

        if (! $this->validate($reglas)) {
            return redirect()->back()->with('errores', $this->validator->getErrors());
        }

        $usuario = $this->usuarioActual();

        if (! password_verify($this->request->getPost('current_password'), $usuario['password'])) {
            return redirect()->back()->with('errores', ['La contraseña actual es incorrecta.']);
        }

        $this->usuarios->update($usuario['id'], [
            'password' => password_hash($this->request->getPost('new_password'), PASSWORD_DEFAULT),
        ]);

        return redirect()->to('/profile')->with('mensaje', 'Contraseña actualizada correctamente.');
    }

    public function imagen(): string
    {
        return view('profile/imagen');
    }

    public function guardarImagen()
    {
        $reglas = [
            'imagen' => 'uploaded[imagen]|is_image[imagen]|mime_in[imagen,image/jpg,image/jpeg,image/png,image/webp]|max_size[imagen,2048]',
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

        return redirect()->to('/profile')->with('mensaje', 'Imagen de perfil actualizada.');
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

        return redirect()->to('/profile')->with('mensaje', 'Imagen de perfil eliminada.');
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
