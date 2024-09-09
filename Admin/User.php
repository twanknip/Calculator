<?php

require_once 'Database.php';

class User
{
    private $conn;
    private $table = 'users';

    public $idUsers;
    public $email;
    public $password;
    public $role;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Find user by email
    public function findUserByEmail($email)
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE email = ? LIMIT 0,1';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Verify password using password_verify
    public function verifyPassword($inputPassword, $hashedPassword) {
        return password_verify($inputPassword, $hashedPassword);
    }
}

?>
