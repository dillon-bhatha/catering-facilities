<?php

require_once '../vendor/autoload.php';
use Bramus\Router\Router;
use App\Models\Facility;
use App\Models\Locations;
use App\Models\Tag;

$di = new class {
    private $services = [];

    public function setShared($name, $callback) {
        $this->services[$name] = $callback;
    }

    public function get($name) {
        if (isset($this->services[$name])) {
            return $this->services[$name]();
        }
        die("Service '{$name}' not found in DI container.");
    }
};

// Autoloading of classes
$di->setShared('router', function () {
    return new Router();
});

// Database connection
$di->setShared('db', function () {
    $config = require __DIR__ . '/config.php';
    $dbConfig = $config['db'];

    try {
        $pdo = new \PDO(
            "mysql:host={$dbConfig['host']};dbname={$dbConfig['database']};charset=utf8mb4",
            $dbConfig['username'],
            $dbConfig['password']
        );
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (\PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
});

// Models
$di->setShared('facilityModel', function () use ($di) {
    return new Facility($di->get('db'));
});

$di->setShared('locationModel', function () use ($di) {
    return new Locations($di->get('db'));
});

$di->setShared('tagModel', function () use ($di) {
    return new Tag($di->get('db'));
});

return $di;
