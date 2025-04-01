<?php
// config/config.php

// Si vous utilisez Dotenv, chargez-le :
require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Définition des constantes de connexion à la BDD
define('DB_HOST', $_ENV['DB_HOST'] ?? 'localhost');
define('DB_NAME', $_ENV['DB_NAME'] ?? 'authentification');
define('DB_USER', $_ENV['DB_USER'] ?? 'SOMPOUGDOUFabi');
define('DB_PASS', $_ENV['DB_PASS'] ?? 'Holy19*spirit');
define('APP_ENV', $_ENV['APP_ENV'] ?? 'local');
define('APP_DEBUG', $_ENV['APP_DEBUG'] ?? true);
