<?php

class Router
{
    public static function route($route, $params = array())
    {
        /**
         *!  Limpia y separa la URL:
         * - trim($route, '/'): elimina las barras al inicio y final de la cadena.
         * - filter_var(..., FILTER_SANITIZE_URL): elimina caracteres no válidos en una URL.
         * - explode('/', ...): divide la cadena resultante usando '/' como delimitador, obteniendo un array con cada segmento de la URL.
         */
        $url = explode('/', filter_var(trim($route, '/'), FILTER_SANITIZE_URL));

        //! 2. Definir el controlador y el metodo
        $controllerName = !empty($url[0]) ? ucfirst($url[0]) . 'Controller' : 'DashboardController';
        $methodName = !empty($url[1]) ? $url[1] : 'index';
        $params = array_slice($url, 2); 

        //! 3. Cargar el controlador y el metodo
        $controllerFile = '../app/controllers/' . $controllerName . '.php';
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $controller = new $controllerName();
            if (method_exists($controller, $methodName)) {
                $controller->$methodName($params);
            } else {
                echo 'Method not found';
            }
        } else {
            echo 'Controller not found';
        }
    }
}