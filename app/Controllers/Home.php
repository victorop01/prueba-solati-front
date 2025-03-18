<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Home extends BaseController
{
    // Método para mostrar la vista de login
    public function login(): string
    {
        return view('login_view');
    }

    // Método para autenticar al usuario
    public function authenticate()
    {
        // Validación del formulario
        $validation = \Config\Services::validation();

        // Verificamos si el formulario es válido
        if (!$this->validate([
            'username' => 'required|min_length[3]|max_length[100]',
            'password' => 'required|min_length[6]|max_length[255]',
        ])) {
            // Si la validación falla, redirigimos con los errores
            return redirect()->to('/login')->withInput()->with('validation', $validation->getErrors());
        }

        // Obtener los datos del formulario
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Datos a enviar en el cuerpo de la solicitud
        $postData = [
            'username' => $username,
            'password' => $password
        ];

        // Realizamos el POST al API externo
        $response = $this->sendPostRequest('https://prueba-solati.onrender.com/api/users/login_user', $postData);

        // Verificamos si la respuesta es nula o no contiene el campo 'success'
        if ($response === null || !isset($response['success'])) {
            // Si hay un error en la solicitud, mostramos un mensaje de error
            log_message('error', 'Error al conectar o respuesta inválida del servidor de autenticación');
            return redirect()->to('/login')->with('validation', ['Usuario o Contraseña incorrecta']);
        }

        // Si la respuesta es exitosa
        if ($response['success'] === true) {
            // Guardamos los datos del usuario y el token en la sesión
            session()->set([
                'username' => $response['user'],
                'token' => $response['token'],
                'user_id' => $response['id'],
                'nombre_completo' => $response['nombre_completo'],
            ]);

            // Redirigimos al dashboard
            return redirect()->to('/listtask');
        } else {
            // Si la autenticación falla, mostramos el mensaje de error
            return redirect()->to('/login')->with('validation', ['Usuario o contraseña incorrectos']);
        }
    }

    // Función para realizar la solicitud POST a un API externo
    private function sendPostRequest($url, $data)
    {
        try {
            // Usamos el HTTP Client de CodeIgniter para hacer la solicitud
            $client = \Config\Services::httpClient();

            // Realizamos la solicitud POST al API
            $response = $client->request('POST', $url, [
                'json' => $data
            ]);

            // Verificamos el código de estado de la respuesta
            $statusCode = $response->getStatusCode();
            log_message('debug', 'API Response Status Code: ' . $statusCode);

            if ($statusCode === 200) {
                log_message('debug', 'API Response: ' . $response->getBody());
            } else {
                // Si no es exitosa, registramos el error
                log_message('error', 'Error en la respuesta del API. Código: ' . $statusCode);
            }

            // Devolvemos la respuesta decodificada como un array
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            log_message('error', 'Error en HTTP Client: ' . $e->getMessage());
            return null;
        }
    }

    public function logout()
    {
        session()->destroy(); 
        return redirect()->to('/login');
    }
}
