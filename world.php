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

if ($country) {
    $stmt = $conn->prepare("SELECT name, continent, independence_year, head_of_state 
                            FROM countries 
                            WHERE name LIKE :country");
    $stmt->execute([':country' => "%$country%"]);
} else {
    $stmt = $conn->query("SELECT name, continent, independence_year, head_of_state FROM countries");
}

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($results) {
    echo "<ul>";
    foreach ($results as $row) {
        echo "<li>"
            . htmlspecialchars($row['name']) . " — "
            . htmlspecialchars($row['continent']) . " — "
            . htmlspecialchars($row['independence_year']) . " — "
            . htmlspecialchars($row['head_of_state'])
            . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No results found.</p>";
}
?>
