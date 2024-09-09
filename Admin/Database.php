<?php

class Database
{
    private $host = '127.0.0.1'; // Je database host
    private $db_name = 'mkv_form'; // Je database naam
    private $username = 'root'; // Je database gebruikersnaam
    private $password = ''; // Je database wachtwoord
    private $conn;

    // Database Connectie
    public function connect()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }
        return $this->conn;
    }
}
