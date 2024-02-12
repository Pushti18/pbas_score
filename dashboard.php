<?php session_start(); ?>

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
                    $dataPoints = array(
                        array("label" => "Cat 1", "value" => 20),
                        array("label" => "Cat 2", "value" => 10),
                        array("label" => "Cat 3", "value" => 20),
                        array("label" => "Total Points", "value" => 50),
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
    $(document).ready(function() {
        $("#myForm").submit(function(e) {
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
                success: function(response) {
                    alert(response);
                    window.location.href = redirectUrl;
                }
            });
        });
    });

    $('#year').on('change', function() {
        $('#target').prop('disabled', false);
        $('#category').prop('disabled', false);
        $('#target').val('');
        $('#category').val('');
    });

    $('#target').on('input', function() {
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