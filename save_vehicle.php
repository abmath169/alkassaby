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


// 4. Pokea taarifa za gari
$name = trim((string) ($_POST['name'] ?? ''));
$brand = trim((string) ($_POST['brand'] ?? ''));
$model = trim((string) ($_POST['model'] ?? ''));
$year = filter_var($_POST['year'] ?? null, FILTER_VALIDATE_INT);
$price = filter_var($_POST['price'] ?? null, FILTER_VALIDATE_FLOAT);
$type = trim((string) ($_POST['type'] ?? ''));
$description = trim((string) ($_POST['description'] ?? ''));
$status = (string) ($_POST['status'] ?? '');

if (
    $name === '' || $brand === '' || $model === '' ||
    $year === false || $year < 1900 || $year > 2100 ||
    $price === false || $price < 0 || $type === '' ||
    $description === '' || !in_array($status, ['Available', 'Sold', 'Reserved'], true)
) {
    die("Tafadhali jaza taarifa zote kwa usahihi.");
}


// 5. Hakikisha picha imechaguliwa
if (
    !isset($_FILES['image']) ||
    $_FILES['image']['error'] !== UPLOAD_ERR_OK
) {
    die("Tafadhali chagua picha.");
}

$image = $_FILES['image'];


// 6. Ruhusu aina hizi za picha
$allowed_types = [
    'image/jpeg',
    'image/png',
    'image/webp'
];

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime_type = $finfo ? finfo_file($finfo, $image['tmp_name']) : false;
if ($finfo) {
    finfo_close($finfo);
}

if (!is_uploaded_file($image['tmp_name']) || !in_array($mime_type, $allowed_types, true)) {
    die("Picha lazima iwe JPG, PNG au WEBP.");
}


// 7. Maximum 5MB
if ($image['size'] > 5 * 1024 * 1024) {
    die("Picha ni kubwa sana. Maximum ni 5MB.");
}


// 8. Tengeneza jina jipya la picha
$extension = [
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
    'image/webp' => 'webp',
][$mime_type];

$new_image_name =
    time() . "_" .
    uniqid() . "." .
    $extension;


// 9. Sehemu ya kuhifadhi picha
$upload_folder = __DIR__ . "/images/";

if (!is_dir($upload_folder) && !mkdir($upload_folder, 0755, true)) {
    die("Folder la picha halikuweza kutengenezwa.");
}

$image_path = "images/" . $new_image_name;
$image_file_path = $upload_folder . $new_image_name;


// 10. Hamisha picha
if (!move_uploaded_file(
    $image['tmp_name'],
    $image_file_path
)) {
    die("Picha haikuweza kuhifadhiwa.");
}


// 11. Hifadhi taarifa kwenye database
$sql = "INSERT INTO vehicles
        (
            name,
            brand,
            model,
            year,
            price,
            type,
            description,
            image,
            status
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Database error: " . $conn->error);
}


$stmt->bind_param(
    "sssidssss",
    $name,
    $brand,
    $model,
    $year,
    $price,
    $type,
    $description,
    $image_path,
    $status
);


// 12. Save
if ($stmt->execute()) {

    header("Location: admin.php");
    exit;

} else {

    if (is_file($image_file_path)) {
        unlink($image_file_path);
    }

    echo "Kuna tatizo: " . $stmt->error;

}


$stmt->close();
$conn->close();

?>
