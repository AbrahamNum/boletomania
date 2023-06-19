<?php

use Controllers\APICantantes;
use Controllers\APIEventos;
use Controllers\AuthController; 
use Controllers\DashboardController;
use Controllers\CantantesController;
use Controllers\EventosController;
use Controllers\RegistradosController;
use Controllers\RegalosController;
use Controllers\PaginasController;
use Controllers\RegistroCrontroller;

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;

$router = new Router();


// Login
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'login']);
$router->post('/logout', [AuthController::class, 'logout']);

// Crear Cuenta
$router->get('/registro', [AuthController::class, 'registro']);
$router->post('/registro', [AuthController::class, 'registro']);

// Formulario de olvide mi password
$router->get('/olvide', [AuthController::class, 'olvide']);
$router->post('/olvide', [AuthController::class, 'olvide']);

// Colocar el nuevo password
$router->get('/reestablecer', [AuthController::class, 'reestablecer']);
$router->post('/reestablecer', [AuthController::class, 'reestablecer']);

// Confirmación de Cuenta
$router->get('/mensaje', [AuthController::class, 'mensaje']);
$router->get('/confirmar-cuenta', [AuthController::class, 'confirmar']);

//Area de administracion
$router->get('/admin/dashboard', [DashboardController::class, 'index']);

$router->get('/admin/cantantes', [CantantesController::class, 'index']);
$router->get('/admin/cantantes/crear', [CantantesController::class, 'crear']);
$router->post('/admin/cantantes/crear', [CantantesController::class, 'crear']);
$router->get('/admin/cantantes/editar', [CantantesController::class, 'editar']);
$router->post('/admin/cantantes/editar', [CantantesController::class, 'editar']);
$router->post('/admin/cantantes/eliminar', [CantantesController::class, 'eliminar']);


$router->get('/admin/eventos', [EventosController::class, 'index']);
$router->get('/admin/eventos/crear', [EventosController::class, 'crear']);
$router->post('/admin/eventos/crear', [EventosController::class, 'crear']);
$router->get('/admin/eventos/editar', [EventosController::class, 'editar']);
$router->post('/admin/eventos/editar', [EventosController::class, 'editar']);
$router->post('/admin/eventos/eliminar', [EventosController::class, 'eliminar']);


$router->get('/api/eventos-horario', [APIEventos::class, 'index']);
$router->get('/api/cantantes', [APICantantes::class, 'index']);
$router->get('/api/cantante', [APICantantes::class, 'cantante']);


$router->get('/admin/registrados', [RegistradosController::class, 'index']);

// Registro de usuarios
$router->get('/finalizar-registro', [RegistroCrontroller::class, 'crear']);
$router->post('/finalizar-registro/gratis', [RegistroCrontroller::class, 'gratis']);
$router->post('/finalizar-registro/pagar', [RegistroCrontroller::class, 'pagar']);
$router->get('/finalizar-registro/conciertos', [RegistroCrontroller::class, 'conciertos']);
$router->post('/finalizar-registro/conciertos', [RegistroCrontroller::class, 'conciertos']);

// Boleto Virtual
$router->get('https://fast-ocean-13494-d7e50af88d45.herokuapp.com/boleto', [RegistroCrontroller::class, 'boleto']);


// Area Publica 
$router->get('/', [PaginasController::class, 'index']);
$router->get('/boletomania', [PaginasController::class, 'evento']);
$router->get('/paquetes', [PaginasController::class, 'paquetes']);
$router->get('/conciertos', [PaginasController::class, 'conciertos']);
$router->get('/404', [PaginasController::class, 'error']);

$router->comprobarRutas();