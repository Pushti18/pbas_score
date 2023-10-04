<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="shortcut icon" href="./images/ICT-log.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Details</title>
    <style>
    <?php include "./css/ipr_patent.css";
    ?>
    </style>
</head>

<body>
    <header class="header_container">
        <img class="mulogo_header" src="../images/MU_Logo.png" alt="MU logo">
        <h1 class="title">Company Details</h1>
        <img class="ictlogo_header" src="../images/ICT_logo_text.png" alt="MU logo">
    </header>
    <!-- <h2 style="margin-left:41%;">Company Details</h2> -->
    <div class="container">
        <a href="ipr_output.php"><button class="back_btn">Back</button></a>
    </div>
    <div class="form_container">
        <form method="POST" action="ipr_input.php" enctype="multipart/form-data">
            <table class="form_table">
                <tr>
                    <th><label>Company Name</label></th>
                    <td><input type="text" name="company_name" class="t_field"></td>
                    <th><label>Location</label></th>
                    <td><input type="text" name="location" class="t_field"></td>
                </tr>

                <!-- <tr>
                    <th><label>Middle Name</label></th>
                    <td><input type="text" name="middle_name" class="t_field"></td>
                    <th><label>Last Name</label></th>
                    <td><input type="text" name="last_name" class="t_field"></td>
                </tr> -->

                <tr>
                    <th><label>Type of Company</label></th>
                    <td>
                        <select id="type_of_company" name="type_of_company" class="dd_field">
                            <option value="none" selected disabled hidden>Select an Option</option>
                            <option value="Government of India">Government Of India</option>
                            <option value="MNC">MNC</option>
                        </select>
                    </td>
                    <th><label>Job Description</label></th>
                    <td><input type="text" name="job_description" class="t_field"></td>
                </tr>
                <tr>
                    <th><label>Skills Required</label></th>
                    <td><input type="text" name="skills_required" class="t_field"></td>
                    <th><label>Website</label></th>
                    <td><input type="text" name="website" class="t_field"></td>
                </tr>
                <tr>
                    <th><label>Linkedln</label></th>
                    <td><input type="text" name="linkedln" class="t_field"></td>
                    <th><label>Students Reference</label></th>
                    <td><input type="text" name="students_reference" class="t_field"></td>
                </tr>

                <tr>
                    <th><label>Salary</label></th>
                    <td><input type="text" name="salary" class="t_field"></td>
                    <th><label>Reviews</label></th>
                    <td><input type="text" name="reviews" class="t_field"></td>
                </tr>
                <tr>
                    <th><label>Students Reviews</label></th>
                    <td><input type="text" name="students_reviews" class="t_field"></td>
                    <th><label>Terms and Conditions</label></th>
                    <td><input type="text" name="terms_and_conditions" class="t_field"></td>
                </tr>

                <tr>
                    <th><label>Stipend</label></th>
                    <td><input type="text" name="stipend" class="t_field"></td>
                    <th><label>Company Size</label></th>
                    <td><input type="text" name="company_size" class="t_field"></td>
                </tr>
            </table>

            <p style="margin-left:25%;"><b>Request to enter all the details and if its not available currently, then put
                    "-" as the value.</b></p>
            <input style="margin-top:0.5%;" type="submit" name="submit" class="submit_btn">
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="tableExport/tableExport.js"></script>
    <script type="text/javascript" src="tableExport/jquery.base64.js"></script>
    <script src="js/export.js"></script>
</body>

</html>