<?php
// app/Models/User.php
require_once __DIR__ . '/Database.php';

class User {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM utilisateurs WHERE email = :email");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }
    
    // Vous pouvez ajouter des méthodes pour l'inscription, etc.
}
