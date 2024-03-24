<?php
// Include Composer Autoload
require 'vendor/autoload.php';

// Fetch details from the dashboard
// $cat1TotalPointsJson = getCat1TotalPoints();
// $cat1TotalPoints = json_decode($cat1TotalPointsJson, true)['total_points'];

// $cat2TotalPointsJson = getCat2TotalPoints();
// $cat2TotalPoints = json_decode($cat2TotalPointsJson, true)['total_points'];

// $cat3TotalPointsJson = getCat3TotalPoints();
// $cat3TotalPoints = json_decode($cat3TotalPointsJson, true)['total_points'];

// $totalPoints = $cat1TotalPoints + $cat2TotalPoints + $cat3TotalPoints;

// Compose Email Body
$emailBody = "
    <h2>Dashboard Details</h2>
    <p>Cat 1 Total Points: 23</p>
    <p>Cat 2 Total Points: 32</p>
    <p>Cat 3 Total Points: 32</p>
    <p>Total Points: 431</p>
";

// Configure PHPMailer
$mail = new PHPMailer\PHPMailer\PHPMailer();
$mail->isSMTP();
$mail->Host = 'smtp.com';
$mail->SMTPAuth = true;
$mail->SMTPDebug = 2;
$mail->Username = 'Pushti Depani';
$mail->Password = 'Slgi@690';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

$mail->setFrom('pushti.depani110402@marwadiuniversity.ac.in', 'Your Name');
$mail->addAddress('pushti18depani@gmail.com', 'Recipient Name');

$mail->isHTML(true);
$mail->Subject = 'Dashboard Details';
$mail->Body = $emailBody;

// Send Email
if (!$mail->send()) {
    echo 'Email could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Email has been sent';
}
?>