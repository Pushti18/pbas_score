<?php
session_start();
include("db_connection.php");

$category_title = isset($_GET['category_title']) ? $_GET['category_title'] : '';
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';
$subcategory_title = isset($_GET['subcategory_title']) ? $_GET['subcategory_title'] : '';
$subcategory_id = isset($_GET['subcategory_id']) ? $_GET['subcategory_id'] : '';
global $conn;

$sql = "SELECT * FROM expert WHERE employee_id = '{$_SESSION['employee_id']}'";
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
    <title>Expert Talk</title>
    <?php require "./components/category-table-script.php" ?>
</head>

<body>
    <?php require "./components/header.php" ?>

    <div class="main_div center">
        <h4>Expert Talk</h4>
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
                            <th>TOPIC</th>
                            <th>LECTURE DETAIL</th>
                            <th>INSTITUTE NAME</th>
                            <th>PBAS YEAR</th>
                            <th>TYPE</th>
                            <th>TALK LEVEL</th>
                            <th>APPROVAL STATUS</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$row['topic']}</td>";
                            echo "<td>{$row['lecture_detail']}</td>";
                            echo "<td>{$row['institute_name']}</td>";
                            echo "<td>{$row['pbas_year']}</td>";
                            echo "<td>{$row['type']}</td>";
                            echo "<td>{$row['talk_level']}</td>";

                            // echo "<td>{$row['approval_status']}</td>";
                            // echo "<td><a href='edit_research.php?id={$row['id']}'>Edit</a> | <a href='delete_research.php?id={$row['id']}'>Delete</a></td>";
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Expert Talk Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <form id="myForm" action="cat3_expert_insert.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="employee_id" value="<?php echo $_SESSION['employee_id']; ?>">
                        <input type="hidden" name="subcategory_id" value="<?php echo $subcategory_id; ?>">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="topic">Topic:</label>
                                <input type="text" class="form-control" id="topic" name="topic">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="lectureDetail">Lecture Detail:</label>
                                <input type="text" class="form-control" id="lectureDetail" name="lectureDetail">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="instituteName">Institute Name:</label>
                                <input type="text" class="form-control" id="instituteName" name="instituteName">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="dateToTalk">Date to Talk:</label>
                                <input type="date" class="form-control" id="dateToTalk" name="dateToTalk">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="talkLevel">Talk Level:</label>
                                <select class="form-control" id="talkLevel" name="talkLevel">
                                    <option value="Please Select">Please Select</option>
                                    <option value="National">National</option>
                                    <option value="International">International</option>
                                    <option value="State">State</option>
                                    <option value="University">University</option>
                                    <option value="Academic">Academic</option>
                                    <option value="Association">Association</option>
                                    <option value="Local">Local</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="type">Type:</label>
                                <select class="form-control" id="type" name="type">
                                    <option value="Lecture">Lecture</option>
                                    <option value="Paper">Paper</option>
                                    <!-- Add more options for types as needed -->
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="attachment">Talk Proof (if available):</label>
                                <input type="file" class="form-control" id="attachment" name="attachment" accept=".pdf">
                            </div>
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
                        </div>
                        <button type="submit" class="btn btn-primary" id="submitButton">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $talkLevel = $_POST["talkLevel"];
            $type = $_POST["type"];
            $pbasScores = [
                "International" => ["Lecture" => 7, "Paper" => 5],
                "National" => ["Lecture" => 5, "Paper" => 3],
                "State" => ["Lecture" => 3, "Paper" => 2],
            ];
            if (isset($pbasScores[$talkLevel]) && isset($pbasScores[$talkLevel][$type])) {
                $pbasScore = $pbasScores[$talkLevel][$type];
                echo "PBAS Score: $pbasScore";
            } else {
                echo "Invalid selection";
            }
        }
        ?>
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
            fetch('cat3_expert_insert.php', {
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
        $(document).ready(function () {
            $("#myForm").submit(function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "cat3_expert_insert.php",
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