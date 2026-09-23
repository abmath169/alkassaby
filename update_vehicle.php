<?php

require_once "auth.php";
require_once "database.php";


// ================================
// 1. HAKIKISHA REQUEST NI POST
// ================================

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid request.");
}


// ================================
// 2. CSRF TOKEN CHECK
// ================================

if (!isset($_POST['csrf_token'])) {
    die("Security token haijapatikana.");
}

if (
    !isset($_SESSION['csrf_token']) ||
    !hash_equals(
        $_SESSION['csrf_token'],
        $_POST['csrf_token']
    )
) {
    die("Invalid security token.");
}


// ================================
// 3. HAKIKISHA ID IPO
// ================================

if (!isset($_POST['id'])) {
    die("ID ya gari haijapatikana.");
}

$id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

if ($id === false || $id <= 0) {
    die("ID ya gari si sahihi.");
}


// ================================
// 4. PATA TAARIFA ZA FORM
// ================================

$name = trim((string) ($_POST['name'] ?? ''));
$brand = trim((string) ($_POST['brand'] ?? ''));
$model = trim((string) ($_POST['model'] ?? ''));
$year = filter_var($_POST['year'] ?? null, FILTER_VALIDATE_INT);
$price = filter_var($_POST['price'] ?? null, FILTER_VALIDATE_FLOAT);
$type = trim((string) ($_POST['type'] ?? ''));
$description = trim((string) ($_POST['description'] ?? ''));
$status = (string) ($_POST['status'] ?? '');


// ================================
// 5. VALIDATION
// ================================

if (
    $name === "" ||
    $brand === "" ||
    $model === "" ||
    $year === false ||
    $year < 1900 ||
    $year > 2100 ||
    $price === false ||
    $price < 0 ||
    $type === "" ||
    $description === "" ||
    !in_array($status, ['Available', 'Sold', 'Reserved'], true)
) {
    die("Tafadhali jaza taarifa zote kwa usahihi.");
}


// ================================
// 6. PATA PICHA YA SASA
// ================================

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

$current_vehicle = $result->fetch_assoc();

$current_image = $current_vehicle['image'];

$stmt->close();


// ================================
// 7. DEFAULT:
//    TUMIA PICHA YA SASA
// ================================

$new_image = $current_image;


// ================================
// 8. KAMA PICHA MPYA IMECHAGULIWA
// ================================

if (
    isset($_FILES['image']) &&
    $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE
) {

    $image = $_FILES['image'];


    // ----------------------------
    // Check upload error
    // ----------------------------

    if ($image['error'] !== UPLOAD_ERR_OK) {
        die("Kuna tatizo wakati wa kupakia picha.");
    }


    // ----------------------------
    // Allowed MIME types
    // ----------------------------

    $allowed_types = [
        'image/jpeg',
        'image/png',
        'image/webp'
    ];


    // ----------------------------
    // Check MIME type
    // ----------------------------

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = $finfo ? finfo_file($finfo, $image['tmp_name']) : false;
    if ($finfo) {
        finfo_close($finfo);
    }

    if (!is_uploaded_file($image['tmp_name']) || !in_array($mime_type, $allowed_types, true)) {
        die("Picha lazima iwe JPG, PNG au WEBP.");
    }


    // ----------------------------
    // Maximum 5MB
    // ----------------------------

    if ($image['size'] > 5 * 1024 * 1024) {
        die("Picha ni kubwa sana. Maximum ni 5MB.");
    }


    // ----------------------------
    // Get extension
    // ----------------------------

    $extension = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
    ][$mime_type];


    // ----------------------------
    // Create unique filename
    // ----------------------------

    $new_image_name =
        time() . "_" .
        uniqid() . "." .
        $extension;


    // ----------------------------
    // Image path
    // ----------------------------

    $image_path = "images/" . $new_image_name;
    $image_file_path = __DIR__ . DIRECTORY_SEPARATOR . $image_path;


    // ----------------------------
    // Upload image
    // ----------------------------

    if (!move_uploaded_file(
        $image['tmp_name'],
        $image_file_path
    )) {
        die("Picha mpya haikuweza kuhifadhiwa.");
    }


    // ----------------------------
    // Use new image
    // ----------------------------

    $new_image = $image_path;

}


// ================================
// 9. UPDATE DATABASE
// ================================

$sql = "UPDATE vehicles SET
        name = ?,
        brand = ?,
        model = ?,
        year = ?,
        price = ?,
        type = ?,
        description = ?,
        image = ?,
        status = ?
        WHERE id = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Database error: " . $conn->error);
}


$stmt->bind_param(
    "sssidssssi",
    $name,
    $brand,
    $model,
    $year,
    $price,
    $type,
    $description,
    $new_image,
    $status,
    $id
);


// ================================
// 10. EXECUTE UPDATE
// ================================

if ($stmt->execute()) {


    // ============================
    // DELETE OLD IMAGE
    // ============================

    if (
        $new_image !== $current_image &&
        !empty($current_image) &&
        ($uploads_directory = realpath(__DIR__ . '/images')) !== false &&
        ($current_image_path = realpath(__DIR__ . DIRECTORY_SEPARATOR . $current_image)) !== false &&
        strpos($current_image_path, $uploads_directory . DIRECTORY_SEPARATOR) === 0 &&
        is_file($current_image_path)
    ) {

        unlink($current_image_path);

    }


    // ============================
    // GO BACK TO ADMIN
    // ============================

    header("Location: admin.php");

    exit;

} else {

    if (isset($image_file_path) && is_file($image_file_path)) {
        unlink($image_file_path);
    }

    echo "Kuna tatizo: " . $stmt->error;

}


$stmt->close();

$conn->close();

?>
