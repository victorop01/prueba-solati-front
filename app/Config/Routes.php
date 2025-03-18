<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/login', 'Home::login');
$routes->post('/auth', 'Home::authenticate');
$routes->get('/listtask', 'TaskController::listTask');
$routes->get('/logout', 'Home::logout');

// $routes->post('logintoken', 'AuthController::login');
// $routes->post('testconection', 'TestController::index');
// $routes->post('test', 'TestController::postTest');