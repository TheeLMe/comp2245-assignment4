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
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr>
            <th>Name</th>
            <th>Continent</th>
            <th>Independence Year</th>
            <th>Head of State</th>
          </tr>";
    foreach ($results as $row) {
        echo "<tr>
                <td>" . htmlspecialchars($row['name']) . "</td>
                <td>" . htmlspecialchars($row['continent']) . "</td>
                <td>" . htmlspecialchars($row['independence_year']) . "</td>
                <td>" . htmlspecialchars($row['head_of_state']) . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No results found.</p>";
}

?>
