<?php

namespace Config;

use CodeIgniter\Config\BaseService;
use CodeIgniter\HTTP\CURLRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\URI;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
    /**
     * HTTP Client service
     * 
     * @param bool $getConfig
     * @return \CodeIgniter\HTTP\CURLRequest
     */
    public static function httpClient($getConfig = null)
    {
        // Devuelve el cliente HTTP utilizando el servicio 'curlrequest'
        return \Config\Services::curlrequest();
    }
}
