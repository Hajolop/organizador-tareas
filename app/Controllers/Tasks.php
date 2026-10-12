<?php

namespace App\Controllers;

use App\Models\TaskModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Tasks extends BaseController
{
    private TaskModel $tareas;

    public function __construct()
    {
        $this->tareas = new TaskModel();
    }

    public function index(): string
    {
        $busqueda = trim((string) $this->request->getGet('q'));

        if ($busqueda !== '') {
            $this->tareas->like('description', $busqueda);
        }

        $lista = $this->tareas->orderBy('created_at', 'DESC')->paginate(5);

        return view('tasks/index', [
            'tareas'   => $lista,
            'pager'    => $this->tareas->pager,
            'busqueda' => $busqueda,
        ]);
    }

    public function nueva(): string
    {
        return view('tasks/formulario', ['tarea' => null]);
    }

    public function guardar()
    {
        if (! $this->validate(['description' => 'required|max_length[255]'])) {
            return redirect()->back()->withInput()->with('errores', $this->validator->getErrors());
        }

        $this->tareas->insert([
            'user_id'     => session()->get('user_id'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('/tasks')->with('mensaje', 'Tarea creada correctamente.');
    }

    public function ver(int $id): string
    {
        return view('tasks/ver', ['tarea' => $this->buscar($id)]);
    }

    public function editar(int $id): string
    {
        return view('tasks/formulario', ['tarea' => $this->buscar($id)]);
    }

    public function actualizar(int $id)
    {
        $this->buscar($id);

        if (! $this->validate(['description' => 'required|max_length[255]'])) {
            return redirect()->back()->withInput()->with('errores', $this->validator->getErrors());
        }

        $this->tareas->update($id, ['description' => $this->request->getPost('description')]);

        return redirect()->to('/tasks/' . $id)->with('mensaje', 'Tarea actualizada correctamente.');
    }

    public function eliminar(int $id)
    {
        $this->buscar($id);
        $this->tareas->delete($id);

        return redirect()->to('/tasks')->with('mensaje', 'Tarea eliminada.');
    }

    private function buscar(int $id): array
    {
        $tarea = $this->tareas->find($id);

        if ($tarea === null) {
            throw PageNotFoundException::forPageNotFound('La tarea no existe.');
        }

        return $tarea;
    }
}
