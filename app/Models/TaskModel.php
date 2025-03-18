<?php

namespace App\Models;
use CodeIgniter\Model;

class TaskModel extends Model
{
    protected $table = 'tasks';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'description', 'status'];
    protected $validationRules = [
        'title' => 'required|min_length[3]',
        'description' => 'required|min_length[5]',
        'status' => 'required|in_list[pendiente,completada]',
    ];
}
