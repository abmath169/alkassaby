<?php

require_once "database.php";

$sql = "SELECT * FROM vehicles";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vehicles</title>
</head>

<body>

<h1>Our Vehicles</h1>

<?php
if ($result->num_rows > 0) {

    while ($vehicle = $result->fetch_assoc()) {
        echo "<h2>" . htmlspecialchars($vehicle['name'], ENT_QUOTES, 'UTF-8') . "</h2>";
        echo "<p>Brand: " . htmlspecialchars($vehicle['brand'], ENT_QUOTES, 'UTF-8') . "</p>";
        echo "<p>Model: " . htmlspecialchars($vehicle['model'], ENT_QUOTES, 'UTF-8') . "</p>";
        echo "<p>Year: " . (int) $vehicle['year'] . "</p>";
        echo "<p>Price: Tsh " . number_format($vehicle['price']) . "</p>";
        echo "<hr>";
    }

} else {
    echo "<p>No vehicles found.</p>";
}

?>

</body>
</html>
