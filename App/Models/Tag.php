<?php
namespace App\Models;

use PDO;

class Tag {
    private $pdo;

    // Constructor om PDO verbinding door te geven
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // Haal alle tags op
    public function all() {
        $stmt = $this->pdo->prepare("SELECT * FROM tag");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Haal een tag op op basis van ID
    public function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM tag WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Voeg een nieuwe tag toe
    public function create($name) {
        $stmt = $this->pdo->prepare("INSERT INTO tag (name) VALUES (?)");
        return $stmt->execute([$name]);
    }

    // Zoek een tag op naam
    public function findByName($name) {
        $stmt = $this->pdo->prepare("SELECT * FROM tag WHERE name = :name");
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);  // Gebruik PDO hier
    }

    // Werk een tag bij
    public function update($id, $name) {
        $stmt = $this->pdo->prepare("UPDATE tag SET name = ? WHERE id = ?");
        return $stmt->execute([$name, $id]);
    }

    // Verwijder een tag
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM tag WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Haal alle tags op voor een specifieke faciliteit
    public function findTagsByFacility($facilityId) {
        $sql = "SELECT t.* FROM tag t
                JOIN facility_tag ft ON t.id = ft.tag_id
                WHERE ft.facility_id = :facility_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':facility_id', $facilityId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Haal alle tags op
    public function getAllTags() {
        $stmt = $this->pdo->prepare("SELECT * FROM Tag");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}