<?php
session_start();
include("db_connect.php");
// Retrieve category and subcategory information from the query string
$category_title = isset($_GET['category_title']) ? $_GET['category_title'] : '';
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';
$subcategory_title = isset($_GET['subcategory_title']) ? $_GET['subcategory_title'] : '';
$subcategory_id = isset($_GET['subcategory_id']) ? $_GET['subcategory_id'] : '';
global $conn;


$sql = "SELECT * FROM direct_teaching WHERE employee_id = '{$_SESSION['employee_id']}'";
$result = mysqli_query($conn, $sql);

// Check for errors
if (!$result) {
    die("Error: " . mysqli_error($conn));
}


$sql = "INSERT INTO cat1 (category_id,category_title,subcategory_id, subcategory_title) VALUES ('$category_id','$category_title','$subcategory_id', '$subcategory_title')";
mysqli_query($conn, $sql);

if (mysqli_error($conn)) {
    echo "Error: " . mysqli_error($conn);
} else {
    // echo "Category and subcategory stored successfully.";
}

?>

<!DOCTYPE html>
<html>

<head>
    <style>
    <?php include 'css/ipr_output.css';
    ?>
    </style>
    <title>PBAS(Performance Based Appraisal System)</title>
    <!-- Bootstrap CSS -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js">
    </script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;1,100&display=swap"
        rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Include jQuery UI -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <style>
    /* Add this CSS in your <style> tag or in a separate CSS file */

    .modal-content {
        border-radius: 0;
        /* Adjust the border radius as needed */
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        /* Add a subtle box shadow */
    }

    .modal-header {
        background-color: #007bff;
        /* Set the background color to your desired color */
        color: #fff;
        /* Set the text color to white */
        border-bottom: 1px solid #ddd;
        /* Add a bottom border */
    }

    .modal-title {
        font-weight: bold;
    }

    .modal-body {
        padding: 20px;
    }

    .modal-footer {
        border-top: 1px solid #ddd;
        /* Add a top border */
        padding: 15px;
    }

    .modal-body {
        background-color: #f8f9fa;
        padding: 20px;
    }

    .form-group label {
        color: #007bff;
        font-weight: bold;
    }

    .form-control {
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }
    </style>
</head>

<body>
    <!-- <header class="header_container">
        <img class="mulogo_header" src="images/mu-logo-2.png" alt="MU logo">
        <h1 class="title">PBAS</h1>
        <img class="ictlogo_header" src="images/ICT_logo_text.png" alt="MU logo">
    </header> -->

    <div class="nav_div" style="background-color: lightblue;">
        <h2 style="margin-left: 42%;">Guidance To Student</h2>
    </div>
    <br>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
        Add Guidance
    </button>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Guidance</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- ... previous HTML code ... -->
                <div class="modal-body">
                    <!-- Form fields go here -->
                    <form id="myForm" action="cat1_direct_teaching_insert.php" method="POST">
                        <input type="hidden" name="employee_id" value="<?php echo $_SESSION['employee_id']; ?>">

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="university">Fill below details to add Guidance To Student in Project
                                    Name of the University</label>
                                <input type="text" class="form-control" id="university" name="university">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="year">Degree Award Date:</label>
                                <select class="form-control" id="year" name="year">
                                    <?php
                                        $startYear = 1990;
                                        $endYear = 2050;

                                        for ($i = $startYear; $i <= $endYear; $i++) {
                                            echo "<option value='{$i}'>{$i}</option>";
                                        }
                                        ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="enroll">Enrollment No.</label>
                                <input type="text" class="form-control" id="enroll" name="enroll">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="projectYear">Project Year:</label>
                                <select class="form-control" id="pbasYear" name="pbasYear">
                                        <?php
                                            $startYear = 1990;
                                            $endYear = 2050;

                                            for ($i = $startYear; $i <= $endYear; $i++) {
                                                echo "<option value='{$i}'>{$i}</option>";
                                            }
                                            ?>
                                    </select>
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="submissionDate">Thesis/Project Submission Date:</label>
                                <input type="date" class="form-control" id="submissionDate" name="submissionDate">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="pbasYear">PBAS Year:</label>
                                <select class="form-control" id="pbasYear" name="pbasYear">
                                    <?php
                                        // Same as the project year, you can adjust the range as needed
                                        for ($i = $startYear; $i <= $endYear; $i++) {
                                            echo "<option value='{$i}'>{$i}</option>";
                                        }
                                        ?>
                                </select>
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="hoursSpent">Hours Spent:</label>
                                <input type="number" class="form-control" id="hoursSpent" name="hoursSpent" min="0">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="degree">Degree:</label>
                                <select class="form-control" id="degree" name="degree">
                                    <option value="Select Degree">Select Degree</option>
                                    <option value="Diploma">Diploma</option>
                                    <option value="Bachelor Degree">Bachelor Degree</option>
                                    <option value="Master Degree">Master Degree</option>
                                    <!-- Add more options if needed -->
                                </select>
                            </div>

                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="studentName">Student Name:</label>
                                <input type="text" class="form-control" id="studentName" name="studentName">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="projectTitle">Project Title:</label>
                                <input type="text" class="form-control" id="projectTitle" name="projectTitle">
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="projectType">Project Type:</label>
                                <select class="form-control" id="projectType" name="projectType">
                                    <option value="Select Type">Select Type</option>
                                    <option value="In House">In House</option>
                                    <option value="Industry">Industry</option>
                                    <!-- Add more options if needed -->
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="statusofwork">Current Status Of Work:</label>
                                <select class="form-control" id="statusofwork" name="statusofwork">
                                    <option value="Select State">Select State</option>
                                    <option value="Completed">Completed</option>
                                    <option value="In Progress">In Progress</option>
                                    <!-- Add more options if needed -->
                                </select>
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="attachment">Attachment Files Upload:</label>
                                <input type="file" class="form-control" id="attachment" name="attachment"
                                    accept=".pdf, .doc, .docx">
                            </div>



                        </div>



                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <!-- ... remaining HTML code ... -->

            </div>
        </div>

        <script>
        $(document).ready(function() {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd', // You can customize the date format
                autoclose: true
            });
        });
        </script>
<script>
        $(document).ready(function() {
            $("#myForm").submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "cat1_direct_teaching_insert.php",
                    data: formData,
                    success: function(response) {
                        alert(response);
                    }
                });
            });
        });
        </script>

    </div>

    </div>


    <div class="main_div">
        <table id="details_table" class="display" cellspacing="0">
            <thead>
                <tr>
                    <th>TITLE</th>
                    <th>ACADEMIC YEAR</th>
                    <th>STATUS</th>
                    <th>TYPE</th>
                    <th>REGION</th>
                    <th>APPROVAL STATUS</th>
                    <th>ACTION</th>

                </tr>
            </thead>
            <tbody>
                <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>{$row['university']}</td>";
                        echo "<td>{$row['year']}</td>";
                        echo "<td>{$row['degree']}</td>";
                        echo "<td>{$row['project_type']}</td>";
                       echo "</tr>";
                    }
                ?> 
            </tbody>
        </table>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
        <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js" charset="utf8" type="text/javascript">
        </script>

        <script type="text/javascript">
        $(document).ready(function() {
            $('#details_table').DataTable({
                dom: 'Bfrtip',
                lengthMenu: [
                    [5, 10, 25, 50],
                    ['5 Files', '10 Files', '25 Files', '50 Files']
                ],

            });
        });
        </script>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <!-- <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script> -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
    </div>
</body>

</html>