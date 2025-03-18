<?php

namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['fullname', 'username', 'password', 'status'];
    protected $validationRules = [
        'fullname' => 'required|min_length[3]',
        'username' => 'required|min_length[5]',
        'password' => 'required|min_length[5]',
        'status' => 'required|in_list[activo,inactivo]',
    ];
}