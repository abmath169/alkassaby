<?php

require_once "auth.php";
require_once "database.php";

?>

<!DOCTYPE html>

<html lang="sw">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Ongeza Gari | Al Kassaby</title>


    <style>

        /* =========================================
           ROOT
        ========================================= */

        :root {

            --gold: #D4A648;
            --gold-light: #E5C06A;

            --background: #0a0a0a;
            --foreground: #fafafa;

            --card: #111111;

            --muted: #181818;
            --muted-foreground: #a1a1aa;

            --border: #27272a;

            --danger: #ef4444;

            --radius: 10px;

        }


        /* =========================================
           RESET
        ========================================= */

        * {

            margin: 0;
            padding: 0;

            box-sizing: border-box;

        }


        /* =========================================
           BODY
        ========================================= */

        body {

            min-height: 100vh;

            background: var(--background);

            color: var(--foreground);

            font-family:
                Inter,
                ui-sans-serif,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            line-height: 1.5;

        }


        /* =========================================
           PAGE
        ========================================= */

        .page {

            width: 100%;

            max-width: 850px;

            margin: 0 auto;

            padding: 40px 24px;

        }


        /* =========================================
           HEADER
        ========================================= */

        .header {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

            margin-bottom: 25px;

        }


        .header h1 {

            font-size: 26px;

            font-weight: 700;

            letter-spacing: -0.5px;

        }


        .header p {

            margin-top: 5px;

            color: var(--muted-foreground);

            font-size: 14px;

        }


        /* =========================================
           BACK BUTTON
        ========================================= */

        .back-btn {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            height: 38px;

            padding: 0 14px;

            border: 1px solid var(--border);

            border-radius: var(--radius);

            background: transparent;

            color: var(--foreground);

            text-decoration: none;

            font-size: 14px;

            transition: 0.2s ease;

        }


        .back-btn:hover {

            background: var(--muted);

            border-color: #3f3f46;

        }


        /* =========================================
           CARD
        ========================================= */

        .form-card {

            background: var(--card);

            border: 1px solid var(--border);

            border-radius: var(--radius);

            padding: 28px;

        }


        /* =========================================
           FORM GRID
        ========================================= */

        .form-grid {

            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 20px;

        }


        .form-group {

            display: flex;

            flex-direction: column;

            gap: 7px;

        }


        .full-width {

            grid-column: 1 / -1;

        }


        /* =========================================
           LABEL
        ========================================= */

        label {

            font-size: 14px;

            font-weight: 500;

            color: var(--foreground);

        }


        /* =========================================
           INPUT
        ========================================= */

        input,
        select,
        textarea {

            width: 100%;

            border: 1px solid var(--border);

            border-radius: 8px;

            background: #09090b;

            color: var(--foreground);

            padding: 10px 12px;

            font-size: 14px;

            font-family: inherit;

            transition:
                border-color 0.2s ease,
                box-shadow 0.2s ease;

        }


        input,
        select {

            height: 40px;

        }


        textarea {

            min-height: 120px;

            resize: vertical;

        }


        /* =========================================
           PLACEHOLDER
        ========================================= */

        input::placeholder,
        textarea::placeholder {

            color: #71717a;

        }


        /* =========================================
           FOCUS
        ========================================= */

        input:focus,
        select:focus,
        textarea:focus {

            outline: none;

            border-color: var(--gold);

            box-shadow:
                0 0 0 2px rgba(212, 166, 72, 0.15);

        }


        /* =========================================
           FILE INPUT
        ========================================= */

        input[type="file"] {

            height: auto;

            padding: 9px;

            cursor: pointer;

        }


        input[type="file"]::file-selector-button {

            margin-right: 10px;

            padding: 7px 11px;

            border: 1px solid var(--border);

            border-radius: 6px;

            background: var(--muted);

            color: var(--foreground);

            cursor: pointer;

        }


        input[type="file"]::file-selector-button:hover {

            border-color: var(--gold);

        }


        /* =========================================
           HELP TEXT
        ========================================= */

        .help-text {

            color: var(--muted-foreground);

            font-size: 12px;

        }


        /* =========================================
           FORM ACTIONS
        ========================================= */

        .form-actions {

            display: flex;

            justify-content: flex-end;

            gap: 10px;

            margin-top: 28px;

            padding-top: 22px;

            border-top: 1px solid var(--border);

        }


        /* =========================================
           CANCEL BUTTON
        ========================================= */

        .cancel-btn {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            height: 40px;

            padding: 0 16px;

            border: 1px solid var(--border);

            border-radius: var(--radius);

            background: transparent;

            color: var(--foreground);

            text-decoration: none;

            font-size: 14px;

            cursor: pointer;

        }


        .cancel-btn:hover {

            background: var(--muted);

        }


        /* =========================================
           SAVE BUTTON
        ========================================= */

        .save-btn {

            height: 40px;

            padding: 0 18px;

            border: 1px solid var(--gold);

            border-radius: var(--radius);

            background: var(--gold);

            color: #111111;

            font-size: 14px;

            font-weight: 600;

            cursor: pointer;

            transition: 0.2s ease;

        }


        .save-btn:hover {

            background: var(--gold-light);

            border-color: var(--gold-light);

        }


        .save-btn:active {

            transform: translateY(1px);

        }


        /* =========================================
           REQUIRED
        ========================================= */

        input:required,
        select:required,
        textarea:required {

            accent-color: var(--gold);

        }


        /* =========================================
           MOBILE
        ========================================= */

        @media (max-width: 650px) {

            .page {

                padding: 25px 15px;

            }


            .header {

                align-items: flex-start;

                flex-direction: column;

            }


            .header h1 {

                font-size: 22px;

            }


            .back-btn {

                width: 100%;

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


            .form-actions {

                flex-direction: column-reverse;

            }


            .cancel-btn,
            .save-btn {

                width: 100%;

            }

        }

    </style>

</head>


<body>


<div class="page">


    <!-- =========================================
         HEADER
    ========================================== -->

    <div class="header">

        <div>

            <h1>Ongeza Gari Jipya</h1>

            <p>
                Weka taarifa za gari litakaloonekana kwenye showroom.
            </p>

        </div>


        <a
            href="admin.php"
            class="back-btn"
        >
            ← Rudi Dashboard
        </a>

    </div>



    <!-- =========================================
         FORM CARD
    ========================================== -->

    <div class="form-card">


        <form
            action="save_vehicle.php"
            method="POST"
            enctype="multipart/form-data"
        >


            <!-- CSRF TOKEN -->

            <input
                type="hidden"
                name="csrf_token"
                value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>"
            >


            <div class="form-grid">


                <!-- =================================
                     NAME
                ================================== -->

                <div class="form-group full-width">

                    <label for="name">
                        Jina la Gari
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        placeholder="Mfano: Toyota Harrier"
                        required
                    >

                </div>



                <!-- =================================
                     BRAND
                ================================== -->

                <div class="form-group">

                    <label for="brand">
                        Brand
                    </label>

                    <input
                        type="text"
                        id="brand"
                        name="brand"
                        placeholder="Mfano: Toyota"
                        required
                    >

                </div>



                <!-- =================================
                     MODEL
                ================================== -->

                <div class="form-group">

                    <label for="model">
                        Model
                    </label>

                    <input
                        type="text"
                        id="model"
                        name="model"
                        placeholder="Mfano: Harrier"
                        required
                    >

                </div>



                <!-- =================================
                     YEAR
                ================================== -->

                <div class="form-group">

                    <label for="year">
                        Mwaka
                    </label>

                    <input
                        type="number"
                        id="year"
                        name="year"
                        placeholder="Mfano: 2026"
                        min="1900"
                        max="2100"
                        required
                    >

                </div>



                <!-- =================================
                     PRICE
                ================================== -->

                <div class="form-group">

                    <label for="price">
                        Bei (Tsh)
                    </label>

                    <input
                        type="number"
                        id="price"
                        name="price"
                        placeholder="Mfano: 55000000"
                        min="0"
                        required
                    >

                    <span class="help-text">
                        Weka bei bila comma. Mfano: 55000000
                    </span>

                </div>



                <!-- =================================
                     TYPE
                ================================== -->

                <div class="form-group">

                    <label for="type">
                        Aina ya Gari
                    </label>

                    <select
                        id="type"
                        name="type"
                        required
                    >

                        <option value="SUV">
                            SUV
                        </option>

                        <option value="Sport">
                            Sport
                        </option>

                        <option value="Executive">
                            Executive
                        </option>

                        <option value="Sedan">
                            Sedan
                        </option>

                        <option value="Hatchback">
                            Hatchback
                        </option>

                    </select>

                </div>



                <!-- =================================
                     STATUS
                ================================== -->

                <div class="form-group">

                    <label for="status">
                        Status
                    </label>

                    <select
                        id="status"
                        name="status"
                        required
                    >

                        <option value="Available">
                            Available
                        </option>

                        <option value="Sold">
                            Sold
                        </option>

                    </select>

                </div>



                <!-- =================================
                     DESCRIPTION
                ================================== -->

                <div class="form-group full-width">

                    <label for="description">
                        Maelezo ya Gari
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        placeholder="Andika maelezo kuhusu gari..."
                        required
                    ></textarea>

                </div>



                <!-- =================================
                     IMAGE
                ================================== -->

                <div class="form-group full-width">

                    <label for="image">
                        Picha ya Gari
                    </label>

                    <input
                        type="file"
                        id="image"
                        name="image"
                        accept="image/jpeg,image/png,image/webp"
                        required
                    >

                    <span class="help-text">
                        JPG, PNG au WEBP. Maximum 5MB.
                    </span>

                </div>


            </div>



            <!-- =================================
                 ACTIONS
            ================================== -->

            <div class="form-actions">

                <a
                    href="admin.php"
                    class="cancel-btn"
                >
                    Cancel
                </a>


                <button
                    type="submit"
                    class="save-btn"
                >
                    + Ongeza Gari
                </button>

            </div>


        </form>


    </div>


</div>


</body>

</html>