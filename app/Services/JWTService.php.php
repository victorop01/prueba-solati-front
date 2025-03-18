<?php

namespace App\Services;

use \Firebase\JWT\JWT;

class JWTService
{
    // Clave secreta para firmar el token (puedes cambiarla por algo más seguro)
    private $secretKey = 'Pru3B42025*';

    // Generar un JWT
    public function generateJWT($data)
    {
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600;  // El token expirará en 1 hora
        $payload = array(
            "iat" => $issuedAt,
            "exp" => $expirationTime,
            "data" => $data
        );

        return JWT::encode($payload, $this->secretKey);
    }

    // Validar un JWT
    public function validateJWT($token)
    {
        try {
            $decoded = JWT::decode($token, $this->secretKey, array('HS256'));
            return (array) $decoded->data;  // Retornamos los datos del payload
        } catch (\Exception $e) {
            return null; // Si el token es inválido o ha expirado
        }
    }
}
