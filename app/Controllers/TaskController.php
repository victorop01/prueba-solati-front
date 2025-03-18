<?php

namespace App\Controllers;

use App\Models\TaskModel;
use App\Services\JWTService;
use CodeIgniter\RESTful\ResourceController;

class TaskController extends ResourceController
{
    // Método para mostrar la vista de lista de tareas
    public function listTask(): string
    {
        return view('dashboard_view');
    }
}
