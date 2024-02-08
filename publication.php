<?php
session_start();
include("db_connect.php");
// Retrieve category and subcategory information from the query string
$category_title = isset($_GET['category_title']) ? $_GET['category_title'] : '';
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';
$subcategory_title = isset($_GET['subcategory_title']) ? $_GET['subcategory_title'] : '';
$subcategory_id = isset($_GET['subcategory_id']) ? $_GET['subcategory_id'] : '';
global $conn;
// Connect to the database
// Fetch data from the database
$sql = "SELECT * FROM publication WHERE employee_id = '{$_SESSION['employee_id']}'";
$result = mysqli_query($conn, $sql);

// Check for errors
if (!$result) {
    die("Error: " . mysqli_error($conn));
}


// Store the category and subcategory in the cat3 table
$sql = "INSERT INTO cat3 (category_id,category_title,subcategory_id, subcategory_title) VALUES ('$category_id','$category_title','$subcategory_id', '$subcategory_title')";
mysqli_query($conn, $sql);
// $stmt = $conn->prepare($sql);

// Handle potential errors
if (mysqli_error($conn)) {
    echo "Error: " . mysqli_error($conn);
} else {
    // echo "Category and subcategory stored successfully.";
}
$publication_details = isset($_SESSION['publication_details']) ? $_SESSION['publication_details'] : null;

// Clear the session variable
unset($_SESSION['publication_details']);
mysqli_close($conn);

// ... rest of your PHP code for the page
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
        <h2 style="margin-left: 42%;">Publication</h2>
    </div>
    <br>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
        Add Publication
    </button>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Publication</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- ... previous HTML code ... -->
                <div class="modal-body">
                    <!-- Form fields go here -->
                    <form id="myForm" action="cat3_publication_insert.php" method="POST">
                        <input type="hidden" name="employee_id" value="<?php echo $_SESSION['employee_id']; ?>">

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="region">Region:</label>
                                <select class="form-control" id="region" name="region">
                                    <option value="Please Select">Please Select</option>
                                    <option value="National">National</option>
                                    <option value="International">International</option>
                                    <option value="Local">Local</option>
                                    <option value="National & International">National & International</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="type">Type:</label>
                                <select class="form-control" id="type" name="type">
                                    <option value="Select Type">Select Type</option>
                                    <option value="Book">Book</option>
                                    <option value="Article">Article</option>
                                    <option value="Journal/Magazine Article">Journal/Magazine Article</option>
                                    <option value="Conference Paper Presentation">Conference Paper Presentation</option>
                                    <option value="Conference Poster Presentation">Conference Poster Presentation
                                    </option>
                                    <option value="Referral Journal">Referral Journal</option>
                                    <option value="Reputed Journal">Reputed Journal</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" id="title" name="title">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="author">Author:</label>
                                <input type="text" class="form-control" id="author" name="author">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="role">Role:</label>
                                <select class="form-control" id="role" name="role">
                                    <option value="Select Role">Select Role</option>
                                    <option value="Principal Author">Principal Author</option>
                                    <option value="Corresponding Author">Corresponding Author</option>
                                    <option value="Supervisor">Supervisor</option>
                                    <option value="Mentor">Mentor</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="publication_group">Group:</label>
                                <select class="form-control" id="publication_group" name="publication_group">
                                    <option value="Select Group">Select Group</option>
                                    <option value="SCI">SCI</option>
                                    <option value="Non-SCI">Non-SCI</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="journalTitle">Journal/Magazine Title:</label>
                                <input type="text" class="form-control" id="journalTitle" name="journalTitle">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="coAuthor">Co-Author:</label>
                                <input type="text" class="form-control" id="coAuthor" name="coAuthor">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="month">Month of Publication:</label>
                                <select class="form-control" id="month" name="month">
                                    <?php
                                        $months = [
                                            "01" => "January", "02" => "February", "03" => "March", "04" => "April",
                                            "05" => "May", "06" => "June", "07" => "July", "08" => "August",
                                            "09" => "September", "10" => "October", "11" => "November", "12" => "December"
                                        ];

                                        foreach ($months as $key => $value) {
                                            echo "<option value='{$key}'>{$value}</option>";
                                        }
                                        ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="year">Year of Publication:</label>
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
                                <label for="publisher">Publisher:</label>
                                <input type="text" class="form-control" id="publisher" name="publisher">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="pubDate">Publication Date:</label>
                                <input type="date" class="form-control datepicker" id="pubDate" name="pubDate">
                            </div>
                            <script>
                            // Wait for the document to be ready
                            $(document).ready(function() {
                                // Initialize the datepicker
                                $("#pubDate").datepicker();
                            });
                            </script>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="volume">Volume No:</label>
                                <input type="text" class="form-control" id="volume" name="volume">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="page">Page No:</label>
                                <input type="text" class="form-control" id="page" name="page">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="frontImage">Publication Front Image:</label>
                                <input type="file" class="form-control" id="frontImage" name="frontImage"
                                    accept=".jpg, .jpeg, .png, .gif">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="current_status_of_work">Current Status of Work:</label>
                                <select class="form-control" id="current_status_of_work" name="current_status_of_work">
                                    <option value="Select Group">Select Group</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Completed">Completed</option>
                                </select>
                            </div>
                            <!-- <div class="form-group col-md-6">
                                <label for="current_status_of_work">Current Status of Work:</label>
                                <select class="form-control" id="current_status_of_work" name="current_status_of_work">
                                    <option value="Select Option">Select Option</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Completed">Completed</option>
                                </select>
                            </div> -->

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
                        echo "<td>{$row['title']}</td>";
                        echo "<td>{$row['year_of_publication']}</td>";
                        echo "<td>{$row['type']}</td>";
                        echo "<td>{$row['region']}</td>";
                       
                        
                        // echo "<td>{$row['approval_status']}</td>";
                        // echo "<td><a href='edit_research.php?id={$row['id']}'>Edit</a> | <a href='delete_research.php?id={$row['id']}'>Delete</a></td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
        <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js" charset="utf8" type="text/javascript">
        </script>
        <script type="text/javascript">
        // $(document).ready(function() {
        //     $("#myForm").submit(function(e) {
        //         e.preventDefault();
        //         var formData = $(this).serialize();
        //         $.ajax({
        //             type: "POST",
        //             url: "cat3_publication_insert.php",
        //             data: formData,
        //             success: function(response) {
        //                 try {
        //                     var data = JSON.parse(response);
        //                     // Add a new row to the DataTable with the retrieved values
        //                     var table = $('#details_table').DataTable();

        //                     table.row.add([
        //                         data.title,
        //                         data.academic_year,
        //                         data.status,
        //                         data.type,
        //                         data.region,
        //                         data.approval_status,
        //                         '<button onclick="showDetails(\'' + data.title +
        //                         '\', \'' + data.current_status_of_work + '\', \'' +
        //                         data.type + '\', \'' + data.region + '\', \'' + data
        //                         .pbas_score + '\')">Show Details</button>'
        //                     ]).draw();

        //                     // Clear the form
        //                     $("#myForm")[0].reset();
        //                 } catch (error) {
        //                     console.error("Error parsing JSON response: " + error);
        //                 }
        //             },
        //             error: function(xhr, textStatus, errorThrown) {
        //                 console.error("AJAX request failed: " + errorThrown);
        //             }
        //         });
        //     });
        // });
        $(document).ready(function() {
            $("#myForm").submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    type: "POST",
                    url: "cat3_publication_insert.php",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        try {
                            var data = JSON.parse(response);
                            // Add a new row to the DataTable with the retrieved values
                            var table = $('#details_table').DataTable();

                            table.row.add([
                                data.title,
                                data.academic_year,
                                data.status,
                                data.type,
                                data.region,
                                data.approval_status,
                                '<button onclick="showDetails(\'' + data.title +
                                '\', \'' + data.current_status_of_work + '\', \'' +
                                data.type + '\', \'' + data.region + '\', \'' + data
                                .pbas_score + '\')">Show Details</button>'
                            ]).draw();

                            // Clear the form
                            $("#myForm")[0].reset();
                        } catch (error) {
                            console.error("Error parsing JSON response: " + error);
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.error("AJAX request failed: " + errorThrown);
                    }
                });
            });
        });
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