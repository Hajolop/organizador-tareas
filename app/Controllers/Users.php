<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Users extends BaseController
{
    private UserModel $usuarios;

    public function __construct()
    {
        $this->usuarios = new UserModel();
    }

    public function index(): string
    {
        $lista = $this->usuarios->orderBy('created_at', 'DESC')->paginate(5);

        return view('users/index', [
            'usuarios' => $lista,
            'pager'    => $this->usuarios->pager,
        ]);
    }

    public function nuevo(): string
    {
        return view('users/nuevo');
    }

    public function guardar()
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

        $this->usuarios->insert([
            'name'          => $this->request->getPost('name'),
            'email'         => $this->request->getPost('email'),
            'password'      => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'active'        => 1,
            'administrator' => 0,
        ]);

        return redirect()->to('/users')->with('mensaje', 'Usuario creado correctamente.');
    }

    public function ver(int $id): string
    {
        return view('users/ver', ['usuario' => $this->buscar($id)]);
    }

    public function editar(int $id): string
    {
        return view('users/editar', ['usuario' => $this->buscar($id)]);
    }

    public function actualizar(int $id)
    {
        $this->buscar($id);

        $reglas = [
            'name'  => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|max_length[150]|is_unique[users.email,id,' . $id . ']',
        ];

        $clave = (string) $this->request->getPost('password');

        if ($clave !== '') {
            $reglas['password']        = 'min_length[8]';
            $reglas['password_repeat'] = 'matches[password]';
        }

        if (! $this->validate($reglas)) {
            return redirect()->back()->withInput()->with('errores', $this->validator->getErrors());
        }

        $datos = [
            'name'          => $this->request->getPost('name'),
            'email'         => $this->request->getPost('email'),
            'active'        => $this->request->getPost('active') ? 1 : 0,
            'administrator' => $this->request->getPost('administrator') ? 1 : 0,
        ];

        $esYo = $id === (int) session()->get('user_id');

        if ($esYo) {
            $datos['active']        = 1;
            $datos['administrator'] = 1;
        }

        if ($clave !== '') {
            $datos['password'] = password_hash($clave, PASSWORD_DEFAULT);
        }

        $this->usuarios->update($id, $datos);

        if ($esYo) {
            session()->set('user_name', $datos['name']);
        }

        return redirect()->to('/users/' . $id)->with('mensaje', 'Usuario actualizado correctamente.');
    }

    public function eliminar(int $id)
    {
        $usuario = $this->buscar($id);

        if ($id === (int) session()->get('user_id')) {
            return redirect()->back()->with('errores', ['No puedes eliminar tu propia cuenta.']);
        }

        if (! empty($usuario['profile_image'])) {
            $ruta = FCPATH . 'uploads/profile/' . basename($usuario['profile_image']);

            if (is_file($ruta)) {
                unlink($ruta);
            }
        }

        $this->usuarios->delete($id);

        return redirect()->to('/users')->with('mensaje', 'Usuario eliminado.');
    }

    private function buscar(int $id): array
    {
        $usuario = $this->usuarios->find($id);

        if ($usuario === null) {
            throw PageNotFoundException::forPageNotFound('El usuario no existe.');
        }

        return $usuario;
    }
}
