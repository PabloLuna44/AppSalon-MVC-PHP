<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\AdminController;
use Controllers\APIController;
use Controllers\CitaController;
use Controllers\LoginController;
use Controllers\ServicioController;
use MVC\Router;

$router = new Router();

//---------------INICIO DE SESSION-----------------
$router->get('/',[LoginController::class,'login']);
$router->post('/',[LoginController::class,'login']);

//---------------CERRAR SESSION--------------------|
$router->get('/logout',[LoginController::class,'logout']);

//---------------RECUPERAR PASSWORD----------------|
$router->get('/forgetpassword',[LoginController::class,'forgetPassword']);
$router->post('/forgetpassword',[LoginController::class,'forgetPassword']);
$router->get('/recoverpassword',[LoginController::class,'recoverPassword']);
$router->post('/recoverpassword',[LoginController::class,'recoverPassword']);

//---------------CREAR CUENTA-----------------------|
$router->get('/register',[LoginController::class,'register']);
$router->post('/register',[LoginController::class,'register']);

//-----------------CONFIRMAR CUENTA-------------------|
$router->get('/confirm-account',[LoginController::class,'confirmAccount']);
$router->get('/message',[LoginController::class,'message']);


//----------------AREA PRIVADA-------------------------|
$router->get('/cita',[CitaController::class,'index']);
$router->get('/admin',[AdminController::class,'index']);

//------------------CRUD de Servicios------------------|

$router->get('/services',[ServicioController::class,'index']);
$router->get('/services/create',[ServicioController::class,'create']);
$router->post('/services/create',[ServicioController::class,'create']);
$router->get('/services/update',[ServicioController::class,'update']);
$router->post('/services/update',[ServicioController::class,'update']);
$router->post('/services/delete',[ServicioController::class,'delete']);


//-----------------API DE CITAS-------------------------|
$router->get('/api/services',[APIController::class,'index']);
$router->post('/api/citas',[APIController::class,'save']);
$router->post('/api/delete',[APIController::class,'delete']);


//-----------------ADMINISTRADOR------------------------|

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->checkRoutes();