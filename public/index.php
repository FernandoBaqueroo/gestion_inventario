<?php

session_start();

// Mostrar errores solo en desarrollo (XAMPP)
// En producción (Railway) estos deben estar desactivados
if (getenv('APP_ENV') !== 'production') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

// Cargar archivos del core
require_once '../app/config/db.php';
require_once '../app/core/Controller.php';
require_once '../app/core/Model.php';
require_once '../app/core/Router.php';

// Cargar controladores
require_once '../app/controllers/AuthController.php';

// Obtener la URL
$url = isset($_GET['url']) ? $_GET['url'] : '';

// Iniciar el router
$router = new Router();
$router->route($url);
