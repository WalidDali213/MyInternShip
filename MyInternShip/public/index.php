<?php
// public/index.php
session_start();

// Charge les configurations et l'autoload (si vous n'utilisez pas Composer, sinon utilisez vendor/autoload.php)
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../vendor/autoload.php'; // si nécessaire
require_once __DIR__ . '/../core/Router.php';

// Si vous utilisez un fichier de routes, vous pouvez le charger ici (optionnel)
$routes = require_once __DIR__ . '/../config/routes.php';

// Dispatcher la requête
$router = new Router();
$router->dispatch();

