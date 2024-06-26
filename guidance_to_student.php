<?php
session_start();
include ("db_connection.php");
$category_title = isset($_GET['category_title']) ? $_GET['category_title'] : '';
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';
$subcategory_title = isset($_GET['subcategory_title']) ? $_GET['subcategory_title'] : '';
$subcategory_id = isset($_GET['subcategory_id']) ? $_GET['subcategory_id'] : '';
global $conn;

$sql = "SELECT * FROM guidance WHERE employee_id = '{$_SESSION['employee_id']}'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}

$employee_id = $_SESSION['employee_id'];
$category = $_SESSION['cat3'];

$query = "UPDATE `cat3` SET `employee_id` = $employee_id and `category_id` = $category and `subcategory_id`=$subcategory_id";
echo $query;
if (mysqli_query($conn, $query)) {
    // echo "Employee ID updated successfully in the database.";
} else {
    // echo "Error updating record: " . mysqli_error($conn);
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>PBAS(Performance Based Appraisal System)</title>
    <?php require "./components/category-table-script.php" ?>
</head>

<body>
    <?php require "./components/header.php" ?>

    <div class="main_div center">
        <h4>Research Guidance: PhD. programme</h4>
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
                            <th>NAME OF UNIVERSITY</th>
                            <th>DEGREE</th>
                            <th>PROJECT TITLE</th>
                            <th>DEGREE AWARD DATE</th>
                            <th>PROJECT YEAR</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$row['name_of_university']}</td>";
                            echo "<td>{$row['degree']}</td>";
                            echo "<td>{$row['project_title']}</td>";
                            echo "<td>{$row['degree_award_date']}</td>";
                            echo "<td>{$row['project_year']}</td>";
                            echo "<td>
                            <button class='btn btn-info btn-edit' data-id='{$row['id']}' data-toggle='modal' data-target='#editModal'>Edit</button>
                            <button class='btn btn-danger btn-delete' data-id='{$row['id']}'>Delete</button>
                        </td>";
                            echo "</tr>";
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Research Guidance: PhD. programme</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <form id="myForm" action="cat3_guidance_insert.php" method="POST">
                        <input type="hidden" name="employee_id" value="<?php echo $_SESSION['employee_id']; ?>">
                        <input type="hidden" name="subcategory_id" value="<?php echo $subcategory_id; ?>">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="nameOfUniversity">Name of the University:</label>
                                <input type="text" class="form-control" id="nameOfUniversity" name="nameOfUniversity">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="degree">Degree:</label>
                                <select class="form-control" id="degree" name="degree">
                                    <option value="Select Degree">Select Degree</option>
                                    <option value="Ph.D">Ph.D</option>
                                    <!-- Add more options for other degrees as needed -->
                                </select>
                            </div>

                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="degreeAwardDate">Degree Award Date:</label>
                                <input type="date" class="form-control" id="degreeAwardDate" name="degreeAwardDate">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="studentName">Student Name:</label>
                                <input type="text" class="form-control" id="studentName" name="studentName">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="enrollmentNo">Enrollment No:</label>
                                <input type="text" class="form-control" id="enrollmentNo" name="enrollmentNo">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="projectTitle">Project Title:</label>
                                <input type="text" class="form-control" id="projectTitle" name="projectTitle">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="projectYear">Project Year:</label>
                                <select class="form-control" id="projectYear" name="projectYear">
                                    <?php
                                    $startYear = 2015;
                                    $endYear = 2050;

                                    for ($i = $startYear; $i <= $endYear; $i++) {
                                        $nextYear = $i + 1;
                                        echo "<option value='{$i}-{$nextYear}'>{$i}-{$nextYear}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="projectType">Project Type:</label>
                                <select class="form-control" id="projectType" name="projectType">
                                    <option value="Research">Select Type</option>
                                    <option value="Thesis">In House</option>
                                    <option value="Other">Industry</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="thesisSubmissionDate">Thesis/Project Submission Date:</label>
                                <input type="date" class="form-control" id="thesisSubmissionDate"
                                    name="thesisSubmissionDate">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="currentStatusOfWork">Current Status of Work:</label>
                                <select class="form-control" id="currentStatusOfWork" name="currentStatusOfWork">
                                    <option value="In Progress">In Progress</option>
                                    <option value="Completed">Completed</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
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
                    <h5 class="modal-title" id="editModalLabel">Add Research Guidance: PhD. programme</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <form id="myForm" action="cat3_guidance_update.php" method="POST">
                        <input type="hidden" name="entry_id" id="editEntryId">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="editnameOfUniversity">Name of the University:</label>
                                <input type="text" class="form-control" id="editnameOfUniversity"
                                    name="editnameOfUniversity">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="editdegree">Degree:</label>
                                <select class="form-control" id="editdegree" name="editdegree">
                                    <option value="Select Degree">Select Degree</option>
                                    <option value="Ph.D">Ph.D</option>
                                    <!-- Add more options for other degrees as needed -->
                                </select>
                            </div>

                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="editdegreeAwardDate">Degree Award Date:</label>
                                <input type="date" class="form-control" id="editdegreeAwardDate"
                                    name="editdegreeAwardDate">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="editstudentName">Student Name:</label>
                                <input type="text" class="form-control" id="editstudentName" name="editstudentName">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="editenrollmentNo">Enrollment No:</label>
                                <input type="text" class="form-control" id="editenrollmentNo" name="editenrollmentNo">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="editprojectTitle">Project Title:</label>
                                <input type="text" class="form-control" id="editprojectTitle" name="editprojectTitle">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="editprojectYear">Project Year:</label>
                                <select class="form-control" id="editprojectYear" name="editprojectYear">
                                    <?php
                                    $startYear = 2015;
                                    $endYear = 2050;

                                    for ($i = $startYear; $i <= $endYear; $i++) {
                                        $nextYear = $i + 1;
                                        echo "<option value='{$i}-{$nextYear}'>{$i}-{$nextYear}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="editprojectType">Project Type:</label>
                                <select class="form-control" id="editprojectType" name="editprojectType">
                                    <option value="Research">Select Type</option>
                                    <option value="Thesis">In House</option>
                                    <option value="Other">Industry</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="editthesisSubmissionDate">Thesis/Project Submission Date:</label>
                                <input type="date" class="form-control" id="editthesisSubmissionDate"
                                    name="editthesisSubmissionDate">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="editcurrentStatusOfWork">Current Status of Work:</label>
                                <select class="form-control" id="editcurrentStatusOfWork"
                                    name="editcurrentStatusOfWork">
                                    <option value="In Progress">In Progress</option>
                                    <option value="Completed">Completed</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.btn-edit').click(function () {
                var entryId = $(this).data('id');

                $.ajax({
                    type: "GET",
                    url: "cat3_guidance_update.php",
                    data: {
                        entry_id: entryId
                    },
                    success: function (response) {
                        // Parse the JSON response
                        var entryData = JSON.parse(response);
                        $('#editEntryId').val(entryId);

                        $('#editnameOfUniversity').val(entryData.name_of_university);
                        $('#editdegree').val(entryData.degree);
                        $('#editdegreeAwardDate').val(entryData.degree_award_date);
                        $('#editstudentName').val(entryData.student_name);
                        $('#editenrollmentNo').val(entryData.enrollment_no);
                        $('#editprojectTitle').val(entryData.project_title);
                        $('#editprojectYear').val(entryData.project_year);
                        $('#editprojectType').val(entryData.project_type);
                        $('#editthesisSubmissionDate').val(entryData.thesis_submission_date);
                        $('#editcurrentStatusOfWork').val(entryData.current_status_of_work);

                        $('#editModal').modal('show');
                    }
                });
            });
        });
    </script>

    <?php require "./components/category-table-top-script.php" ?>

    <script type="text/javascript">
        $(document).ready(function () {
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
        $(document).ready(function () {
            $("#myForm").submit(function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "cat3_guidance_insert.php",
                    data: formData,
                    success: function (response) {
                        location.reload();
                        // alert(response);

                    }
                });
            });
        });
    </script>
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
        $(document).ready(function () {
            $(document).on('click', '.btn-delete', function () {
                var id = $(this).data('id');
                $('#deleteConfirmationModal').modal('show');
                $('#confirmDeleteBtn').click(function () {
                    $.ajax({
                        type: "POST",
                        url: "guidance_to_student_delete_entry.php",
                        data: {
                            id: id
                        },
                        success: function (response) {
                            location.reload();
                            // alert(response);
                        },
                        error: function (xhr, status, error) {
                        }
                    });
                    $('#deleteConfirmationModal').modal('hide');
                });
            });
        });

    </script>
</body>

</html>