<?php

/**
 * Clase Base Controller (Core)
 * =============================
 * 
 * Esta es una CLASE PADRE que proporciona funcionalidad común a TODOS los controladores.
 * 
 * DIFERENCIA CLAVE:
 * -----------------
 * - Controller (Core): Clase BASE con métodos reutilizables (model, view, redirect)
 * - AuthController, ProductController, etc. (app/controllers): Clases HIJAS con lógica específica
 * 
 * HERENCIA:
 * ---------
 * Los controladores específicos heredan de esta clase usando "extends Controller":
 * 
 *   class AuthController extends Controller {
 *       public function login() {
 *           $this->view('auth/login');  // <- Método heredado
 *       }
 *   }
 * 
 * BENEFICIO:
 * ----------
 * Evita repetir código. En lugar de escribir require_once en cada controlador,
 * simplemente usamos $this->model() o $this->view() que ya están definidos aquí.
 * 
 * @package Core
 */

class Controller {

    //! 1. Cargar un modelo
    public function model($model) {
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }

    //! 2. Renderizar una vista
    public function view($view, $data = []) {
        extract($data); //? Convierte array keys en variables
        require_once '../app/views/' . $view . '.php';
    }

    //! 3. Redireccionar
    public function redirect($url) {
        header('Location: ' . $url);
        exit;
    }
}