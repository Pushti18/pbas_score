<?php
session_start();

if (isset($_POST['login_enter'])) {
    // Assuming admin123 is the correct ID for admin
    $entered_id = $_POST['id'];

    if ($entered_id === 'admin123') {
        // Redirect to admin dashboard
        header("Location: admin_dashboard.php");
        exit();
    } else {
        // Redirect back to login page
        header("Location: login.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="shortcut icon" href="./images/ICT-log.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>
    <style>
        <?php include "./css/index.css"; ?>
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
</head>

<body>

    <header class="header_container">
        <img class="mulogo_header" src="./images/MU_Logo.png" alt="MU logo">
        <img class="ictlogo_header" src="./images/ICT_logo_text.png" alt="MU logo">
    </header>

    <div class="main_container">
        <div>
            <div class="container">
                <!-- <h1 class="titlne">PBAS</h1> -->
            </div>
            <form method="POST">
                <div class="container">
                    <label for="uname" style="text-alignment:center;"><b>Enter your ID</b></label>
                    <input type="text" placeholder="_ _ _ _ _ _" name="id" maxlength="8" required>

                    <button type="submit" name="login_enter">Login</button>

                </div>
            </form>
        </div>
    </div>

</body>

</html>