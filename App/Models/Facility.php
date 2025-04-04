<?php

namespace App\Models;

use PDO;

class Facility
{
    private $pdo;

    // Constructor ontvangt PDO via dependency injection
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Haal alle faciliteiten op
    public function all()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM Facility");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Haal een specifieke faciliteit op via ID
    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM Facility WHERE id = ?");
        $stmt->execute([$id]);
        $facility = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$facility) {
            error_log("No facility found with ID: $id"); // Log als geen faciliteit gevonden is
        }

        return $facility ?: null;
    }

    // Voeg een nieuwe faciliteit toe
    public function create($name, $location_id, $creation_date)
    {
        $stmt = $this->pdo->prepare("INSERT INTO Facility (name, location_id, creation_date) VALUES (?, ?, ?)");
        $stmt->execute([$name, $location_id, $creation_date]);
        return $this->pdo->lastInsertId(); // Retourneer het ID van de toegevoegde faciliteit
    }

    // Werk een bestaande faciliteit bij
    public function update($id, $name, $location_id)
    {
        $stmt = $this->pdo->prepare("UPDATE Facility SET name = ?, location_id = ? WHERE id = ?");
        return $stmt->execute([$name, $location_id, $id]);
    }

    // Verwijder een faciliteit
    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM Facility WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Voeg een tag toe aan een faciliteit
    public function addTag($facilityId, $tagId)
    {
        $stmt = $this->pdo->prepare("INSERT INTO Facility_Tag (facility_id, tag_id) VALUES (?, ?)");
        return $stmt->execute([$facilityId, $tagId]);
    }

    // Verwijder alle tags van een faciliteit
    public function removeAllTags($facilityId)
    {
        $stmt = $this->pdo->prepare("DELETE FROM Facility_Tag WHERE facility_id = ?");
        return $stmt->execute([$facilityId]);
    }

    // Zoek faciliteiten op basis van de zoekterm
    public function searchFacilities($searchTerm)
    {
        if (empty($searchTerm)) {
            return [];
        }

        // Zoek naar faciliteitnaam, locatie, of tag
        $stmt = $this->pdo->prepare("
            SELECT f.id, f.name, l.city, l.address, l.zip_code, l.country_code
            FROM Facility f
            LEFT JOIN Location l ON f.location_id = l.id
            LEFT JOIN Facility_Tag ft ON f.id = ft.facility_id
            LEFT JOIN Tag t ON ft.tag_id = t.id
            WHERE f.name LIKE :searchTerm
            OR l.city LIKE :searchTerm
            OR t.name LIKE :searchTerm
            GROUP BY f.id
        ");

        // Zoek naar gedeeltelijke overeenkomsten
        $stmt->execute(['searchTerm' => '%' . $searchTerm . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
