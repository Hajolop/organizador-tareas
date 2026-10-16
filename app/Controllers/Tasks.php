<?php

namespace App\Controllers;

use App\Services\TaskService;

class Tasks extends BaseController
{
    private TaskService $servicio;

    public function __construct()
    {
        $this->servicio = new TaskService();
    }

    public function index(): string
    {
        $busqueda = trim((string) $this->request->getGet('q'));

        return blade('tasks.index', $this->servicio->listar($busqueda) + ['busqueda' => $busqueda]);
    }

    public function nueva(): string
    {
        return blade('tasks.formulario', ['tarea' => null]);
    }

    public function guardar()
    {
        if (! $this->validate($this->servicio->reglas())) {
            return redirect()->back()->withInput()->with('errores', $this->validator->getErrors());
        }

        $this->servicio->crear((int) session()->get('user_id'), (string) $this->request->getPost('description'));

        return redirect()->to('/tasks')->with('mensaje', lang('Mensajes.taskCreated'));
    }

    public function ver(int $id): string
    {
        return blade('tasks.ver', ['tarea' => $this->servicio->obtener($id)]);
    }

    public function editar(int $id): string
    {
        return blade('tasks.formulario', ['tarea' => $this->servicio->obtener($id)]);
    }

    public function actualizar(int $id)
    {
        $this->servicio->obtener($id);

        if (! $this->validate($this->servicio->reglas())) {
            return redirect()->back()->withInput()->with('errores', $this->validator->getErrors());
        }

        $this->servicio->actualizar($id, (string) $this->request->getPost('description'));

        return redirect()->to('/tasks/' . $id)->with('mensaje', lang('Mensajes.taskUpdated'));
    }

    public function eliminar(int $id)
    {
        $this->servicio->eliminar($id);

        return redirect()->to('/tasks')->with('mensaje', lang('Mensajes.taskDeleted'));
    }
}
