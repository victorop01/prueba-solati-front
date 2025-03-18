<?php

namespace App\Controllers;

use App\Models\UserModel; // Modelo de usuario para validar el login
use App\Services\JWTService;
use CodeIgniter\RESTful\ResourceController;

class AuthController extends ResourceController
{
    private $jwtService;

    public function __construct()
    {
        $this->jwtService = new JWTService();
    }

    // Método de inicio de sesión
    public function login()
    {
        // Obtener los datos JSON del cuerpo de la solicitud
        $input = $this->request->getJSON();

        // Log para depuración
        log_message('debug', 'Datos recibidos: ' . print_r($input, true));

        // Validar si los datos llegaron correctamente
        if (!$input || !isset($input->username) || !isset($input->password)) {
            return $this->fail('Faltan parámetros de entrada.', 400);
        }

        // Asignar valores
        $username = $input->username;
        $password = $input->password;

        // Aquí puedes continuar con la lógica de validación de usuario en tu base de datos
        $userModel = new UserModel();
        $user = $userModel->where('username', $username)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return $this->fail('Usuario o contraseña incorrectos');
        }

        // Crear el JWT
        $tokenData = [
            'id' => $user['id'],
            'username' => $user['username']
        ];

        $jwtService = new JWTService();
        $token = $jwtService->generateJWT($tokenData);

        // Retornar el token JWT
        return $this->respond(['token' => $token]);
    }

}
