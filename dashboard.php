<?php
session_start();
include ("db_connection.php");
global $conn;

$employee_id = $_SESSION['employee_id'];
$employeeId = $_SESSION['employee_id'];

function getCat1TotalPoints()
{
    global $conn;
    $sql = "SELECT IFNULL(SUM(total_points), 0) as total_points FROM (
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
    $jsonString = json_encode($row);
    return $jsonString;
}

function getCat2TotalPoints()
{
    global $conn;
    $sql = "SELECT 
        (SELECT IFNULL(SUM(points), 0) FROM discipline WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat2_id = 'cat2') +
        (SELECT IFNULL(SUM(points), 0) FROM othercocurricular WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat2_id = 'cat2') +
        (SELECT IFNULL(SUM(points), 0) FROM extension WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat2_id = 'cat2') +
        (SELECT IFNULL(SUM(points), 0) FROM administrative WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat2_id = 'cat2') +
        (SELECT IFNULL(SUM(points), 0) FROM others WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat2_id = 'cat2') +
        (SELECT IFNULL(SUM(points), 0) FROM development_activities WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat2_id = 'cat2') +
        (SELECT IFNULL(SUM(points), 0) FROM participation WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat2_id = 'cat2') as total_points";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $jsonString = json_encode($row);
    return $jsonString;
}

function getCat3TotalPoints()
{
    global $conn;

    $sql = "SELECT 
        (SELECT IFNULL(SUM(pbas_score), 0) FROM research WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat3_id = 'cat3') +
        (SELECT IFNULL(SUM(pbas_score), 0) FROM project_output WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat3_id = 'cat3') +
        (SELECT IFNULL(SUM(pbas_score), 0) FROM guidance WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat3_id = 'cat3') +
        (SELECT IFNULL(SUM(pbas_score), 0) FROM fellowship WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat3_id = 'cat3') +
        (SELECT IFNULL(SUM(pbas_score), 0) FROM expert WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat3_id = 'cat3') +
        (SELECT IFNULL(SUM(pbas_score), 0) FROM development WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat3_id = 'cat3') as total_points";

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $jsonString = json_encode($row);
    return $jsonString;
}

$_SESSION['cat1'] = "cat1";
$_SESSION['cat2'] = "cat2";
$_SESSION['cat3'] = "cat3";

function setSession($category)
{
    switch ($category) {
        case 'Category 1':
            $_SESSION['cat1'] = "cat1";
            $redirectUrl = 'cat_1.php?employee_id=' . $_GET['employee_id'] . '&cat=' . urlencode($_SESSION['cat1']);
            break;
        case 'Category 2':
            break;
        case 'Category 3':
            break;
        default:
            $redirectUrl = 'default.php?employee_id=' . $_GET['employee_id'];
            break;
    }
    header('Location: ' . $redirectUrl);
    exit;
}

if (isset($_GET['category'])) {
    setSession($_GET['category']);
}

$sql = "SELECT target FROM pbas_score WHERE employee_id =  " . $_SESSION['employee_id'] . " ORDER BY year DESC LIMIT 1";
$result = $conn->query($sql);
$target = 0;
if ($result !== false) {
    if ($result->num_rows <= 0) {
        $target = 0;
    } else {
        $row = $result->fetch_assoc();
        $target = $row['target'];
    }
} else {
    echo "Error: " . $conn->error;
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
                    <canvas id="myChart"></canvas>
                    <?php
                    if (isset($target)) {
                        echo "<p>Target Set: $target</p>";
                    } else {
                        echo "<p>No target found.</p>";
                    }

                    $cat1TotalPointsJson = getCat1TotalPoints();
                    $cat2TotalPointsJson = getCat2TotalPoints();
                    $cat3TotalPointsJson = getCat3TotalPoints();

                    $percentagecat1TotalPoints = 0;
                    $percentagecat2TotalPoints = 0;
                    $percentagecat3TotalPoints = 0;
                    $percentageAchieved = 0;

                    $cat1TotalPoints = json_decode($cat1TotalPointsJson, true)['total_points'];
                    $cat2TotalPoints = json_decode($cat2TotalPointsJson, true)['total_points'];
                    $cat3TotalPoints = json_decode($cat3TotalPointsJson, true)['total_points'];

                    if ($cat3TotalPoints !== 0 || $cat3TotalPoints !== 0 || $cat3TotalPoints !== 0) {
                        $totalPoints = $cat1TotalPoints + $cat2TotalPoints + $cat3TotalPoints;

                        if ($totalPoints > 0 && isset($target)) {
                            $percentageAchieved = ($totalPoints / $target) * 100;
                            $percentagecat1TotalPoints = ($cat1TotalPoints / $target) * 100;
                            $percentagecat2TotalPoints = ($cat2TotalPoints / $target) * 100;
                            $percentagecat3TotalPoints = ($cat3TotalPoints / $target) * 100;

                            echo "<p>Percentage achieved: $percentageAchieved%</p>";
                        } else {
                            echo "<p>No target found.</p>";
                        }
                        $dataPoints = array(
                            array("label" => "Cat 1: $cat1TotalPoints", "value" => ($percentagecat1TotalPoints)),
                            array("label" => "Cat 2: $cat2TotalPoints", "value" => ($percentagecat2TotalPoints)),
                            array("label" => "Cat 3: $cat3TotalPoints", "value" => ($percentagecat3TotalPoints)),
                            array("label" => "Total Points : $totalPoints", "value" => $percentageAchieved),
                        );
                    }
                    // $totalPoints = array_sum(array_column($dataPoints, 'value'));
                    ?>
                    <script>
                        var ctx = document.getElementById('myChart').getContext('2d');
                        console.log(ctx);
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

                <div class="col-md-4 planner-container">
                    <h3 class="mb-3">Planner</h3>
                    <form id="myForm" action="process.php" method="POST">

                        <label for="year">Year:</label>
                        <select id="year" name="year" class="form-control year-dropdown">
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

                        <div class="year-dropdown">
                            <label for="target">Target:</label>
                            <input type="text" class="form-control" id="target" name="target" placeholder="Ex: 10">
                        </div>
                        <br>
                        <div>
                            <button class="btn btn-primary btn-md">Submit</button>
                        </div>
                    </form>
                </div>

                <!-- <div class="planner-container">
                    <ul class="category-list">
                        <li class="category-item">Category 1</li>
                        <li class="category-item">Category 2</li>
                        <li class="category-item">Category 3</li>
                    </ul>
                </div> -->

                <div class="col-md-4 planner-container" id="categories">
                    <br>
                    <ul class="planner-container">
                        <a href="cat_1.php?employee_id=<?php echo $employeeId; ?>&amp;cat=<?php echo urlencode($_SESSION['cat1']); ?>"
                            class="category-tag" data-category="Category 1" onclick="setSession('Category 1')">Category
                            1</a>
                    </ul>
                    <br>
                    <ul class="planner-container">
                        <a href="cat_2.php?employee_id=<?php echo $employeeId; ?>&amp;cat=<?php echo urlencode($_SESSION['cat2']); ?>"
                            class="category-tag" data-category="Category 2" onclick="setSession('Category 1')">Category
                            2</a>
                    </ul>
                    <br>
                    <ul class="planner-container">
                        <a href="cat_3.php?employee_id=<?php echo $employeeId; ?>&amp;cat=<?php echo urlencode($_SESSION['cat3']); ?>"
                            class="category-tag" data-category="Category 3" onclick="setSession('Category 1')">Category
                            3</a>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        // var ctx = document.getElementById('myChart').getContext('2d');
        // var myChart = new Chart(ctx, {
        //     type: 'pie',
        //     data: {
        //         labels: <?php echo json_encode(array_column($dataPoints, 'label')); ?>,
        //         datasets: [{
        //             label: 'Total Points: <?php echo $totalPoints; ?>',
        //             data: <?php echo json_encode(array_column($dataPoints, 'value')); ?>,
        //             backgroundColor: ['#FF6384', '#36A2EB',
        //                 '#FFCE56'
        //             ],
        //         }]
        //     },
        //     options: {
        //         responsive: true,
        //         legend: {
        //             position: 'right',
        //         },
        //     }
        // });

        function setSession(category) {
            fetch('set_category.php', {
                method: 'POST',
                body: new URLSearchParams({
                    category: category
                })
            })
                .then(response => response.text())
                .then(redirectUrl => {
                    window.location.href = redirectUrl;
                })
                .catch(error => console.error(error));
        }

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function getUrlParameter(name) {
            name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
            var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
            var results = regex.exec(location.search);
            return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
        };

        // Check if status parameter exists
        var status = getUrlParameter('status');
        if (status === 'exists') {
            // Show SweetAlert message indicating that a record already exists
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'A record already exists for the academic year and employee ID combination!',
            });
        }
    </script>
</body>

</html>