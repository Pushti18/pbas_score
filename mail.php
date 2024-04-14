<?php

require './vendor/autoload.php';
session_start();
include ("db_connection.php");
global $conn;

$employee_id = $_SESSION['employee_id'];
$employeeId = 1;

$query = "SELECT email FROM employee";
$result = mysqli_query($conn, $query);
$emailAddresses = array();

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $emailAddresses[] = $row['email'];
    }
}

// Print all email addresses that will receive the email
echo "Emails that will receive the email:<br>";
foreach ($emailAddresses as $email) {
    echo $email . "<br>";
}
// $sql = "SELECT id, name FROM employee";

// $result = $conn->query($sql);
// // echo ($sql);
// $data = array();
// while ($row = $result->fetch_assoc()) {
//     $data[] = $row;
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
// function getCat2TotalPoints()
// {
//     global $conn;

//     $sql = "SELECT 
//         (SELECT SUM(points) FROM discipline WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat2_id = 'cat2') +
//         (SELECT SUM(points) FROM othercocurricular WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat2_id = 'cat2') +
//         (SELECT SUM(points) FROM extension WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat2_id = 'cat2') +
//         (SELECT SUM(points) FROM administrative WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat2_id = 'cat2') +
//         (SELECT SUM(points) FROM others WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat2_id = 'cat2') +
//         (SELECT SUM(points) FROM development_activities WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat2_id = 'cat2') +
//         (SELECT SUM(points) FROM participation WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat2_id = 'cat2') as total_points";

//     $result = $conn->query($sql);
//     if (!$result) {
//         die('Invalid query: ' . $conn->error);
//     }
//     $row = $result->fetch_assoc();
//     if (!isset($row['total_points'])) {
//         die('Unexpected query result format');
//     }

//     return $row['total_points'];
// }

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
    // $row = $result->fetch_assoc();
    // $jsonString = json_encode($row);
    // return $jsonString;
}
function getCat3TotalPoints()
{
    global $conn;

    // $sql = "SELECT 
    //     (SELECT SUM(pbas_score) FROM research WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat3_id = 'cat3') +
    //     (SELECT SUM(pbas_score) FROM project_output WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat3_id = 'cat3') +
    //     (SELECT SUM(pbas_score) FROM guidance WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat3_id = 'cat3') +
    //     (SELECT SUM(pbas_score) FROM fellowship WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat3_id = 'cat3') +
    //     (SELECT SUM(pbas_score) FROM expert WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat3_id = 'cat3') +
    //     (SELECT SUM(pbas_score) FROM development WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat3_id = 'cat3') as total_points";
    // echo ($sql);
    $sql = "SELECT 
        (SELECT IFNULL(SUM(pbas_score), 0) FROM research WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat3_id = 'cat3') +
        (SELECT IFNULL(SUM(pbas_score), 0) FROM project_output WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat3_id = 'cat3') +
        (SELECT IFNULL(SUM(pbas_score), 0) FROM guidance WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat3_id = 'cat3') +
        (SELECT IFNULL(SUM(pbas_score), 0) FROM fellowship WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat3_id = 'cat3') +
        (SELECT IFNULL(SUM(pbas_score), 0) FROM expert WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat3_id = 'cat3') +
        (SELECT IFNULL(SUM(pbas_score), 0) FROM development WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat3_id = 'cat3') as total_points";

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
} else {
}
$sql = "SELECT target FROM pbas_score WHERE employee_id =  " . $_SESSION['employee_id'] . " ORDER BY year DESC LIMIT 1";
// echo ($sql);
$result = $conn->query($sql);
$target = null;
if ($result !== false && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $target = $row['target'];
} else {
    echo "Error: " . $conn->error;
}
$cat1TotalPointsJson = getCat1TotalPoints();
$cat1TotalPoints = json_decode($cat1TotalPointsJson, true)['total_points'];

$cat2TotalPointsJson = getCat2TotalPoints();
$cat2TotalPoints = json_decode($cat2TotalPointsJson, true)['total_points'];

$cat3TotalPointsJson = getCat3TotalPoints();
$cat3TotalPoints = json_decode($cat3TotalPointsJson, true)['total_points'];


$totalPoints = $cat1TotalPoints + $cat2TotalPointsJson + $cat3TotalPointsJson;
if (isset($target)) {
    $percentageAchieved = ($totalPoints / $target) * 100;
    $percentagecat1TotalPoints = ($cat1TotalPoints / $target) * 100;
    $percentagecat2TotalPoints = ($cat2TotalPointsJson / $target) * 100;
    $percentagecat3TotalPoints = ($cat3TotalPointsJson / $target) * 100;
    // echo "<p>Target: $target</p>";
    // echo "<p>Percentage achieved: $percentageAchieved%</p>";
} else {
    echo "<p>No target found.</p>";
}
// }
$mail = new PHPMailer\PHPMailer\PHPMailer();
// $cat1TotalPoints = 50;
// $cat2TotalPoints = 30;
// $cat3TotalPoints = 20;
// $target = 100;
// $percentageAchieved = ($cat1TotalPoints + $cat2TotalPoints + $cat3TotalPoints) / $target * 100;

$message = '
<html>
<head>
    <title>Dashboard Details</title>
</head>
<body>


    
    <p>Hello Faculty,</p>
    <p>We hope this email finds you well. We wanted to provide you with an update on your progress towards your targets.</p>
    <p>We are thrilled to see your efforts in reaching your targets. Your dedication is commendable!</p>
  
    <h3>Point Pie Chart</h3>
    <div class="col-md-6 chart-container">
        <canvas id="myChart"></canvas>
    </div>
    <p>We see that you have made progress towards your goals:</p>
    <ul>
        <li>Category 1: ' . $cat1TotalPoints . ' points (' . $percentagecat1TotalPoints . '% of target)</li>
        <li>Category 2: ' . $cat2TotalPoints . ' points (' . $percentagecat2TotalPoints . '% of target)</li>
        <li>Category 3: ' . $cat3TotalPoints . ' points (' . $percentagecat3TotalPoints . '% of target)</li>
    </ul>
    <p>The total points achieved are ' . $totalPoints . ' out of a target of ' . $target . ', which is a ' . $percentageAchieved . '% achievement.</p>
    <p>To reach your target, we encourage you to focus on areas where improvement is needed and continue your hard work.</p>
    <p>To achieve your target:</p>
    <ul>
        <li>Focus on improving performance in each category.</li>
        <li>Regularly monitor your progress.</li>
        <li>Seek assistance from colleagues and mentors if needed.</li>
    </ul>
    <p>We believe in your capabilities and are here to support you in every step of the way.</p>
    <p>Thank you for your dedication and effort. We believe in your ability to achieve your goals.</p>
    <p>Best regards,<br>ICT Department</p>
    <img src="uploads\Screenshot 2024-02-02 211218.png" alt="Your Image Alt Text">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <script>
        var ctx = document.getElementById("myChart").getContext("2d");
        var myChart = new Chart(ctx, {
            type: "pie",
            data: {
                labels: ["Category 1", "Category 2", "Category 3"],
                datasets: [{
                    label: "Points",
                    data: [' . $cat1TotalPoints . ', ' . $cat2TotalPoints . ', ' . $cat3TotalPoints . '],
                    backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56"]
                }]
            }
        });
    </script>
</body>
</html>
';
$subject = 'Dashboard Details';
// SMTP settings
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
// $mail->SMTPDebug = 2; 
$mail->Username = 'pushti.depani110402@marwadiuniversity.ac.in';
$mail->Password = 'fpdx poun rise llfp';
$mail->SMTPSecure = 'tls'; // or 'ssl'
$mail->Port = 587; // or 465

// Email content
$mail->setFrom('pushti.depani110402@marwadiuniversity.ac.in', 'ABC');
// $mail->addAddress('pushti18depani@gmail.com');
foreach ($emailAddresses as $email) {
    $mail->addAddress($email);
}
$mail->Subject = $subject;

$mail->Body = $message;
$mail->AltBody = 'This is an email with a dashboard details.';

if (!$mail->send()) {
    echo 'Error sending email: ' . $mail->ErrorInfo;
} else {
    echo 'Email sent successfully!';
}
?>