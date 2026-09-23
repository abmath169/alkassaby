<?php

session_start();

require_once "database.php";

$error = "";

if (isset($_SESSION['admin_logged_in'])) {
    header("Location: admin.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM admins WHERE username = ?";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Database error: " . $conn->error);
    }

    $stmt->bind_param("s", $username);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

        $admin = $result->fetch_assoc();

        if (password_verify($password, $admin['password'])) {

            session_regenerate_id(true);

            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];

            header("Location: admin.php");
            exit;

        } else {

            $error = "Username au password sio sahihi.";

        }

    } else {

        $error = "Username au password sio sahihi.";

    }

    $stmt->close();
    $conn->close();
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

<title>Admin Login | AL-KASSABY</title>


<style>

/* =====================================================
   AL-KASSABY ADMIN LOGIN
   Modern Shadcn-Inspired UI
===================================================== */

:root {

    --background: #0a0a0a;
    --foreground: #fafafa;

    --card: #111111;
    --card-foreground: #fafafa;

    --muted: #181818;
    --muted-foreground: #a1a1aa;

    --border: #27272a;

    --gold: #D4A648;
    --gold-light: #E5C06A;
    --gold-dark: #B88A2F;

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

    font-family:
        Inter,
        ui-sans-serif,
        system-ui,
        -apple-system,
        BlinkMacSystemFont,
        "Segoe UI",
        sans-serif;

    background:
        radial-gradient(
            circle at top,
            rgba(212, 166, 72, 0.09),
            transparent 35%
        ),
        var(--background);

    color: var(--foreground);

    display: flex;

    align-items: center;

    justify-content: center;

    padding: 24px;
}


/* =====================================================
   LOGIN WRAPPER
===================================================== */

.login-wrapper {

    width: 100%;

    max-width: 430px;
}


/* =====================================================
   BRAND
===================================================== */

.brand {

    text-align: center;

    margin-bottom: 28px;
}


/* =====================================================
   LOGO
===================================================== */

.brand-logo {

    width: 90px;

    height: 90px;

    margin: 0 auto 16px;

    display: flex;

    align-items: center;

    justify-content: center;

    background: transparent;

    border-radius: 16px;

    overflow: hidden;
}


.brand-logo img {

    width: 100%;

    height: 100%;

    object-fit: contain;

    display: block;
}


/* =====================================================
   BRAND NAME
===================================================== */

.brand h1 {

    font-size: 25px;

    font-weight: 700;

    letter-spacing: -0.5px;

    margin-bottom: 6px;
}


.brand p {

    color: var(--muted-foreground);

    font-size: 14px;
}


/* =====================================================
   LOGIN CARD
===================================================== */

.login-card {

    background:
        rgba(17, 17, 17, 0.96);

    border: 1px solid var(--border);

    border-radius: var(--radius);

    padding: 30px;

    box-shadow:
        0 20px 50px
        rgba(0, 0, 0, 0.45);

    backdrop-filter: blur(10px);
}


/* =====================================================
   CARD HEADER
===================================================== */

.card-header {

    margin-bottom: 26px;
}


.card-header h2 {

    font-size: 20px;

    font-weight: 600;

    letter-spacing: -0.3px;

    margin-bottom: 7px;
}


.card-header p {

    color: var(--muted-foreground);

    font-size: 14px;

    line-height: 1.5;
}


/* =====================================================
   ERROR MESSAGE
===================================================== */

.error-message {

    display: flex;

    align-items: center;

    gap: 10px;

    background:
        rgba(239, 68, 68, 0.08);

    border:
        1px solid
        rgba(239, 68, 68, 0.25);

    color: #fca5a5;

    padding: 12px 14px;

    border-radius: 8px;

    font-size: 13px;

    margin-bottom: 20px;
}


/* =====================================================
   FORM GROUP
===================================================== */

.form-group {

    margin-bottom: 20px;
}


.form-group label {

    display: block;

    font-size: 13px;

    font-weight: 500;

    margin-bottom: 8px;

    color: #e4e4e7;
}


/* =====================================================
   INPUT WRAPPER
===================================================== */

.input-wrapper {

    position: relative;
}


.input-wrapper span {

    position: absolute;

    left: 14px;

    top: 50%;

    transform: translateY(-50%);

    color: #71717a;

    font-size: 15px;

    pointer-events: none;
}


/* =====================================================
   INPUT
===================================================== */

input {

    width: 100%;

    height: 44px;

    background: #0a0a0a;

    border: 1px solid var(--border);

    border-radius: 8px;

    padding:
        0
        14px
        0
        40px;

    color: var(--foreground);

    font-size: 14px;

    outline: none;

    transition:
        border-color 0.2s ease,
        box-shadow 0.2s ease,
        background 0.2s ease;
}


input::placeholder {

    color: #52525b;
}


input:hover {

    border-color: #3f3f46;
}


input:focus {

    border-color: var(--gold);

    background: #0d0d0d;

    box-shadow:
        0 0 0 3px
        rgba(212, 166, 72, 0.12);
}


/* =====================================================
   LOGIN BUTTON
===================================================== */

.login-button {

    width: 100%;

    height: 44px;

    border: none;

    border-radius: 8px;

    background: var(--gold);

    color: #111111;

    font-size: 14px;

    font-weight: 600;

    cursor: pointer;

    transition:
        background 0.2s ease,
        transform 0.2s ease,
        box-shadow 0.2s ease;
}


.login-button:hover {

    background: var(--gold-light);

    box-shadow:
        0 8px 20px
        rgba(212, 166, 72, 0.16);

    transform: translateY(-1px);
}


.login-button:active {

    transform: translateY(0);
}


/* =====================================================
   FOOTER
===================================================== */

.login-footer {

    text-align: center;

    margin-top: 24px;

    color: #71717a;

    font-size: 12px;
}


.login-footer strong {

    color: var(--gold);

    font-weight: 600;
}


/* =====================================================
   MOBILE RESPONSIVE
===================================================== */

@media (max-width: 480px) {

    body {

        padding: 18px;
    }


    .login-card {

        padding: 24px 20px;
    }


    .brand {

        margin-bottom: 22px;
    }


    .brand h1 {

        font-size: 22px;
    }


    .brand-logo {

        width: 75px;

        height: 75px;
    }
}

</style>

</head>


<body>


<div class="login-wrapper">


    <!-- =================================================
         BRAND / LOGO
    ================================================== -->

    <div class="brand">

        <div class="brand-logo">

            <img
                src="images/logo.png"
                alt="AL-KASSABY Logo"
            >

        </div>


        <h1>
            AL-KASSABY
        </h1>


        <p>
            Vehicle Showroom Management
        </p>

    </div>



    <!-- =================================================
         LOGIN CARD
    ================================================== -->

    <div class="login-card">


        <div class="card-header">

            <h2>
                Karibu tena
            </h2>

            <p>
                Ingia kwenye dashboard yako ya usimamizi.
            </p>

        </div>



        <!-- =================================================
             ERROR MESSAGE
        ================================================== -->

        <?php if ($error != "") { ?>

            <div class="error-message">

                <span>⚠</span>

                <span>
                    <?php
                    echo htmlspecialchars($error);
                    ?>
                </span>

            </div>

        <?php } ?>



        <!-- =================================================
             LOGIN FORM
        ================================================== -->

        <form method="POST">


            <!-- USERNAME -->

            <div class="form-group">

                <label for="username">
                    Username
                </label>


                <div class="input-wrapper">

                    <span>👤</span>


                    <input
                        type="text"
                        id="username"
                        name="username"
                        placeholder="Ingiza username yako"
                        autocomplete="username"
                        required
                    >

                </div>

            </div>



            <!-- PASSWORD -->

            <div class="form-group">

                <label for="password">
                    Password
                </label>


                <div class="input-wrapper">

                    <span>🔒</span>


                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Ingiza password yako"
                        autocomplete="current-password"
                        required
                    >

                </div>

            </div>



            <!-- LOGIN BUTTON -->

            <button
                type="submit"
                class="login-button"
            >

                Ingia kwenye Dashboard

            </button>


        </form>


    </div>



    <!-- =================================================
         FOOTER
    ================================================== -->

    <div class="login-footer">

        © <?php echo date("Y"); ?>

        <strong>
            AL-KASSABY
        </strong>

        · Admin Panel

    </div>


</div>


</body>

</html>