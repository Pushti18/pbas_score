<?php
session_start();
include("db_connection.php");

$category_title = isset($_GET['category_title']) ? $_GET['category_title'] : '';
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';
$subcategory_title = isset($_GET['subcategory_title']) ? $_GET['subcategory_title'] : '';
$subcategory_id = isset($_GET['subcategory_id']) ? $_GET['subcategory_id'] : '';
global $conn;

$sql = "SELECT * FROM othercocurricular WHERE employee_id = '{$_SESSION['employee_id']}'";
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
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Professional Development Detail</title>
    <?php require "./components/category-table-script.php" ?>
</head>

<body>
    <?php require "./components/header.php" ?>

    <div class="main_div center">
        <h4>Professional Development Detail</h4>
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
                            // echo "<td>{$row['action']}</td>";
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Professional Development Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <!-- Form fields go here -->
                    <form id="myForm" action="cat2_othercocurricular_insert.php" method="POST"
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
                                    <option value="other_co_curricular_activities">Other
                                        Co-curricular Activities</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="subActivity">Sub Activity:</label>
                                <select class="form-control" id="subActivity" name="subActivity">
                                    <option value="select_sub_activity">Select Sub Activity</option>
                                    <option value="Co-conducting/co-ordinating of NSS activities">
                                        Co-conducting/co-ordinating of NSS activities</option>
                                    <option value="Co-conductination of NCC activities">Co-conductination of NCC
                                        activities</option>
                                    <option value="Arranging/Co-ordinating sports competitions">
                                        Arranging/Co-ordinating
                                        sports competitions</option>
                                    <option value="Arranging/Co-ordinating skits/drama/plays">
                                        Arranging/Co-ordinating
                                        skits/drama/plays</option>
                                    <option
                                        value="Arranging/Co-ordinating/Preparing students (for) Cultural Events in MU">
                                        Arranging/Co-ordinating/Preparing students (for) Cultural Events in MU
                                    </option>
                                    <option value="Preparing/Accompanying Students for External Cultural Events">
                                        Preparing/Accompanying Students for External Cultural Events</option>
                                    <option value="Arranging/Accompanying Students for External Cultural Events">
                                        Arranging/Accompanying Students for External Cultural Events</option>
                                    <option
                                        value="Arranging/co-ordinating/accompaying treking exceptional/fun excurions">
                                        Arranging/co-ordinating/accompaying treking exceptional/fun excurions
                                    </option>
                                    <option
                                        value="Conducting/arranging like skills related/events Eg. First aid, Tailoring, Cooking, etc">
                                        Conducting/arranging like skills related/events Eg. First aid, Tailoring,
                                        Cooking, etc</option>
                                    <option
                                        value="Preparing/Accompanying Students for/in national/international competitions/events">
                                        Preparing/Accompanying Students for/in national/international
                                        competitions/events</option>
                                    <option value="Expert Lectures/Seminars/Workshops for Students">Expert
                                        Lectures/Seminars/Workshops for Students</option>
                                    <option value="Tech Fest/Project Fair">Tech Fest/Project Fair</option>
                                    <option value="Celebrations Related to Special Subject/Discipline-related Days">
                                        Celebrations Related to Special Subject/Discipline-related Days</option>
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

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php require "./components/category-table-top-script.php" ?>
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
            fetch('cat2_othercocurricular_insert.php', {
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
            $("#myForm").submit(function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "cat2_othercocurricular_insert.php",
                    data: formData,
                    success: function (response) {
                        alert(response);
                    }
                });
            });
        });
    </script>
</body>

</html>