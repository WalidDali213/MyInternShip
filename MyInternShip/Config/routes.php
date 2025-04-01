<?php
// config/routes.php

return [
    '' => ['controller' => 'dashboard', 'action' => 'index'],
    'login' => ['controller' => 'auth', 'action' => 'login'],
    'logout' => ['controller' => 'auth', 'action' => 'logout'],
    'entreprises' => ['controller' => 'entreprise', 'action' => 'index'],
    'offres' => ['controller' => 'offre', 'action' => 'index'],
    'candidatures' => ['controller' => 'candidature', 'action' => 'index'],
];
