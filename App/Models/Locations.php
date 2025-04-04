<?php
namespace App\Models;

use PDO;

class Locations {
    private $pdo;

    // Constructor om PDO verbinding door te geven
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // Haal alle locaties op
    public function all() {
        $stmt = $this->pdo->prepare("SELECT * FROM Location");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Haal een specifieke locatie op op basis van ID
    public function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM Location WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Voeg een nieuwe locatie toe
    public function create($city, $address, $zip_code, $country_code, $phone_number) {
        $stmt = $this->pdo->prepare("INSERT INTO Location (city, address, zip_code, country_code, phone_number) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$city, $address, $zip_code, $country_code, $phone_number]);
    }

    // Werk een bestaande locatie bij
    public function update($id, $city, $address, $zip_code, $country_code, $phone_number) {
        $stmt = $this->pdo->prepare("UPDATE Location SET city = ?, address = ?, zip_code = ?, country_code = ?, phone_number = ? WHERE id = ?");
        return $stmt->execute([$city, $address, $zip_code, $country_code, $phone_number, $id]);
    }

    // Verwijder een locatie
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM Location WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Haal alle locaties op (extra methode)
    public function getAllLocations()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM Location");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}