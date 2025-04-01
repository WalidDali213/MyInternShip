<?php
// core/Controller.php

class Controller {
    protected function render($view, $data = []) {
        extract($data);
        require_once __DIR__ . '/../app/Views/' . $view . '.php';
    }
}
