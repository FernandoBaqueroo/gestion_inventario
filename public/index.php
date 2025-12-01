<?php

session_start();

// Show errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
