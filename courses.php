<?php
session_start();
include("db_connection.php");

$category_id = $_SESSION["cat1"];
$subcategory_id = isset($_GET['subcategory_id']) ? $_GET['subcategory_id'] : '';
global $conn;

$sql = "SELECT * FROM courses WHERE employee_id = '{$_SESSION['employee_id']}'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}
$employee_id = $_SESSION['employee_id'];
$category = $_SESSION['cat1'];

// $query = "UPDATE `cat1` SET `employee_id` = $employee_id and `category_id` = $category and `subcategory_id`=$subcategory_id";
// echo $query;
// if (mysqli_query($conn, $query)) {
//     // echo "Employee ID updated successfully in the database.";
// } else {
//     // echo "Error updating record: " . mysqli_error($conn);
// }
// 
?>

<!DOCTYPE html>
<html>

<head>
    <title> Subject Contents/Courses</title>
    <?php require "./components/category-table-script.php" ?>
</head>

<body>
    <?php require "./components/header.php" ?>

    <div class="main_div center">
        <h4>Subject Contents/Courses</h4>
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

                            <th>ACADEMIC YEAR</th>
                            <th>courseName</th>
                            <th>detailofuploadedsubject</th>
                            <th>hoursSpentInnovation</th>
                            <th>ACTION</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$row['pbasYear']}</td>";
                            echo "<td>{$row['courseName']}</td>";
                            echo "<td>{$row['detailofuploadedsubject']}</td>";
                            echo "<td>{$row['hoursSpentInnovation']}</td>";
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Subject Contents/Courses</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="myForm" action="cat1_courses_insert.php" method="POST" enctype="multipart/form-data">
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
                                <label for="courseName">Course Name:</label>
                                <input type="text" class="form-control" id="courseName" name="courseName">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="detailofuploadedsubject">Detail of Uploaded Subject:</label>
                                <input type="text" class="form-control" id="detailofuploadedsubject"
                                    name="detailofuploadedsubject">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="hoursSpentInnovation">Hours Spent:</label>
                                <input type="number" class="form-control" id="hoursSpentInnovation"
                                    name="hoursSpentInnovation" min="0">
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="documentInnovation">Upload Document Justifying Your Innovation:</label>
                                <input type="file" class="form-control" id="documentInnovation"
                                    name="documentInnovation" accept=".pdf, .doc, .docx">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="uploadexecutive">Also Upload an executive summary of the same in given
                                    format by download
                                    gi:</label>
                                <input type="file" class="form-control" id="uploadexecutive" name="uploadexecutive"
                                    accept=".pdf, .doc, .docx">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="submitButton">Submit</button>
                        <!-- <button type="submit" class="btn btn-primary" id="uploadButton">Submit</button> -->

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
                    <h5 class="modal-title" id="editModalLabel">Add Subject Contents/Courses</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="myForm" action="cat1_courses_update.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="entry_id" id="editEntryId">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="editPbasYear">PBAS Year:</label>
                                <select class="form-control" id="editPbasYear" name="editPbasYear">
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
                                <label for="editcourseName">Course Name:</label>
                                <input type="text" class="form-control" id="editcourseName" name="editcourseName">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="editdetailofuploadedsubject">Detail of Uploaded Subject:</label>
                                <input type="text" class="form-control" id="editdetailofuploadedsubject"
                                    name="editdetailofuploadedsubject">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="edithoursSpentInnovation">Hours Spent:</label>
                                <input type="number" class="form-control" id="edithoursSpentInnovation"
                                    name="edithoursSpentInnovation" min="0">
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="editdocumentInnovation">Upload Document Justifying Your Innovation:</label>
                                <input type="file" class="form-control" id="editdocumentInnovation"
                                    name="editdocumentInnovation" accept=".pdf, .doc, .docx">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="edituploadexecutive">Also Upload an executive summary of the same in given
                                    format by download
                                    gi:</label>
                                <input type="file" class="form-control" id="edituploadexecutive"
                                    name="edituploadexecutive" accept=".pdf, .doc, .docx">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <!-- <button type="submit" class="btn btn-primary" id="uploadButton">Submit</button> -->

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
                    url: "cat1_courses_update.php",
                    data: {
                        entry_id: entryId
                    },
                    success: function (response) {
                        // Parse the JSON response
                        var entryData = JSON.parse(response);

                        // Populate the edit modal form fields with fetched data
                        $('#editEntryId').val(entryId);
                        $('#editPbasYear').val(entryData.pbasYear);
                        $('#editcourseName').val(entryData.courseName);
                        $('#editdetailofuploadedsubject').val(entryData
                            .detailofuploadedsubject);
                        $('#edithoursSpentInnovation').val(entryData.hoursSpentInnovation);
                        // Show the edit modal
                        $('#editModal').modal('show');
                    }
                });
            });
        });
    </script>
    <?php require "./components/category-table-top-script.php" ?>
    <script>
        document.getElementById('myForm').addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent the default form submission

            const documentInput = document.getElementById('documentInnovation');
            const file = documentInput.files[0];

            if (!file) {
                alert('Please select a file to upload.');
                return;
            }

            // Create a FormData object to hold the file data
            const formData = new FormData(this); // 'this' refers to the form element

            // Send an AJAX request to the server using Fetch API
            fetch('cat1_courses_insert.php', {
                method: 'POST',
                body: formData,
            })
                .then(response => response.text())
                .then(data => {
                    console.log(data); // Display server response (e.g., success message)
                })
                .catch(error => {
                    console.error(error); // Handle errors
                });
        });
    </script>

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
    <script>
        // $(document).ready(function() {
        //     $("#myForm").submit(function(e) {
        //         e.preventDefault();
        //         var formData = $(this).serialize();
        //         $.ajax({
        //             type: "POST",
        //             url: "cat1_courses_insert.php",
        //             data: formData,
        //             success: function(response) {
        //                 alert(response);
        //             }
        //         });
        //     });
        // });

        $(document).ready(function () {
            $("#myForm").submit(function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "cat1_courses_insert.php",
                    data: formData,
                    success: function (response) {
                        alert(response); // Show success message or handle response accordingly
                        $('#myModal').modal('hide'); // Close modal popup
                        refreshTable(); // Refresh table data
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
            $('.btn-delete').click(function () {
                var id = $(this).data('id');
                $('#deleteConfirmationModal').modal('show');
                $('#confirmDeleteBtn').click(function () {
                    $.ajax({
                        type: "POST",
                        url: "courses_delete_entry.php",
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
</body>

</html>