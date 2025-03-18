<?php

namespace Config;

use CodeIgniter\Database\Config;

/**
 * Database Configuration
 */
class Database extends Config
{
    /**
     * The directory that holds the Migrations and Seeds directories.
     */
    public string $filesPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR;

    /**
     * Lets you choose which connection group to use if no other is specified.
     */
    public string $defaultGroup = 'default';

    /**
     * The default database connection.
     *
     * @var array<string, mixed>
     */
    public array $default = [
        'DSN'      => '', // Si no usas DSN, déjalo vacío
        'hostname' => 'localhost', // Dirección del servidor PostgreSQL
        'username' => 'postgres', // Tu nombre de usuario de PostgreSQL
        'password' => 'Local2025*', // Tu contraseña de PostgreSQL
        'database' => 'postgres', // Nombre de la base de datos
        'DBDriver' => 'PostgreSQL', // Asegúrate de usar 'PostgreSQL'
        'DBPrefix' => '', // Prefijo de las tablas (opcional)
        'pConnect' => false, // Conexión persistente (false recomendado para la mayoría de casos)
        'DBDebug'  => (ENVIRONMENT !== 'production'), // Activar o desactivar el depurado
        'cacheOn'  => false, // Si deseas usar cache de consultas
        'cacheDir' => '', // Directorio del cache (si es necesario)
        'charset'  => 'utf8', // Codificación
        'DBCollat' => 'utf8_general_ci', // Esta línea podría no ser necesaria en PostgreSQL
        'swapPre'  => '', // Intercambio de prefijo
        'encrypt'  => false, // Cifrado de datos
        'compress' => false, // Compresión de datos
        'strictOn' => false, // Activar el modo estricto de PostgreSQL
        'failover' => [],
        'save_queries' => true, // Guardar las consultas
        'port' => 5432,  // El puerto predeterminado de PostgreSQL
    ];

    /**
     * This database connection is used when running PHPUnit database tests.
     *
     * @var array<string, mixed>
     */
    public array $tests = [
        'DSN'         => '',
        'hostname'    => '127.0.0.1',
        'username'    => '',
        'password'    => '',
        'database'    => ':memory:',
        'DBDriver'    => 'SQLite3',
        'DBPrefix'    => 'db_',  // Needed to ensure we're working correctly with prefixes live. DO NOT REMOVE FOR CI DEVS
        'pConnect'    => false,
        'DBDebug'     => true,
        'charset'     => 'utf8',
        'DBCollat'    => '',
        'swapPre'     => '',
        'encrypt'     => false,
        'compress'    => false,
        'strictOn'    => false,
        'failover'    => [],
        'port'        => 3306,
        'foreignKeys' => true,
        'busyTimeout' => 1000,
        'dateFormat'  => [
            'date'     => 'Y-m-d',
            'datetime' => 'Y-m-d H:i:s',
            'time'     => 'H:i:s',
        ],
    ];

    public function __construct()
    {
        parent::__construct();

        // Ensure that we always set the database group to 'tests' if
        // we are currently running an automated test suite, so that
        // we don't overwrite live data on accident.
        if (ENVIRONMENT === 'testing') {
            $this->defaultGroup = 'tests';
        }
    }
}