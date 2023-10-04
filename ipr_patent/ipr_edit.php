<?php
session_start();
    include('../db_connect.php');
    if(!isset($_POST['submit']))
    {
        $_SESSION['id'] = $_POST['id'];
    }
    $id = $_SESSION['id'];
    $query = "SELECT * from company_info_details where id='".$id."'"; 
    $result = mysqli_query($conn, $query) or die ( mysqli_error());
    $row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Company Details</title>
    <style>
    body {
        font-family: 'Inter', sans-serif;
    }

    .header_container {
        width: 100%;
        display: flex;
    }

    .mulogo_header {
        width: 13%;
        align-content: left;
    }

    .title {
        margin-left: 24.3%;
    }

    .ictlogo_header {
        width: 15%;
        float: right;
        padding-top: 0.5%;
        padding-right: 1%;
        margin-left: 24.3%;
    }


    .container button {
        background-color: #21c8de;
        border-color: #21c8de;
        margin-top: 1%;
        margin-left: 85%;
        margin-bottom: 1%;
        width: 10%;
        height: 35px;
        border-radius: 10px;
    }

    .form_container {
        background-color: #c9e9f4;
        align-items: flex-start;
        padding: 10px;
        position: center;
        width: 90%;
        height: 85%;
        border: 1px solid;
        box-sizing: border-box;
        border-radius: 5px;
        margin-left: 5%;
        font-size: 17px;
    }

    .dd_field {
        margin: 5px;
        width: 358px;
        height: 40px;
    }

    .t_field {
        margin: 5px;
        width: 350px;
        height: 35px;
    }

    .form_table {
        margin-left: 5%;
        margin-right: 4%;
    }

    .form_table td {
        width: 15%;
    }

    .form_table th {
        width: 15%;
        text-align: left;
    }

    .submit_btn {
        margin-left: 50%;
        width: 100px;
        height: 40px;
        background-color: #21c8de;
        border-color: #21c8de;
        text-align: center;
        text-decoration: none;
        font-size: 15px;
        border-radius: 5px;
        margin-bottom: 1%;
    }

    .back_btn {
        background-color: #21c8de;
        border-color: #21c8de;
        width: 7%;
        height: 30px;
        text-align: center;
        text-decoration: none;
        font-size: 15px;
        border-radius: 5px;
        margin-left: 5%;
        margin-bottom: 1%;
    }

    input,
    select,
    textarea {
        border-radius: 10px;
        border-color: white;
    }
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
</head>

<body>

    <div class="form">
        <?php
        // include('db_connect.php');
            $status = "1";
            if(isset($_POST['submit']) && $status==1)
            {
                $company_name = $_POST['company_name'];
                $location = $_POST['location'];
                $type_of_company = $_POST['type_of_company'];
                $job_description = $_POST['job_description'];
                $skills_required = $_POST['skills_required'];
                $website = $_POST['website'];
                $linkedln = $_POST['linkedln'];
                $students_reference = $_POST['students_reference'];
                $salary = $_POST['salary'];
                $reviews = $_POST['reviews'];
                $students_reviews = $_POST['students_reviews'];
                $terms_and_conditions = $_POST['terms_and_conditions'];
                $stipend = $_POST['stipend'];
                $company_size = $_POST['company_size'];
                $update="UPDATE company_info_details SET company_name='$company_name', location='$location', type_of_company='$type_of_company' , job_description='$job_description', skills_required='$skills_required', website='$website', linkedln='$linkedln', students_reference='$students_reference', salary='$salary', reviews='$reviews', students_reviews='$students_reviews', terms_and_conditions='$terms_and_conditions', stipend='$stipend', company_size='$company_size' WHERE id=$id"; 
            mysqli_query($conn, $update) or die(mysqli_error());
            $status = 'Record Updated Successfully'. "</br></br><a href='ipr_output.php'>View Updated Record</a>";
            echo '<p style="color:#FF0000;">'.$status.'</p>';
        }
        ?>
        <header class="header_container">
            <img class="mulogo_header" src="../images/MU_Logo.png" alt="MU logo">
            <h1 class="title">Student Corner</h1>
            <img class="ictlogo_header" src="../images/ICT_logo_text.png" alt="MU logo">
        </header>
        <h2 style="margin-left:45%;">Update Record</h2>
        <div class="container">
            <a href="ipr_output.php"><button class="back_btn">Back</button></a>
        </div>
        <div class="form_container">
            <form method="POST" action="">
                <p style="text-align:center; font-size:80%;"><b>Please ensure that all details are entered, and if
                        certain information is currently unavailable, please use "-" as the placeholder value. Also,
                        kindly ensure that all dropdown menus are filled.</b></p>
                <br>
                <table class="form_table">
                    <tr>
                        <th><label>Company Name</label></th>
                        <td><input type="text" name="company_name" class="t_field"
                                value="<?php echo $row['company_name'];?>"></td>
                        <th><label>Location</label></th>
                        <td><input type="text" name="location" class="t_field" value="<?php echo $row['location'];?>">
                        </td>
                    </tr>


                    <tr>
                        <th><label>Type of Company</label></th>
                        <td>
                            <select id="patent_office" name="type_of_company" class="dd_field">
                                <option value="none" selected disabled hidden>Select an Option</option>
                                <option value="Government of India">Government Of India</option>
                                <option value="MNC">MNC</option>
                            </select>
                        </td>
                        <th><label>Job Description</label></th>
                        <td><input type="text" name="job_description" class="t_field"
                                value="<?php echo $row['job_description'];?>">
                        </td>
                    </tr>

                    <tr>
                        <th><label>Skills Required</label></th>
                        <td><input type="text" name="skills_required" class="t_field"
                                value="<?php echo $row['skills_required'];?>">
                        </td>
                        <th><label>Website</label></th>
                        <td><input type="text" name="website" class="t_field" value="<?php echo $row['website'];?>">
                        </td>
                    </tr>

                    <tr>
                        <th><label>Linkedln</label></th>
                        <td><input type="text" name="linkedln" class="t_field" value="<?php echo $row['linkedln'];?>">
                        </td>
                        <th><label>Students Reference</label></th>
                        <td><input type="text" name="students_reference" class="t_field"
                                value="<?php echo $row['students_reference'];?>"></td>
                    </tr>

                    <tr>
                        <th><label>Salary</label></th>
                        <td><input type="text" name="salary" class="t_field" value="<?php echo $row['salary'];?>"></td>
                        <th><label>Reviews</label></th>
                        <td><input type="text" name="reviews" class="t_field" value="<?php echo $row['reviews'];?>">
                        </td>
                    </tr>

                    <tr>
                        <th><label>Students Reviews</label></th>
                        <td><input type="text" name="students_reviews" class="t_field"
                                value="<?php echo $row['students_reviews'];?>"></td>
                        <th><label>Terms and Conditions</label></th>
                        <td><input type="text" name="terms_and_conditions" class="t_field"
                                value="<?php echo $row['terms_and_conditions'];?>"></td>
                    </tr>

                    <tr>
                        <th><label>Stipend</label></th>
                        <td><input type="text" name="stipend" class="t_field" value="<?php echo $row['stipend'];?>">
                        </td>
                        <th><label>Company Size</label></th>
                        <td><input type="text" name="company_size" class="t_field"
                                value="<?php echo $row['company_size'];?>"></td>
                    </tr>
                </table>
                <input type="hidden" name="spe_id" value="<?php echo $id; ?>">
                <br>
                <input type="submit" name="submit" class="submit_btn">
            </form>
        </div>
    </div>
</body>

</html>