<?php

require_once 'Database.php';

class Model
{
    private $conn;
    private $table = 'models';

    public $id;
    public $brand_id;
    public $name;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Lees alle modellen
    public function readAll()
    {
        $query = 'SELECT * FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Lees een specifiek model
    public function readSingle()
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ? LIMIT 0,1';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->brand_id = $row['brand_id'];
            $this->name = $row['name'];
        }
    }

    // Maak een nieuw model
    public function create()
    {
        $query = 'INSERT INTO ' . $this->table . ' SET brand_id = :brand_id, name = :name';
        $stmt = $this->conn->prepare($query);

        $this->brand_id = htmlspecialchars(strip_tags($this->brand_id));
        $this->name = htmlspecialchars(strip_tags($this->name));

        $stmt->bindParam(':brand_id', $this->brand_id);
        $stmt->bindParam(':name', $this->name);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Update een bestaand model
    public function update()
    {
        $query = 'UPDATE ' . $this->table . ' SET brand_id = :brand_id, name = :name WHERE id = :id';
        $stmt = $this->conn->prepare($query);

        $this->brand_id = htmlspecialchars(strip_tags($this->brand_id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':brand_id', $this->brand_id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Verwijder een model
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
