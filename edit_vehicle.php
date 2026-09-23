<?php

require_once "auth.php";
require_once "database.php";

if (!isset($_GET['id'])) {
    die("ID ya gari haijapatikana.");
}

$id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

if ($id === false || $id <= 0) {
    die("ID ya gari si sahihi.");
}

$sql = "SELECT * FROM vehicles WHERE id = ?";

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

$stmt->close();

?>

<!DOCTYPE html>

<html lang="sw">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>Hariri Gari | AL-KASSABY</title>


<style>

/* =====================================================
   AL-KASSABY EDIT VEHICLE
   Modern Shadcn-Inspired UI
===================================================== */

:root {

    --background: #0a0a0a;
    --foreground: #fafafa;

    --card: #111111;
    --muted: #181818;

    --muted-foreground: #a1a1aa;

    --border: #27272a;

    --gold: #D4A648;
    --gold-light: #E5C06A;
    --gold-dark: #B88A2F;

    --success: #22c55e;
    --success-bg: rgba(34, 197, 94, 0.10);

    --danger: #ef4444;

    --radius: 12px;
}


/* =====================================================
   RESET
===================================================== */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}


/* =====================================================
   BODY
===================================================== */

body {

    min-height: 100vh;

    background:
        radial-gradient(
            circle at top,
            rgba(212, 166, 72, 0.08),
            transparent 35%
        ),
        var(--background);

    color: var(--foreground);

    font-family:
        Inter,
        ui-sans-serif,
        system-ui,
        -apple-system,
        BlinkMacSystemFont,
        "Segoe UI",
        sans-serif;

    padding: 30px;
}


/* =====================================================
   CONTAINER
===================================================== */

.container {

    width: 100%;

    max-width: 1000px;

    margin: 0 auto;
}


/* =====================================================
   HEADER
===================================================== */

.page-header {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 20px;

    margin-bottom: 25px;
}


.page-header h1 {

    font-size: 28px;

    font-weight: 700;

    letter-spacing: -0.6px;
}


.page-header p {

    color: var(--muted-foreground);

    font-size: 14px;

    margin-top: 6px;
}


/* =====================================================
   BACK BUTTON
===================================================== */

.back-btn {

    display: inline-flex;

    align-items: center;

    gap: 8px;

    text-decoration: none;

    color: #d4d4d8;

    background: var(--muted);

    border: 1px solid var(--border);

    padding: 9px 14px;

    border-radius: 8px;

    font-size: 13px;

    transition: 0.2s ease;
}


.back-btn:hover {

    background: #222222;

    border-color: #3f3f46;

    color: white;
}


/* =====================================================
   CARD
===================================================== */

.form-card {

    background:
        rgba(17, 17, 17, 0.96);

    border: 1px solid var(--border);

    border-radius: var(--radius);

    padding: 30px;

    box-shadow:
        0 20px 50px
        rgba(0, 0, 0, 0.40);
}


/* =====================================================
   GRID
===================================================== */

.form-grid {

    display: grid;

    grid-template-columns:
        repeat(2, minmax(0, 1fr));

    gap: 20px;
}


.full-width {

    grid-column: 1 / -1;
}


/* =====================================================
   FORM GROUP
===================================================== */

.form-group {

    display: flex;

    flex-direction: column;

    gap: 8px;
}


.form-group label {

    font-size: 13px;

    font-weight: 500;

    color: #e4e4e7;
}


/* =====================================================
   INPUT / SELECT / TEXTAREA
===================================================== */

input,
select,
textarea {

    width: 100%;

    background: #0a0a0a;

    color: var(--foreground);

    border: 1px solid var(--border);

    border-radius: 8px;

    outline: none;

    font-size: 14px;

    transition:
        border-color 0.2s ease,
        box-shadow 0.2s ease;
}


input,
select {

    height: 44px;

    padding: 0 13px;
}


textarea {

    min-height: 130px;

    padding: 12px 13px;

    resize: vertical;
}


input::placeholder,
textarea::placeholder {

    color: #52525b;
}


input:hover,
select:hover,
textarea:hover {

    border-color: #3f3f46;
}


input:focus,
select:focus,
textarea:focus {

    border-color: var(--gold);

    box-shadow:
        0 0 0 3px
        rgba(212, 166, 72, 0.12);
}


/* =====================================================
   CURRENT IMAGE
===================================================== */

.image-section {

    display: flex;

    align-items: center;

    gap: 20px;

    padding: 16px;

    background: #0a0a0a;

    border: 1px solid var(--border);

    border-radius: 10px;
}


.current-image {

    width: 150px;

    height: 100px;

    object-fit: cover;

    border-radius: 8px;

    border: 1px solid var(--border);
}


.image-info {

    display: flex;

    flex-direction: column;

    gap: 6px;
}


.image-info strong {

    font-size: 14px;
}


.image-info span {

    color: var(--muted-foreground);

    font-size: 12px;
}


/* =====================================================
   STATUS DISPLAY
===================================================== */

.status-preview {

    display: flex;

    align-items: center;

    gap: 9px;

    padding: 10px 12px;

    background: var(--success-bg);

    border: 1px solid
        rgba(34, 197, 94, 0.18);

    border-radius: 8px;

    font-size: 13px;

    color: #d4d4d8;
}


.status-dot {

    width: 9px;

    height: 9px;

    border-radius: 50%;

    background: var(--success);

    box-shadow:
        0 0 0 3px
        rgba(34, 197, 94, 0.12);
}


/* =====================================================
   BUTTONS
===================================================== */

.actions {

    display: flex;

    justify-content: flex-end;

    gap: 10px;

    margin-top: 28px;

    padding-top: 22px;

    border-top: 1px solid var(--border);
}


.btn {

    height: 42px;

    padding: 0 18px;

    border-radius: 8px;

    font-size: 13px;

    font-weight: 600;

    cursor: pointer;

    text-decoration: none;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    transition: 0.2s ease;
}


.btn-cancel {

    background: var(--muted);

    border: 1px solid var(--border);

    color: #d4d4d8;
}


.btn-cancel:hover {

    background: #222222;

    border-color: #3f3f46;
}


.btn-save {

    background: var(--gold);

    border: 1px solid var(--gold);

    color: #111111;
}


.btn-save:hover {

    background: var(--gold-light);

    box-shadow:
        0 8px 20px
        rgba(212, 166, 72, 0.16);

    transform: translateY(-1px);
}


/* =====================================================
   MOBILE
===================================================== */

@media (max-width: 768px) {

    body {
        padding: 18px;
    }

    .page-header {

        flex-direction: column;

        align-items: flex-start;
    }

    .form-card {

        padding: 20px;
    }

    .form-grid {

        grid-template-columns: 1fr;
    }

    .full-width {

        grid-column: auto;
    }

    .image-section {

        flex-direction: column;

        align-items: flex-start;
    }

    .current-image {

        width: 100%;

        max-width: 300px;

        height: 180px;
    }

    .actions {

        flex-direction: column;
    }

    .btn {

        width: 100%;
    }
}

</style>

</head>


<body>


<div class="container">


    <!-- =================================================
         HEADER
    ================================================== -->

    <div class="page-header">

        <div>

            <h1>
                Hariri Gari
            </h1>

            <p>
                Badilisha taarifa za gari lako.
            </p>

        </div>


        <a
            href="admin.php"
            class="back-btn"
        >
            ← Rudi Dashboard
        </a>

    </div>



    <!-- =================================================
         FORM CARD
    ================================================== -->

    <div class="form-card">


        <form
            action="update_vehicle.php"
            method="POST"
            enctype="multipart/form-data"
        >


            <!-- ID -->

            <input
                type="hidden"
                name="id"
                value="<?php echo $vehicle['id']; ?>"
            >


            <!-- CSRF -->

            <input
                type="hidden"
                name="csrf_token"
                value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>"
            >


            <div class="form-grid">


                <!-- NAME -->

                <div class="form-group">

                    <label for="name">
                        Jina la Gari
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="<?php echo htmlspecialchars($vehicle['name']); ?>"
                        required
                    >

                </div>



                <!-- BRAND -->

                <div class="form-group">

                    <label for="brand">
                        Brand
                    </label>

                    <input
                        type="text"
                        id="brand"
                        name="brand"
                        value="<?php echo htmlspecialchars($vehicle['brand']); ?>"
                        required
                    >

                </div>



                <!-- MODEL -->

                <div class="form-group">

                    <label for="model">
                        Model
                    </label>

                    <input
                        type="text"
                        id="model"
                        name="model"
                        value="<?php echo htmlspecialchars($vehicle['model']); ?>"
                        required
                    >

                </div>



                <!-- YEAR -->

                <div class="form-group">

                    <label for="year">
                        Mwaka
                    </label>

                    <input
                        type="number"
                        id="year"
                        name="year"
                        value="<?php echo htmlspecialchars($vehicle['year']); ?>"
                        required
                    >

                </div>



                <!-- PRICE -->

                <div class="form-group">

                    <label for="price">
                        Bei (Tsh)
                    </label>

                    <input
                        type="number"
                        id="price"
                        name="price"
                        value="<?php echo htmlspecialchars($vehicle['price']); ?>"
                        min="0"
                        step="0.01"
                        required
                    >

                </div>



                <!-- TYPE -->

                <div class="form-group">

                    <label for="type">
                        Aina ya Gari
                    </label>

                    <input
                        type="text"
                        id="type"
                        name="type"
                        value="<?php echo htmlspecialchars($vehicle['type']); ?>"
                        required
                    >

                </div>



                <!-- STATUS -->

                <div class="form-group">

                    <label for="status">
                        Status
                    </label>

                    <select
                        id="status"
                        name="status"
                        required
                    >

                        <option
                            value="Available"
                            <?php
                            echo $vehicle['status'] === 'Available'
                                ? 'selected'
                                : '';
                            ?>
                        >
                            Available
                        </option>

                        <option
                            value="Sold"
                            <?php
                            echo $vehicle['status'] === 'Sold'
                                ? 'selected'
                                : '';
                            ?>
                        >
                            Sold
                        </option>

                        <option
                            value="Reserved"
                            <?php
                            echo $vehicle['status'] === 'Reserved'
                                ? 'selected'
                                : '';
                            ?>
                        >
                            Reserved
                        </option>

                    </select>


                    <?php if ($vehicle['status'] === 'Available') { ?>

                        <div class="status-preview">

                            <span class="status-dot"></span>

                            <span>
                                Gari linapatikana
                            </span>

                        </div>

                    <?php } ?>

                </div>



                <!-- DESCRIPTION -->

                <div class="form-group full-width">

                    <label for="description">
                        Maelezo
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        required
                    ><?php echo htmlspecialchars($vehicle['description']); ?></textarea>

                </div>



                <!-- CURRENT IMAGE -->

                <div class="form-group full-width">

                    <label>
                        Picha ya Sasa
                    </label>


                    <div class="image-section">

                        <img
                            src="<?php echo htmlspecialchars($vehicle['image']); ?>"
                            alt="<?php echo htmlspecialchars($vehicle['name']); ?>"
                            class="current-image"
                        >


                        <div class="image-info">

                            <strong>
                                Picha iliyopo sasa
                            </strong>

                            <span>
                                Unaweza kuweka picha mpya hapa chini.
                            </span>

                        </div>

                    </div>

                </div>



                <!-- NEW IMAGE -->

                <div class="form-group full-width">

                    <label for="image">
                        Badilisha Picha
                    </label>

                    <input
                        type="file"
                        id="image"
                        name="image"
                        accept="image/jpeg,image/png,image/webp"
                    >

                </div>


            </div>



            <!-- ACTIONS -->

            <div class="actions">

                <a
                    href="admin.php"
                    class="btn btn-cancel"
                >
                    Cancel
                </a>


                <button
                    type="submit"
                    class="btn btn-save"
                >
                    Hifadhi Mabadiliko
                </button>

            </div>


        </form>


    </div>


</div>


</body>

</html>
