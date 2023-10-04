<?php session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="shortcut icon" href="./images/ICT-log.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
    <?php include "./css/style.css";
    ?>
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
                <h1 class="title">Company Details</h1>
            </div>
            <div class="dashboard_container">
                <!-- <a href="./research_paper/rp_output.php">
                    <div class="dashboard_img">
                        <img style="width:50%;margin-left:25%;" src="./images/research_paper.png" alt="Research Paper">
                        <h2>Research Paper</h2>
                    </div>
                </a> -->
                <!-- <a href="./faculty_participation/fp_output.php">
                    <div class="dashboard_img">
                        <img style="width:50%;margin-left:25%;" src="./images/faculty_participation.png"
                            alt="Research Paper">
                        <h2>Student Participation</h2>
                    </div>
                </a> -->
                <a href="./ipr_patent/ipr_output.php">
                    <div class="dashboard_img">
                        <img style="width:50%;margin-left:25%;" src="./images/ipr_patent.png" alt="Research Paper">
                        <h2>Company Details</h2>
                    </div>
                </a>
            </div>
        </div>
    </div>

</body>

</html>