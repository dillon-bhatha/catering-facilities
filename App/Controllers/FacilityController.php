<?php

namespace App\Controllers;

use App\Models\Facility;
use App\Models\Locations;
use App\Models\Tag;
use PDO;

class FacilityController
{
    private $facilityModel;
    private $locationModel;
    private $tagModel;
    private $db;

    public function __construct(Facility $facilityModel, Locations $locationModel, Tag $tagModel, PDO $db)
    {
        $this->facilityModel = $facilityModel;
        $this->locationModel = $locationModel;
        $this->tagModel = $tagModel;
        $this->db = $db;
    }

    // Haalt alle faciliteiten op
    public function index()
    {
        $facilities = $this->facilityModel->all();
        include __DIR__ . '/../views/facilities/index.php';
    }

    // Haalt de details op van een specifieke faciliteit
    public function show($id)
    {
        $facility = $this->facilityModel->find($id);
        if (!$facility) {
            echo 'Facility not found.';
            return;
        }

        $location = $this->locationModel->find($facility['location_id']);
        $tags = $this->tagModel->findTagsByFacility($id);

        include __DIR__ . '/../views/facilities/show.php';
    }

    // Toon formulier om een nieuwe faciliteit toe te voegen
    public function create()
    {
        $locations = $this->locationModel->all();
        $tags = $this->tagModel->all();
        include __DIR__ . '/../views/facilities/create.php';
    }

    // Slaat een nieuwe faciliteit op in de database
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $location_id = $_POST['location_id'];
            $tags = $_POST['tags'] ?? [];
            $creation_date = date('Y-m-d');

            if (empty($name) || empty($location_id)) {
                die("Facility name and location are required.");
            }

            $facilityId = $this->facilityModel->create($name, $location_id, $creation_date);

            foreach ($tags as $tagId) {
                $this->facilityModel->addTag($facilityId, $tagId);
            }

            header('Location: /facilities');
            exit();
        }
    }

    // Haalt formulier op om een faciliteit te bewerken
    public function edit($id)
    {
        $facility = $this->facilityModel->find($id);
        if (!$facility) {
            echo 'Facility not found.';
            return;
        }

        $locations = $this->locationModel->all();
        $tags = $this->tagModel->all();
        $stmt = $this->db->prepare("SELECT tag_id FROM Facility_Tag WHERE facility_id = ?");
        $stmt->execute([$id]);
        $selectedTags = $stmt->fetchAll(PDO::FETCH_COLUMN);
        $selectedTags = $selectedTags ?: [];

        include __DIR__ . '/../views/facilities/edit.php';
    }

    // Slaat bijgewerkte faciliteit op in de database
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $location_id = $_POST['location_id'];
            $tags = $_POST['tags'] ?? [];

            $this->facilityModel->update($id, $name, $location_id);
            $this->facilityModel->removeAllTags($id);

            foreach ($tags as $tagId) {
                $this->facilityModel->addTag($id, $tagId);
            }

            header('Location: /facilities/' . $id);
            exit();
        }
    }

    // Verwijder een faciliteit uit de database
    public function destroy($id)
    {
        $this->facilityModel->removeAllTags($id);
        $this->facilityModel->delete($id);
        header('Location: /facilities');
        exit();
    }

    // Zoekt faciliteiten op basis van zoekterm
    public function search()
    {
        $searchTerm = $_GET['search'] ?? '';

        if (empty($searchTerm)) {
            $facilities = $this->facilityModel->all(); // Haal alle faciliteiten op
        } else {
            $facilities = $this->facilityModel->searchFacilities($searchTerm);
        }

        // Haal alle locaties en tags op
        $locations = $this->locationModel->getAllLocations();
        $tags = $this->tagModel->getAllTags();

         // Laad de index view
        require __DIR__ . '/../views/facilities/index.php';
    }
}
