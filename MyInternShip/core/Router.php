<?php
// core/Router.php

class Router {
    public function dispatch() {
        // Exemple simple avec des paramètres GET : controller et action
        $controller = isset($_GET['controller']) ? $_GET['controller'] : 'dashboard';
        $action = isset($_GET['action']) ? $_GET['action'] : 'index';

        $controllerClass = ucfirst($controller) . 'Controller';
        $controllerFile = __DIR__ . '/../app/Controllers/' . $controllerClass . '.php';

        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $controllerInstance = new $controllerClass();
            if (method_exists($controllerInstance, $action)) {
                $controllerInstance->$action();
            } else {
                die("L'action '$action' n'existe pas dans $controllerClass.");
            }
        } else {
            die("Le contrôleur '$controllerClass' n'existe pas.");
        }
    }
}
