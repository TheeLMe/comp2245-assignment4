<?php
$host = 'localhost';
$dbname = 'world';
$username = 'lab5_user';
$password = 'password123';

try {
    $conn = new PDO(
        "mysql:host=$host;port=3306;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("Connection failed: " . htmlspecialchars($e->getMessage()));
}

$country = $_GET['country'] ?? '';
$lookup  = $_GET['lookup'] ?? 'countries';

function esc($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

if ($lookup === 'cities') {
    if ($country) {
        $stmt = $conn->prepare(
            "SELECT c.name, c.district, c.population
             FROM cities c
             JOIN countries co ON c.country_code = co.code
             WHERE co.name LIKE :country"
        );
        $stmt->execute([':country' => "%$country%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($results) {
            echo "<table border='1' cellpadding='5' cellspacing='0'>";
            echo "<tr><th>Name</th><th>District</th><th>Population</th></tr>";
            foreach ($results as $row) {
                echo "<tr>
                        <td>" . esc($row['name']) . "</td>
                        <td>" . esc($row['district']) . "</td>
                        <td>" . esc($row['population']) . "</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No cities found for " . esc($country) . ".</p>";
        }
    } else {
        echo "<p>Please enter a country name to lookup cities.</p>";
    }
    exit;
}


if ($country) {
    $stmt = $conn->prepare(
        "SELECT name, continent, independence_year, head_of_state 
         FROM countries 
         WHERE name LIKE :country"
    );
    $stmt->execute([':country' => "%$country%"]);
} else {
    $stmt = $conn->query(
        "SELECT name, continent, independence_year, head_of_state FROM countries"
    );
}

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);


if ($results) {
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr><th>Name</th><th>Continent</th><th>Independence Year</th><th>Head of State</th></tr>";
    foreach ($results as $row) {
        echo "<tr>
                <td>" . esc($row['name']) . "</td>
                <td>" . esc($row['continent']) . "</td>
                <td>" . esc($row['independence_year']) . "</td>
                <td>" . esc($row['head_of_state']) . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No countries found.</p>";
}?>