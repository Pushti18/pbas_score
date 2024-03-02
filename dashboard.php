<?php
session_start();
include("db_connection.php");
global $conn;

$employee_id = $_SESSION['employee_id'];
function getCat1TotalPoints()
{
    global $conn;

    $sql = "SELECT SUM(total_points) as total_points FROM (
        SELECT SUM(points) as total_points FROM direct_teaching WHERE employee_id = " . $_SESSION['employee_id'] . "  AND cat1_id = 'cat1'
        UNION ALL
        SELECT SUM(points) as total_points FROM exam_duties WHERE employee_id = " . $_SESSION['employee_id'] . "  AND cat1_id = 'cat1'
        UNION ALL
        SELECT SUM(points) as total_points FROM learning_methodologies WHERE employee_id = " . $_SESSION['employee_id'] . "  AND cat1_id = 'cat1'
        UNION ALL
        SELECT SUM(points) as total_points FROM courses WHERE employee_id = " . $_SESSION['employee_id'] . "  AND cat1_id = 'cat1'
        UNION ALL
        SELECT SUM(points) as total_points FROM mentoring WHERE employee_id = " . $_SESSION['employee_id'] . "  AND cat1_id = 'cat1'
    ) as total_points_table";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    // echo ($row);

    // Convert the associative array to a JSON string
    $jsonString = json_encode($row);
    // echo ($jsonString);
    return $jsonString;
}
function getCat2TotalPoints()
{
    global $conn;

    $sql = "SELECT 
        (SELECT SUM(points) FROM discipline WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat2_id = 'cat2') +
        (SELECT SUM(points) FROM othercocurricular WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat2_id = 'cat2') +
        (SELECT SUM(points) FROM extension WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat2_id = 'cat2') +
        (SELECT SUM(points) FROM administrative WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat2_id = 'cat2') +
        (SELECT SUM(points) FROM others WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat2_id = 'cat2') +
        (SELECT SUM(points) FROM development_activities WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat2_id = 'cat2') +
        (SELECT SUM(points) FROM participation WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat2_id = 'cat2') as total_points";

    $result = $conn->query($sql);
    if (!$result) {
        die('Invalid query: ' . $conn->error);
    }
    $row = $result->fetch_assoc();
    if (!isset($row['total_points'])) {
        die('Unexpected query result format');
    }

    return $row['total_points'];
}


function getCat3TotalPoints()
{
    global $conn;

    $sql = "SELECT 
        (SELECT SUM(pbas_score) FROM research WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat3_id = 'cat3') +
        (SELECT SUM(pbas_score) FROM project_output WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat3_id = 'cat3') +
        (SELECT SUM(pbas_score) FROM guidance WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat3_id = 'cat3') +
        (SELECT SUM(pbas_score) FROM fellowship WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat3_id = 'cat3') +
        (SELECT SUM(pbas_score) FROM expert WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat3_id = 'cat3') +
        (SELECT SUM(pbas_score) FROM development WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat3_id = 'cat3') as total_points";
    // echo ($sql);
    $result = $conn->query($sql);
    if (!$result) {
        die('Invalid query: ' . $conn->error);
    }
    $row = $result->fetch_assoc();
    if (!isset($row['total_points'])) {
        die('Unexpected query result format');
    }

    return $row['total_points'];
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <link rel="stylesheet" href="./css/common.css" />
</head>

<body>
    <?php require "./components/header.php" ?>

    <div class="main_div">
        <div class="container">
            <br />
            <div class="dashboard-container">
                <div class="col-md-6 chart-container">
                    <!-- <h3>Point Pie Chart</h3> -->
                    <canvas id="myChart"></canvas>


                    <?php
                    $cat1TotalPointsJson = getCat1TotalPoints();
                    $cat1TotalPoints = json_decode($cat1TotalPointsJson, true)['total_points'];

                    $cat2TotalPointsJson = getCat2TotalPoints();
                    $cat2TotalPoints = json_decode($cat2TotalPointsJson, true)['total_points'];

                    $cat3TotalPointsJson = getCat3TotalPoints();
                    $cat3TotalPoints = json_decode($cat3TotalPointsJson, true)['total_points'];


                    $dataPoints = array(
                        array("label" => "Cat 1", "value" => $cat1TotalPoints),
                        array("label" => "Cat 2", "value" => $cat2TotalPointsJson),
                        array("label" => "Cat 3", "value" => $cat3TotalPointsJson),
                        array("label" => "Total Points", "value" => $cat1TotalPoints + $cat2TotalPointsJson + $cat3TotalPointsJson),
                    );
                    $totalPoints = array_sum(array_column($dataPoints, 'value'));
                    ?>
                    <script>
                        var ctx = document.getElementById('myChart').getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'pie',
                            data: {
                                labels: <?php echo json_encode(array_column($dataPoints, 'label')); ?>,
                                datasets: [{
                                    label: 'Total Points: <?php echo $totalPoints; ?>',
                                    data: <?php echo json_encode(array_column($dataPoints, 'value')); ?>,
                                    backgroundColor: ['#FF6384', '#36A2EB',
                                        '#FFCE56'
                                    ],
                                }]
                            },
                            options: {
                                responsive: true,
                                legend: {
                                    position: 'right',
                                },
                            }
                        });
                    </script>
                </div>

                <div class="planner-container">
                    <h3 class="mb-3">Planner</h3>
                    <form id="myForm" action="process.php" method="POST">
                        <div class="mb-3">
                            <label for="year">Year:</label>
                            <select id="year" name="year" class="form-control">
                                <option value="">Select Year</option>
                                <?php
                                $currentYear = date('Y');
                                for ($i = 0; $i < 5; $i++) {
                                    $yearOption = $currentYear . '-' . ($currentYear + 1);
                                    echo '<option value="' . $yearOption . '">' . $yearOption . '</option>';
                                    $currentYear++;
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="target">Target:</label>
                                <input type="text" class="form-control" id="target" name="target" placeholder="Ex: 10">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="category">Category:</label>
                                <select class="form-control" id="category" name="category">
                                    <option value="Category 1">Category 1</option>
                                    <option value="Category 2">Category 2</option>
                                    <option value="Category 3">Category 3</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <button class="btn btn-primary btn-md">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $("#myForm").submit(function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                var selectedCategory = $("#category").val();
                var redirectUrl = '';
                switch (selectedCategory) {
                    case 'Category 1':
                        redirectUrl = 'cat1.php?category=' + category + '&employee_id=' + employeeId;
                        break;
                    case 'Category 2':
                        redirectUrl = 'cat2.php?category=' + category + '&employee_id=' + employeeId;
                        break;
                    case 'Category 3':
                        redirectUrl = 'cat3.php?category=' + category + '&employee_id=' + employeeId;
                        break;
                    default:
                        alert("Please select a valid category.");
                        return false;
                }

                $.ajax({
                    type: "POST",
                    url: "process.php",
                    data: formData,
                    success: function (response) {
                        alert(response);
                        window.location.href = redirectUrl;
                    }
                });
            });
        });

        $('#year').on('change', function () {
            $('#target').prop('disabled', false);
            $('#category').prop('disabled', false);
            $('#target').val('');
            $('#category').val('');
        });

        $('#target').on('input', function () {
            if ($(this).val().length > 0) {
                $('#category').prop('disabled', false);
            } else {
                $('#category').prop('disabled', true);
            }
        });
        var redirectUrl = '';
        switch (selectedCategory) {
            case 'Category 1':
                redirectUrl = 'cat_1.php';
                break;
            case 'Category 2':
                redirectUrl = 'cat_2.php';
                break;
            case 'Category 3':
                redirectUrl = 'cat_3.php';
                break;
            default:
                alert("Please select a valid category.");
                return false;
        }
    </script>
</body>

</html>