<?php
session_start();
include ("db_connection.php");

$category_title = isset($_GET['category_title']) ? $_GET['category_title'] : '';
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';
$subcategory_title = isset($_GET['subcategory_title']) ? $_GET['subcategory_title'] : '';
$subcategory_id = isset($_GET['subcategory_id']) ? $_GET['subcategory_id'] : '';
global $conn;


$sql = "SELECT * FROM development_activities WHERE employee_id = '{$_SESSION['employee_id']}'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}

$employee_id = $_SESSION['employee_id'];
$category = $_SESSION['cat2'];

$query = "UPDATE `cat2` SET `employee_id` = $employee_id and `category_id` = $category and `subcategory_id`=$subcategory_id";
echo $query;
if (mysqli_query($conn, $query)) {
    // echo "Employee ID updated successfully in the database.";
} else {
    // echo "Error updating record: " . mysqli_error($conn);
}  // echo "Error: " . mysqli_error($conn);

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
        <h4>Professional Development Activities Detail</h4>
    </div>

    <div class="parent-container">
        <div class="child-conainer">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                Add </button>

            <div class="table-container">
                <table id="details_table" class="display" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sub Activity</th>
                            <th>pbasYear</th>
                            <th>activityTitle</th>
                            <th>briefRole</th>
                            <th>semester</th>
                            <th>hoursSpentAnswerBook</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$row['subActivity']}</td>";
                            echo "<td>{$row['pbasYear']}</td>";
                            echo "<td>{$row['activityTitle']}</td>";
                            echo "<td>{$row['briefRole']}</td>";
                            echo "<td>{$row['semester']}</td>";
                            echo "<td>{$row['hoursSpentAnswerBook']}</td>";
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Professional Development Activities Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="myForm" action="cat2_development_activities_insert.php" method="POST"
                        enctype="multipart/form-data">
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
                                <label for="mainActivity">Main Activity:</label>
                                <select class="form-control" id="mainActivity" name="mainActivity">
                                    <option value="discipline_related_co_curricular_activities">Professional Development
                                        Activities</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="subActivity">Sub Activity:</label>
                                <select class="form-control" id="subActivity" name="subActivity">
                                    <option value="select_sub_activity">Select Sub Activity</option>
                                    <option value="industrial_visits">FDP</option>
                                    <option value="remedial_classes">Workshop</option>
                                    <option value="special_classes">Seminar
                                    </option>
                                    <option value="academic_clubs_committee">Lecture / Expert Talk</option>
                                    <option value="debates_presentations">STTP</option>
                                    <option value="internships">Industrial Training</option>
                                    <option value="exchange_programs">Recognized organization Visit</option>
                                    <option value="preparing_students_events">Dissemination Activity attended</option>
                                    <option value="career_counseling">Training</option>
                                    <option value="competitive_exams">Conference</option>
                                    <option value="expert_lectures">Professional Membership
                                    </option>
                                    <option value="tech_fest">JOURNALS/ Magazine Article</option>
                                    <option value="celebrations">Conference paper Presentation</option>
                                    <option value="celebrations">Conference poster Presentation</option>
                                    <option value="celebrations">Artical</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="activityTitle">Activity Title:</label>
                                <input type="text" class="form-control" id="activityTitle" name="activityTitle">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="briefRole">Brief Role/No of Students:</label>
                                <input type="text" class="form-control" id="briefRole" name="briefRole">
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
                                <label for="hoursSpentAnswerBook">Hours Spent:</label>
                                <input type="number" class="form-control" id="hoursSpentAnswerBook"
                                    name="hoursSpentAnswerBook" min="0">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="attachment">Attachment (if available):</label>
                                <input type="file" class="form-control" id="attachment" name="attachment"
                                    accept=".pdf, .doc, .docx">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary" id="submitButton">Submit</button>
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
                    <h5 class="modal-title" id="editModalLabel">Add Professional Development Activities Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <form id="editForm" action="cat2_developmentactivities_update.php" method="POST"
                        enctype="multipart/form-data">
                        <input type="hidden" name="entry_id" id="editEntryId">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="editpbasYear">PBAS Year:</label>
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
                                <label for="editmainActivity">Main Activity:</label>
                                <select class="form-control" id="editmainActivity" name="editmainActivity">
                                    <option value="discipline_related_co_curricular_activities">Professional Development
                                        Activities</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="editsubActivity">Sub Activity:</label>
                                <select class="form-control" id="editsubActivity" name="editsubActivity">
                                    <option value="select_sub_activity">Select Sub Activity</option>
                                    <option value="industrial_visits">FDP</option>
                                    <option value="remedial_classes">Workshop</option>
                                    <option value="special_classes">Seminar
                                    </option>
                                    <option value="academic_clubs_committee">Lecture / Expert Talk</option>
                                    <option value="debates_presentations">STTP</option>
                                    <option value="internships">Industrial Training</option>
                                    <option value="exchange_programs">Recognized organization Visit</option>
                                    <option value="preparing_students_events">Dissemination Activity attended</option>
                                    <option value="career_counseling">Training</option>
                                    <option value="competitive_exams">Conference</option>
                                    <option value="expert_lectures">Professional Membership
                                    </option>
                                    <option value="tech_fest">JOURNALS/ Magazine Article</option>
                                    <option value="celebrations">Conference paper Presentation</option>
                                    <option value="celebrations">Conference poster Presentation</option>
                                    <option value="celebrations">Artical</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="editactivityTitle">Activity Title:</label>
                                <input type="text" class="form-control" id="editactivityTitle" name="editactivityTitle">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="editbriefRole">Brief Role/No of Students:</label>
                                <input type="text" class="form-control" id="editbriefRole" name="editbriefRole">
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
                                <label for="edithoursSpentAnswerBook">Hours Spent:</label>
                                <input type="number" class="form-control" id="edithoursSpentAnswerBook"
                                    name="edithoursSpentAnswerBook" min="0">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="editAttachment">Attachment (if available):</label>
                                <input type="file" class="form-control" id="editAttachment" name="editAttachment"
                                    accept=".pdf, .doc, .docx">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="editdescription">Description:</label>
                            <textarea class="form-control" id="editdescription" name="editdescription"
                                rows="4"></textarea>
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
                    url: "cat2_developmentactivities_update.php",
                    data: {
                        entry_id: entryId
                    },
                    success: function (response) {
                        // Parse the JSON response
                        var entryData = JSON.parse(response);
                        $('#editEntryId').val(entryId);
                        $('#editPbasYear').val(entryData.pbasYear);
                        $('#editmainActivity').val(entryData.mainActivity);
                        $('#editsubActivity').val(entryData.subActivity);
                        $('#editactivityTitle').val(entryData.activityTitle);
                        $('#editbriefRole').val(entryData.briefRole);
                        $('#editsemester').val(entryData.semester);
                        $('#edithoursSpentAnswerBook').val(entryData.hoursSpentAnswerBook);
                        $('#editdescription').val(entryData.description);
                        $('#editAttachment').val(entryData.attachment)
                        $('#editModal').modal('show');
                    }
                });
            });
        });
    </script>
    <?php require "./components/category-table-top-script.php" ?>
    <!-- <script>
        document.getElementById('myForm').addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent the default form submission

            const documentInput = document.getElementById('attachment');
            const file = documentInput.files[0];

            if (!file) {
                alert('Please select a file to upload.');
                return;
            }

            // Create a FormData object to hold the file data
            const formData = new FormData(this); // 'this' refers to the form element

            // Send an AJAX request to the server using Fetch API
            fetch('cat2_development_activities_insert.php', {
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
    </script> -->

    <script>
        document.getElementById('myForm').addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent the default form submission

            const documentInput = document.getElementById('attachment');
            const file = documentInput.files[0];

            if (!file) {
                alert('Please select a file to upload.');
                return;
            }

            // Create a FormData object to hold the file data
            const formData = new FormData(this); // 'this' refers to the form element

            // Send an AJAX request to the server using Fetch API
            fetch('cat2_development_activities_insert.php', {
                method: 'POST',
                body: formData,
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to upload file.');
                    }
                    alert('File uploaded successfully.'); // Show success message or handle response accordingly
                    $('#myModal').modal('hide'); // Close modal popup
                })
                .catch(error => {
                    alert(error.message); // Display error message
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
            $("#myForm").submit(function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "cat2_development_activities_insert.php",
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
            $('.btn-delete').click(function () {
                var id = $(this).data('id');
                $('#deleteConfirmationModal').modal('show');
                $('#confirmDeleteBtn').click(function () {
                    $.ajax({
                        type: "POST",
                        url: "developmentactivities_delete_entry.php",
                        data: {
                            id: id
                        },
                        success: function (response) {
                            location.reload();
                            // alert(response);
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