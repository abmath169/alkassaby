<?php

require_once "auth.php";
require_once "database.php";

$sql = "SELECT * FROM vehicles ORDER BY id DESC";

$result = $conn->query($sql);

if (!$result) {
    die("Database error: " . $conn->error);
}

?>

<!DOCTYPE html>

<html lang="sw">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>Admin Dashboard | AL-KASSABY</title>


<style>

/* =====================================================
   AL-KASSABY ADMIN DASHBOARD
   Modern Shadcn-Inspired UI
===================================================== */

:root {

    --background: #0a0a0a;
    --foreground: #fafafa;

    --card: #111111;
    --muted: #181818;
    --muted-hover: #222222;

    --muted-foreground: #a1a1aa;

    --border: #27272a;

    --gold: #D4A648;
    --gold-light: #E5C06A;
    --gold-dark: #B88A2F;

    --success: #22c55e;
    --success-bg: rgba(34, 197, 94, 0.10);

    --danger: #ef4444;
    --danger-bg: rgba(239, 68, 68, 0.10);

    --warning: #f59e0b;
    --warning-bg: rgba(245, 158, 11, 0.10);

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

    max-width: 1450px;

    margin: 0 auto;
}


/* =====================================================
   TOP BAR
===================================================== */

.top-bar {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 20px;

    margin-bottom: 25px;
}


.top-bar h1 {

    font-size: 27px;

    font-weight: 700;

    letter-spacing: -0.6px;
}


.top-bar p {

    color: var(--muted-foreground);

    font-size: 14px;

    margin-top: 6px;
}


.top-actions {

    display: flex;

    align-items: center;

    gap: 10px;
}


/* =====================================================
   BUTTONS
===================================================== */

.btn {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 7px;

    height: 40px;

    padding: 0 15px;

    border-radius: 8px;

    font-size: 13px;

    font-weight: 600;

    text-decoration: none;

    cursor: pointer;

    transition: 0.2s ease;
}


/* ADD */

.add-btn {

    background: var(--gold);

    color: #111111;

    border: 1px solid var(--gold);
}


.add-btn:hover {

    background: var(--gold-light);

    box-shadow:
        0 8px 20px
        rgba(212, 166, 72, 0.16);

    transform: translateY(-1px);
}


/* LOGOUT */

.logout-btn {

    background: var(--muted);

    color: #d4d4d8;

    border: 1px solid var(--border);
}


.logout-btn:hover {

    background: var(--danger-bg);

    border-color:
        rgba(239, 68, 68, 0.30);

    color: #fca5a5;
}


/* =====================================================
   TABLE CARD
===================================================== */

.table-card {

    background:
        rgba(17, 17, 17, 0.96);

    border: 1px solid var(--border);

    border-radius: var(--radius);

    overflow: hidden;

    box-shadow:
        0 20px 50px
        rgba(0, 0, 0, 0.40);
}


/* =====================================================
   TABLE WRAPPER
===================================================== */

.table-wrapper {

    width: 100%;

    overflow-x: auto;
}


/* =====================================================
   TABLE
===================================================== */

table {

    width: 100%;

    border-collapse: collapse;

    min-width: 1050px;
}


/* =====================================================
   TABLE HEAD
===================================================== */

thead {

    background: #0d0d0d;
}


th {

    text-align: left;

    padding: 14px 16px;

    border-bottom: 1px solid var(--border);

    color: #a1a1aa;

    font-size: 11px;

    font-weight: 600;

    text-transform: uppercase;

    letter-spacing: 0.06em;

    white-space: nowrap;
}


/* =====================================================
   TABLE BODY
===================================================== */

td {

    padding: 15px 16px;

    border-bottom: 1px solid var(--border);

    color: #e4e4e7;

    font-size: 13px;

    vertical-align: middle;
}


tbody tr {

    transition:
        background 0.2s ease;
}


tbody tr:hover {

    background: rgba(255, 255, 255, 0.025);
}


tbody tr:last-child td {

    border-bottom: none;
}


/* =====================================================
   VEHICLE IMAGE
===================================================== */

.vehicle-image {

    width: 72px;

    height: 50px;

    object-fit: cover;

    border-radius: 7px;

    border: 1px solid var(--border);

    display: block;
}


/* =====================================================
   PRICE
===================================================== */

.price {

    color: var(--gold);

    font-weight: 600;

    white-space: nowrap;
}


/* =====================================================
   STATUS
===================================================== */

.status-badge {

    display: inline-flex;

    align-items: center;

    gap: 8px;

    min-width: 105px;

    padding: 7px 10px;

    border-radius: 999px;

    font-size: 12px;

    font-weight: 500;

    white-space: nowrap;
}


/* STATUS DOT */

.status-dot {

    width: 8px;

    height: 8px;

    border-radius: 50%;

    flex-shrink: 0;
}


/* AVAILABLE */

.status-available {

    background: var(--success-bg);

    color: #86efac;

    border: 1px solid
        rgba(34, 197, 94, 0.18);
}


.status-available .status-dot {

    background: var(--success);

    box-shadow:
        0 0 0 3px
        rgba(34, 197, 94, 0.12);
}


/* SOLD */

.status-sold {

    background: var(--danger-bg);

    color: #fca5a5;

    border: 1px solid
        rgba(239, 68, 68, 0.18);
}


.status-sold .status-dot {

    background: var(--danger);

    box-shadow:
        0 0 0 3px
        rgba(239, 68, 68, 0.10);
}


/* RESERVED */

.status-reserved {

    background: var(--warning-bg);

    color: #fcd34d;

    border: 1px solid
        rgba(245, 158, 11, 0.18);
}


.status-reserved .status-dot {

    background: var(--warning);

    box-shadow:
        0 0 0 3px
        rgba(245, 158, 11, 0.10);
}


/* OTHER STATUS */

.status-other {

    background: var(--muted);

    color: #d4d4d8;

    border: 1px solid var(--border);
}


.status-other .status-dot {

    background: #71717a;
}


/* =====================================================
   ACTIONS
===================================================== */

.actions {

    display: flex;

    align-items: center;

    gap: 7px;
}


/* EDIT */

.edit-btn {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    height: 34px;

    padding: 0 12px;

    border-radius: 7px;

    background:
        rgba(212, 166, 72, 0.08);

    border: 1px solid
        rgba(212, 166, 72, 0.20);

    color: var(--gold-light);

    font-size: 12px;

    font-weight: 600;

    text-decoration: none;

    transition: 0.2s ease;
}


.edit-btn:hover {

    background:
        rgba(212, 166, 72, 0.16);

    border-color:
        rgba(212, 166, 72, 0.35);
}


/* DELETE */

.delete-btn {

    height: 34px;

    padding: 0 12px;

    border-radius: 7px;

    background:
        rgba(239, 68, 68, 0.07);

    border: 1px solid
        rgba(239, 68, 68, 0.20);

    color: #fca5a5;

    font-size: 12px;

    font-weight: 600;

    cursor: pointer;

    transition: 0.2s ease;
}


.delete-btn:hover {

    background:
        rgba(239, 68, 68, 0.14);

    border-color:
        rgba(239, 68, 68, 0.35);
}


/* =====================================================
   EMPTY MESSAGE
===================================================== */

.empty-message {

    text-align: center;

    padding: 50px 20px;

    color: var(--muted-foreground);
}


/* =====================================================
   FOOTER
===================================================== */

.dashboard-footer {

    text-align: center;

    color: #52525b;

    font-size: 12px;

    margin-top: 20px;
}


/* =====================================================
   MOBILE
===================================================== */

@media (max-width: 768px) {

    body {

        padding: 18px;
    }


    .top-bar {

        align-items: flex-start;

        flex-direction: column;
    }


    .top-actions {

        width: 100%;
    }


    .top-actions .btn {

        flex: 1;
    }


    .top-bar h1 {

        font-size: 23px;
    }


    .table-card {

        border-radius: 10px;
    }
}


@media (max-width: 480px) {

    .top-actions {

        flex-direction: column;
    }


    .top-actions .btn {

        width: 100%;
    }
}

</style>

</head>


<body>


<div class="container">


    <!-- =================================================
         TOP BAR
    ================================================== -->

    <div class="top-bar">


        <div>

            <h1>
                AL-KASSABY Admin
            </h1>

            <p>
                Simamia magari yako kutoka hapa.
            </p>

        </div>


        <div class="top-actions">


            <a
                href="add_vehicle.php"
                class="btn add-btn"
            >
                + Ongeza Gari
            </a>


            <a
                href="logout.php"
                class="btn logout-btn"
            >
                Logout
            </a>


        </div>


    </div>



    <!-- =================================================
         TABLE
    ================================================== -->

    <div class="table-card">


        <div class="table-wrapper">


            <table>


                <thead>

                    <tr>

                        <th>ID</th>

                        <th>Picha</th>

                        <th>Gari</th>

                        <th>Brand</th>

                        <th>Model</th>

                        <th>Mwaka</th>

                        <th>Bei</th>

                        <th>Type</th>

                        <th>Status</th>

                        <th>Action</th>

                    </tr>

                </thead>


                <tbody>


                <?php if ($result->num_rows > 0) { ?>


                    <?php while ($vehicle = $result->fetch_assoc()) { ?>


                        <tr>


                            <!-- ID -->

                            <td>

                                <?php
                                echo (int) $vehicle['id'];
                                ?>

                            </td>



                            <!-- IMAGE -->

                            <td>

                                <img
                                    src="<?php
                                    echo htmlspecialchars(
                                        $vehicle['image']
                                    );
                                    ?>"
                                    class="vehicle-image"
                                    alt="<?php
                                    echo htmlspecialchars(
                                        $vehicle['name']
                                    );
                                    ?>"
                                >

                            </td>



                            <!-- NAME -->

                            <td>

                                <strong>
                                    <?php
                                    echo htmlspecialchars(
                                        $vehicle['name']
                                    );
                                    ?>
                                </strong>

                            </td>



                            <!-- BRAND -->

                            <td>

                                <?php
                                echo htmlspecialchars(
                                    $vehicle['brand']
                                );
                                ?>

                            </td>



                            <!-- MODEL -->

                            <td>

                                <?php
                                echo htmlspecialchars(
                                    $vehicle['model']
                                );
                                ?>

                            </td>



                            <!-- YEAR -->

                            <td>

                                <?php
                                echo (int) $vehicle['year'];
                                ?>

                            </td>



                            <!-- PRICE -->

                            <td class="price">

                                Tsh
                                <?php
                                echo number_format(
                                    $vehicle['price'],
                                    0
                                );
                                ?>

                            </td>



                            <!-- TYPE -->

                            <td>

                                <?php
                                echo htmlspecialchars(
                                    $vehicle['type']
                                );
                                ?>

                            </td>



                            <!-- STATUS -->

                            <td>

                                <?php

                                $status = $vehicle['status'];

                                if ($status === 'Available') {

                                    $status_class =
                                        'status-available';

                                } elseif ($status === 'Sold') {

                                    $status_class =
                                        'status-sold';

                                } elseif ($status === 'Reserved') {

                                    $status_class =
                                        'status-reserved';

                                } else {

                                    $status_class =
                                        'status-other';

                                }

                                ?>


                                <span
                                    class="status-badge <?php
                                    echo $status_class;
                                    ?>"
                                >

                                    <span
                                        class="status-dot"
                                    ></span>


                                    <?php

                                    echo htmlspecialchars(
                                        $status
                                    );

                                    ?>

                                </span>

                            </td>



                            <!-- ACTION -->

                            <td>


                                <div class="actions">


                                    <!-- EDIT -->

                                    <a
                                        href="edit_vehicle.php?id=<?php
                                        echo (int) $vehicle['id'];
                                        ?>"
                                        class="edit-btn"
                                    >
                                        Edit
                                    </a>



                                    <!-- DELETE -->

                                    <form
                                        action="delete_vehicle.php"
                                        method="POST"
                                        style="display:inline;"
                                        onsubmit="return confirm(
                                            'Una uhakika unataka kufuta gari hili?'
                                        );"
                                    >


                                        <input
                                            type="hidden"
                                            name="id"
                                            value="<?php
                                            echo (int) $vehicle['id'];
                                            ?>"
                                        >


                                        <input
                                            type="hidden"
                                            name="csrf_token"
                                            value="<?php
                                            echo htmlspecialchars(
                                                $_SESSION['csrf_token']
                                            );
                                            ?>"
                                        >


                                        <button
                                            type="submit"
                                            class="delete-btn"
                                        >
                                            Delete
                                        </button>


                                    </form>


                                </div>


                            </td>


                        </tr>


                    <?php } ?>


                <?php } else { ?>


                    <tr>

                        <td
                            colspan="10"
                            class="empty-message"
                        >
                            Hakuna magari yaliyowekwa
                            kwenye database.
                        </td>

                    </tr>


                <?php } ?>


                </tbody>


            </table>


        </div>


    </div>



    <!-- FOOTER -->

    <div class="dashboard-footer">

        © <?php echo date("Y"); ?>

        AL-KASSABY · Admin Dashboard

    </div>


</div>


</body>

</html>
