<?php
session_start();
include("db_connection.php");

$category_title = isset($_GET['category_title']) ? $_GET['category_title'] : '';
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';
$subcategory_title = isset($_GET['subcategory_title']) ? $_GET['subcategory_title'] : '';
$subcategory_id = isset($_GET['subcategory_id']) ? $_GET['subcategory_id'] : '';
global $conn;


$sql = "SELECT * FROM exam_duties WHERE employee_id = '{$_SESSION['employee_id']}'";
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
    <title> Examination Duties</title>

    <?php require "./components/category-table-script.php" ?>
</head>

<body>
    <!-- <?php require "./components/header.php" ?> -->

    <div class="main_div center">
        <h4>Examination Duties</h4>
    </div>

    <div class="parent-container">
        <div class="child-container">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                Add </button>

            <div class="table-container">
                <table id="details_table" class="display" cellspacing="0">
                    <thead>
                        <tr>
                            <!-- <th>TITLE</th> -->
                            <th>ACADEMIC YEAR</th>
                            <th>SEM</th>
                            <th>STREAM NAME</th>
                            <th>COURSE NAME</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$row['pbas_year']}</td>";
                            echo "<td>{$row['semester']}</td>";
                            echo "<td>{$row['stream_name']}</td>";
                            echo "<td>{$row['course_name']}</td>";
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Examination Duties</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="myForm" action="cat1_exam_duties_insert.php" method="POST">
                        <input type="hidden" name="employee_id" value="<?php echo $_SESSION['employee_id']; ?>">
                        <input type="hidden" name="subcategory_id" value="<?php echo $subcategory_id; ?>">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="pbasYear">PBAS Year:</label>
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

                            <div class="form-group col-md-6">
                                <label for="semester">Semester:</label>
                                <select class="form-control" id="semester" name="semester">
                                    <?php
                                    for ($i = 1; $i <= 8; $i++) {
                                        echo "<option value='Sem {$i}'>Sem {$i}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="streamName">Stream Name:</label>
                                <input type="text" class="form-control" id="streamName" name="streamName">
                            </div>


                            <div class="form-group col-md-6">
                                <label for="courseName">Course Name:</label>
                                <select class="form-control" id="courseName" name="courseName">
                                    <option value="Select Course">Select Course</option>
                                    <option value="Course A">Course A</option>
                                    <option value="Course B">Course B</option>
                                </select>
                            </div>

                        </div>


                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="questionPaper">No of Question Paper:</label>
                                <input type="text" class="form-control" id="questionPaper" name="questionPaper">
                            </div>


                            <div class="form-group col-md-6">
                                <label for="hoursSpentQuestion">Hours Spent (Question Paper):</label>
                                <input type="number" class="form-control" id="hoursSpentQuestion"
                                    name="hoursSpentQuestion" min="0">
                            </div>


                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="numExaminations">No's of Examinations (Supervisor's Duties):</label>
                                <input type="text" class="form-control" id="numExaminations" name="numExaminations">
                            </div>


                            <div class="form-group col-md-6">
                                <label for="hoursSpentExaminations">Hours Spent (Examinations):</label>
                                <input type="number" class="form-control" id="hoursSpentExaminations"
                                    name="hoursSpentExaminations" min="0">
                            </div>


                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="numAnswerBook">No of Answer Book:</label>
                                <input type="text" class="form-control" id="numAnswerBook" name="numAnswerBook">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="hoursSpentAnswerBook">Hours Spent (Answer Book):</label>
                                <input type="number" class="form-control" id="hoursSpentAnswerBook"
                                    name="hoursSpentAnswerBook" min="0">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalModalLabel">Add Examination Duties</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" action="cat1_exam_duties_update.php" method="POST">
                        <input type="hidden" name="entry_id" id="editEntryId">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="editPbasYear">PBAS Year:</label>
                                <select class="form-control" id="editpbasYear" name="editpbasYear">
                                    <?php
                                    $startYear = 1990;
                                    $endYear = 2050;

                                    for ($i = $startYear; $i <= $endYear; $i++) {
                                        echo "<option value='{$i}'>{$i}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="editsemester">Semester:</label>
                                <select class="form-control" id="editsemester" name="editsemester">
                                    <?php
                                    for ($i = 1; $i <= 8; $i++) {
                                        echo "<option value='Sem {$i}'>Sem {$i}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="editstreamName">Stream Name:</label>
                                <input type="text" class="form-control" id="editstreamName" name="editstreamName">
                            </div>


                            <div class="form-group col-md-6">
                                <label for="editcourseName">Course Name:</label>
                                <select class="form-control" id="editcourseName" name="editcourseName">
                                    <option value="Select Course">Select Course</option>
                                    <option value="Course A">Course A</option>
                                    <option value="Course B">Course B</option>
                                </select>
                            </div>

                        </div>


                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="editquestionPaper">No of Question Paper:</label>
                                <input type="text" class="form-control" id="editquestionPaper" name="editquestionPaper">
                            </div>


                            <div class="form-group col-md-6">
                                <label for="edithoursSpentQuestion">Hours Spent (Question Paper):</label>
                                <input type="number" class="form-control" id="edithoursSpentQuestion"
                                    name="edithoursSpentQuestion" min="0">
                            </div>


                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="editnumExaminations">No's of Examinations (Supervisor's Duties):</label>
                                <input type="text" class="form-control" id="editnumExaminations"
                                    name="editnumExaminations">
                            </div>


                            <div class="form-group col-md-6">
                                <label for="edithoursSpentExaminations">Hours Spent (Examinations):</label>
                                <input type="number" class="form-control" id="edithoursSpentExaminations"
                                    name="edithoursSpentExaminations" min="0">
                            </div>


                        </div>


                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="editnumAnswerBook">No of Answer Book:</label>
                                <input type="text" class="form-control" id="editnumAnswerBook" name="editnumAnswerBook">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="edithoursSpentAnswerBook">Hours Spent (Answer Book):</label>
                                <input type="number" class="form-control" id="edithoursSpentAnswerBook"
                                    name="edithoursSpentAnswerBook" min="0">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
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

                // AJAX request to fetch data of the selected entry
                $.ajax({
                    type: "GET",
                    url: "cat1_exam_duties_update.php",
                    data: {
                        entry_id: entryId
                    },
                    success: function (response) {
                        // Parse the JSON response
                        var data = JSON.parse(response);
                        if (data.status == 'success') {
                            // Populate the form fields with the fetched data
                            $('#editEntryId').val(data.data.id);
                            $('#editPbasYear').val(data.data.pbasYear);
                            $('#editSemester').val(data.data.semester);
                            $('#editStreamName').val(data.data.streamName);
                            $('#editCourseName').val(data.data.courseName);
                            $('#editQuestionPaper').val(data.data.questionPaper);
                            $('#editHoursSpentQuestion').val(data.data.hoursSpentQuestion);
                            $('#editNumExaminations').val(data.data.numExaminations);
                            $('#editHoursSpentExaminations').val(data.data.hoursSpentExaminations);
                            $('#editNumAnswerBook').val(data.data.numAnswerBook);
                            $('#editHoursSpentAnswerBook').val(data.data.hoursSpentAnswerBook);

                            // Show the edit modal
                            $('#editModal').modal('show');
                        } else {
                            // Handle the error
                            console.log('Error fetching data: ' + data.message);
                        }
                    }
                });
            });
        });
        // $(document).ready(function () {
        //     $('.btn-edit').click(function () {
        //         var entryId = $(this).data('id');

        //         // AJAX request to fetch data of the selected entry
        //         $.ajax({
        //             type: "GET",
        //             url: "cat1_exam_duties_update.php",
        //             data: {
        //                 entry_id: entryId
        //             },
        //             success: function (response) {
        //                 // Parse the JSON response
        //                 var entryData = JSON.parse(response);

        //                 // Populate the edit modal form fields with fetched data
        //                 $('#editEntryId').val(entryId);
        //                 $('#editPbasYear').val(entryData.pbasYear);
        //                 $('#editsemester').val(entryData.semester);
        //                 $('#editstreamName').val(entryData.streamName);
        //                 $('#editcourseName').val(entryData.courseName);
        //                 $('#editquestionPaper').val(entryData.questionPaper);
        //                 $('#edithoursSpentQuestion').val(entryData.hoursSpentQuestion);

        //                 $('#editnumExaminations').val(entryData.numExaminations);
        //                 $('#edithoursSpentExaminations').val(entryData.hoursSpentExaminations);
        //                 $('#editnumAnswerBook').val(entryData.numAnswerBook);
        //                 $('#edithoursSpentAnswerBook').val(entryData.hoursSpentAnswerBook);

        //                 // Show the edit modal
        //                 $('#editModal').modal('show');
        //             }
        //         });
        //     });
        // });
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
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });
        });
    </script>
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
        $(document).ready(function () {
            $('.btn-delete').click(function () {
                var id = $(this).data('id');
                $('#deleteConfirmationModal').modal('show');
                $('#confirmDeleteBtn').click(function () {
                    $.ajax({
                        type: "POST",
                        url: "exam_duties_delete_entry.php",
                        data: {
                            id: id
                        },
                        success: function (response) {
                            alert(response);
                        },
                        error: function (xhr, status, error) { }
                    });
                    $('#deleteConfirmationModal').modal('hide');
                });
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
                    url: "cat1_exam_duties_insert.php",
                    data: formData,
                    success: function (response) {
                        alert(response); // Show success message or handle response accordingly
                        $('#myModal').modal('hide'); // Close modal popup
                        refreshTable(); // Refresh table data
                    }
                });
            });

            // Function to refresh table data
            function refreshTable() {
                $.ajax({
                    type: "GET",
                    url: "your_php_script_to_fetch_updated_data.php", // Replace with actual URL to fetch updated table data
                    success: function (data) {
                        $('#details_table tbody').html(data); // Update table body with new data
                    }
                });
            }
        });
    </script>

    <!-- <script>
        $(document).ready(function () {
            $("#myForm").submit(function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "cat1_exam_duties_insert.php",
                    data: formData,
                    success: function (response) {
                        alert(response); // Show success message or handle response accordingly
                        $('#myModal').modal('hide'); // Close modal popup
                        refreshTable(); // Refresh table data
                    }
                });
            });

            // Function to refresh table data
            function refreshTable() {
                $.ajax({
                    type: "GET",
                    url: "cat1_exam_duties_insert.php", // Replace with actual URL to fetch table data
                    success: function (data) {
                        $('#details_table tbody').html(data); // Update table body with new data
                    }
                });
            }
        });
    </script> -->

</body>

</html>