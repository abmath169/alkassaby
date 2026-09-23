<?php

require_once "auth.php";
require_once "database.php";


// 1. Hakikisha request ni POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid request.");
}


// 2. Hakikisha CSRF token ipo
if (!isset($_POST['csrf_token'])) {
    die("Security token haijapatikana.");
}


// 3. Hakikisha CSRF token ni sahihi
if (
    !isset($_SESSION['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
) {
    die("Invalid security token.");
}


// 4. Hakikisha ID ipo
if (!isset($_POST['id'])) {
    die("ID ya gari haijapatikana.");
}

$id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

if ($id === false || $id <= 0) {
    die("ID ya gari si sahihi.");
}


// 5. Tafuta picha la gari kwanza
$sql = "SELECT image FROM vehicles WHERE id = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Database error: " . $conn->error);
}

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Gari halijapatikana.");
}

$vehicle = $result->fetch_assoc();

$image = $vehicle['image'];

$stmt->close();


// 6. Futa gari kwenye database
$sql = "DELETE FROM vehicles WHERE id = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Database error: " . $conn->error);
}

$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    // 7. Futa picha la gari kwenye folder
    $uploads_directory = realpath(__DIR__ . '/images');
    $image_path = realpath(__DIR__ . DIRECTORY_SEPARATOR . $image);

    if (
        $uploads_directory !== false &&
        $image_path !== false &&
        strpos($image_path, $uploads_directory . DIRECTORY_SEPARATOR) === 0 &&
        is_file($image_path)
    ) {
        unlink($image_path);
    }

    // 8. Rudi Admin Dashboard
    header("Location: admin.php");
    exit;

} else {

    echo "Kuna tatizo: " . $stmt->error;

}


$stmt->close();
$conn->close();

?>
