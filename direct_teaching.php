<?php
session_start();
include("db_connection.php");

$category_title = isset($_GET['category_title']) ? $_GET['category_title'] : '';
$subcategory_title = isset($_GET['subcategory_title']) ? $_GET['subcategory_title'] : '';
$subcategory_id = isset($_GET['subcategory_id']) ? $_GET['subcategory_id'] : '';
$category_id = $_SESSION['category_id'];
global $conn;

$sql = "SELECT * FROM direct_teaching WHERE employee_id = '{$_SESSION['employee_id']}'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}

$employee_id = $_SESSION['employee_id'];
$category = $_SESSION['cat1'];

$query = "UPDATE `cat1` SET `employee_id` = $employee_id and `category_id` = $category and `subcategory_id`=$subcategory_id";
echo $query;
if (mysqli_query($conn, $query)) {
    // echo "Employee ID updated successfully in the database.";
} else {
    // echo "Error updating record: " . mysqli_error($conn);
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Guidance To Student</title>
    <?php require "./components/category-table-script.php" ?>
</head>

<body>
    <?php require "./components/header.php" ?>

    <div class="main_div center">
        <h4>Guidance To Student</h4>
    </div>

    <div class="parent-container">
        <div class="child-container">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                Add
            </button>

            <div class="table-container">
                <table id="details_table" class="display" cellspacing="0">
                    <thead>
                        <tr>
                            <th>TITLE</th>
                            <th>ACADEMIC YEAR</th>
                            <th>DEGREE</th>
                            <th>hoursSpent</th>
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
                            echo "<td>{$row['hoursSpent']}</td>";
                            echo "<td>
        <button class='btn btn-info btn-edit' data-id='{$row['id']}' data-toggle='modal' data-target='#editModal'>Edit</button>
        <button class='btn btn-danger btn-delete' data-id='{$row['id']}'>Delete</button>
      </td>";
                            echo "</tr>";

                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


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

                <div class="modal-body">
                    <form id="myForm" action="cat1_direct_teaching_insert.php" method="POST"
                        enctype="multipart/form-data">
                        <input type="hidden" name="employee_id" value="<?php echo $_SESSION['employee_id']; ?>">
                        <input type="hidden" name="subcategory_id" value="<?php echo $subcategory_id; ?>">
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
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="statusofwork">Current Status Of Work:</label>
                                <select class="form-control" id="statusofwork" name="statusofwork">
                                    <option value="Select State">Select State</option>
                                    <option value="Completed">Completed</option>
                                    <option value="In Progress">In Progress</option>
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
                        <button type="submit" class="btn btn-primary" id="submitButton">Submit</button>
                        <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Guidance</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="myForm" action="direct_teaching_update.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="record_id" value="<?php echo $record_id; ?>">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="university">Fill below details to add Guidance To Student in Project
                                    Name of the University</label>
                                <input type="text" class="form-control" id="university" name="university"
                                    value="<?php echo $university; ?>">
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
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="statusofwork">Current Status Of Work:</label>
                                <select class="form-control" id="statusofwork" name="statusofwork">
                                    <option value="Select State">Select State</option>
                                    <option value="Completed">Completed</option>
                                    <option value="In Progress">In Progress</option>
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
                        <button type="submit" class="btn btn-primary" id="submitButton">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <?php require "./components/category-table-top-script.php" ?>

    <script>
    document.getElementById('myForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const documentInput = document.getElementById('attachment');
        const file = documentInput.files[0];
        if (!file) {
            alert('Please select a file to upload.');
            return;
        }

        const formData = new FormData(this);
        fetch('cat1_direct_teaching_insert.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.text())
            .then(data => {
                console.log(data);
            })
            .catch(error => {
                console.error(error);
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
    <script>
    $(document).ready(function() {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    });
    </script>
    <script>
    // Function to open edit modal
    function openEditModal(id) {
        // Fetch data for the selected entry using AJAX
        $.ajax({
            type: "GET",
            url: "direct_teaching_edit_page.php",
            data: {
                id: id
            },
            success: function(response) {
                // Populate the modal with fetched data
                $('#editModal .modal-content').html(response);
                $('#editModal').modal('show'); // Open the modal
            },
            error: function(xhr, status, error) {
                // Handle error
            }
        });
    }

    // Edit Button Click Event
    $('.btn-edit').click(function() {
        var id = $(this).data('id');
        openEditModal(id); // Open edit modal for the selected entry
    });
    </script>
    <!-- HTML structure for modal confirmation dialog -->
    <div id="deleteConfirmationModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this entry?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $('.btn-delete').click(function() {
            var id = $(this).data('id');
            $('#deleteConfirmationModal').modal('show');
            $('#confirmDeleteBtn').click(function() {
                $.ajax({
                    type: "POST",
                    url: "direct_teaching_delete_entry.php",
                    data: {
                        id: id
                    },
                    success: function(response) {
                        alert(response);
                    },
                    error: function(xhr, status, error) {}
                });
                $('#deleteConfirmationModal').modal('hide');
            });
        });
    });
    </script>

    <!-- <script>
    $(document).ready(function() {


        // Delete Button Click Event
        $('.btn-delete').click(function() {
            var id = $(this).data('id');
            var confirmation = confirm("Are you sure you want to delete this entry?");
            if (confirmation) {
                $.ajax({
                    type: "POST",
                    url: "direct_teaching_delete_entry.php",
                    data: {
                        id: id
                    },
                    success: function(response) {
                        alert(response); // Alert success message
                        // You may want to reload the page or update the table here
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                    }
                });
            }
        });
    });
    </script> -->

</body>

</html>