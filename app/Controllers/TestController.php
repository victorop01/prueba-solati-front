<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;

class TestController extends ResourceController
{
    // Ruta para probar que el servidor está funcionando
    public function index()
    {
        $host = 'localhost';
        $db   = 'postgres'; // Nombre de la base de datos
        $user = 'postgres'; // Usuario de la base de datos
        $pass = 'Local2025*'; // Contraseña de la base de datos

        // Crear una nueva conexión PDO
        try {
            $pdo = new PDO("pgsql:host=$host;dbname=$db", $user, $pass);
            // Establecer el modo de error de PDO para que lance excepciones
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Ejecutar una consulta simple para probar la conexión
            $stmt = $pdo->query('SELECT NOW()');
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return "Conexión exitosa. Fecha y hora actual en la base de datos: " . $row['now'];
        } catch (PDOException $e) {
            return 'Error de conexión: ' . $e->getMessage();
        }

    }

    // Ruta para probar POST y recibir datos
    public function postTest()
    {
        // Obtener los datos JSON del cuerpo de la solicitud
        $input = $this->request->getJSON(true);  // Usar true para convertir el JSON en un array asociativo

        // Verificar si los datos llegaron correctamente
        if (!$input || !isset($input['username']) || !isset($input['password'])) {
            return $this->fail('Faltan parámetros de entrada.', 400);
        }

        // Verificar la conexión a la base de datos
        try {
            $db = \Config\Database::connect();
            $query = $db->query('SELECT NOW()');
            $result = $query->getRow();
            return $result->now;
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            return $this->fail('Error en la conexión a la base de datos: ' . $e->getMessage(), 500);
        }
    }

}
