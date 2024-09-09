<?php

require_once 'Database.php';

class Brand
{
    private $conn;
    private $table = 'brands';

    public $id;
    public $name;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Lees alle merken
    public function readAll()
    {
        $query = 'SELECT * FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Lees een specifiek merk
    public function readSingle()
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ? LIMIT 0,1';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->name = $row['name'];
        }
    }

    // Maak een nieuw merk
    public function create()
    {
        $query = 'INSERT INTO ' . $this->table . ' SET name = :name';
        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));

        $stmt->bindParam(':name', $this->name);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Update een bestaand merk
    public function update()
    {
        $query = 'UPDATE ' . $this->table . ' SET name = :name WHERE id = :id';
        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Verwijder een merk
    public function delete()
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
