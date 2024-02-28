<?php
session_start();
include("db_connection.php");

$category_id = $_SESSION["cat1"];
$subcategory_id = isset($_GET['subcategory_id']) ? $_GET['subcategory_id'] : '';
global $conn;

$sql = "SELECT * FROM mentoring WHERE employee_id = '{$_SESSION['employee_id']}'";
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
?>

<!DOCTYPE html>
<html>

<head>
    <title>Montoring</title>
    <?php require "./components/category-table-script.php" ?>
</head>

<body>
    <?php require "./components/header.php" ?>

    <div class="main_div center">
        <h3>Mentoring</h3>
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
                            <th>pbasYear</th>
                            <th>mentorName</th>
                            <th>studentNames</th>
                            <th>outcomeMentoring</th>
                            <th>hoursSpent</th>
                            <th>ACTION</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$row['pbasYear']}</td>";
                            echo "<td>{$row['mentorName']}</td>";
                            echo "<td>{$row['studentNames']}</td>";
                            echo "<td>{$row['outcomeMentoring']}</td>";
                            echo "<td>{$row['hoursSpent']}</td>";
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Mentoring</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="myForm" action="cat1_mentoring_insert.php" method="POST">
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
                                <label for="mentorName">Name of Mentor:</label>
                                <input type="text" class="form-control" id="mentorName" name="mentorName">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="studentNames">Name of Students:</label>
                                <input type="text" class="form-control" id="studentNames" name="studentNames">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="outcomeMentoring">Outcome Mentoring:</label>
                                <input type="text" class="form-control" id="outcomeMentoring" name="outcomeMentoring">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="hoursSpent">Hours Spent:</label>
                                <input type="number" class="form-control" id="hoursSpent" name="hoursSpent" min="0">
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
                    <h5 class="modal-title" id="editModalLabel">Update Mentoring</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="editForm" action="cat1_mentoring_update.php" method="POST">
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
                                <label for="editmentorName">Name of Mentor:</label>
                                <input type="text" class="form-control" id="editmentorName" name="editmentorName">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="editstudentNames">Name of Students:</label>
                                <input type="text" class="form-control" id="editstudentNames" name="editstudentNames">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="editoutcomeMentoring">Outcome Mentoring:</label>
                                <input type="text" class="form-control" id="editoutcomeMentoring"
                                    name="editoutcomeMentoring">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="edithoursSpent">Hours Spent:</label>
                                <input type="number" class="form-control" id="edithoursSpent" name="edithoursSpent"
                                    min="0">
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

                $.ajax({
                    type: "GET",
                    url: "cat1_mentoring_update.php",
                    data: {
                        entry_id: entryId
                    },
                    success: function (response) {
                        // Parse the JSON response
                        var entryData = JSON.parse(response);
                        $('#editEntryId').val(entryId);
                        $('#editPbasYear').val(entryData.pbasYear);
                        $('#editmentorName').val(entryData.mentorName);
                        $('#editstudentNames').val(entryData.studentNames);
                        $('#editoutcomeMentoring').val(entryData.outcomeMentoring);
                        $('#edithoursSpent').val(entryData.hoursSpent);

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
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });
        });
    </script>
    <script>
        // $(document).ready(function () {
        //     $("#myForm").submit(function (e) {
        //         e.preventDefault();
        //         var formData = $(this).serialize();
        //         $.ajax({
        //             type: "POST",
        //             url: "cat1_mentoring_insert.php",
        //             data: formData,
        //             success: function (response) {
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
                    url: "cat1_mentoring_insert.php",
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
                        url: "mentoring_delete_entry.php",
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