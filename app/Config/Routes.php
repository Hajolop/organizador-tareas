<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('registro', 'Auth::registro');
$routes->post('registro', 'Auth::guardarRegistro');
$routes->get('activar/(:segment)', 'Auth::activar/$1');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::iniciarSesion');
$routes->get('logout', 'Auth::cerrarSesion');

$routes->group('tasks', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'Tasks::index');
    $routes->get('new', 'Tasks::nueva');
    $routes->post('new', 'Tasks::guardar');
    $routes->get('(:num)', 'Tasks::ver/$1');
    $routes->get('(:num)/edit', 'Tasks::editar/$1');
    $routes->post('(:num)/edit', 'Tasks::actualizar/$1');
    $routes->post('(:num)/delete', 'Tasks::eliminar/$1');
});

$routes->group('profile', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'Profile::index');
    $routes->get('confirm', 'Profile::confirmar');
    $routes->post('confirm', 'Profile::verificar');
    $routes->get('edit', 'Profile::editar');
    $routes->post('edit', 'Profile::actualizar');
    $routes->get('password', 'Profile::clave');
    $routes->post('password', 'Profile::guardarClave');
    $routes->get('image', 'Profile::imagen');
    $routes->post('image', 'Profile::guardarImagen');
    $routes->get('image/delete', 'Profile::confirmarEliminarImagen');
    $routes->post('image/delete', 'Profile::eliminarImagen');
});

$routes->group('users', ['filter' => 'admin'], static function ($routes) {
    $routes->get('/', 'Users::index');
    $routes->get('new', 'Users::nuevo');
    $routes->post('new', 'Users::guardar');
    $routes->get('(:num)', 'Users::ver/$1');
    $routes->get('(:num)/edit', 'Users::editar/$1');
    $routes->post('(:num)/edit', 'Users::actualizar/$1');
    $routes->post('(:num)/delete', 'Users::eliminar/$1');
});

$routes->get('forgot', 'Recuperar::formulario');
$routes->post('forgot', 'Recuperar::enviar');
$routes->get('reset/(:segment)', 'Recuperar::restablecer/$1');
$routes->post('reset/(:segment)', 'Recuperar::guardar/$1');
$routes->get('idioma/(:segment)', 'Idioma::cambiar/$1');

