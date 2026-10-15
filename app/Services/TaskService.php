<?php

namespace App\Services;

use App\Models\TaskModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class TaskService
{
    private TaskModel $tareas;

    public function __construct(?TaskModel $modelo = null)
    {
        $this->tareas = $modelo ?? new TaskModel();
    }

    public function reglas(): array
    {
        return [
            'description' => ['label' => 'App.description', 'rules' => 'required|max_length[255]'],
        ];
    }

    public function listar(string $busqueda, int $porPagina = 5): array
    {
        if ($busqueda !== '') {
            $this->tareas->like('description', $busqueda);
        }

        return [
            'tareas' => $this->tareas->orderBy('created_at', 'DESC')->paginate($porPagina),
            'pager'  => $this->tareas->pager,
        ];
    }

    public function obtener(int $id): array
    {
        $tarea = $this->tareas->find($id);

        if ($tarea === null) {
            throw PageNotFoundException::forPageNotFound('La tarea no existe.');
        }

        return $tarea;
    }

    public function crear(int $usuarioId, string $descripcion): void
    {
        $this->tareas->insert([
            'user_id'     => $usuarioId,
            'description' => $descripcion,
        ]);
    }

    public function actualizar(int $id, string $descripcion): void
    {
        $this->obtener($id);
        $this->tareas->update($id, ['description' => $descripcion]);
    }

    public function eliminar(int $id): void
    {
        $this->obtener($id);
        $this->tareas->delete($id);
    }
}
