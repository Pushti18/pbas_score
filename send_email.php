<?php
// Include any necessary files or configurations

// Fetch necessary data
// You may need to adjust this based on your actual data retrieval method
$target = "Sample Target"; // Example target value
$cat1TotalPoints = 100; // Example total points for category 1
$cat2TotalPoints = 150; // Example total points for category 2
$cat3TotalPoints = 200; // Example total points for category 3

// Compose email body
$emailBody = "
<html>
<head>
  <title>Hourly Report</title>
</head>
<body>
  <h2>Hourly Report</h2>
  <p>Target: $target</p>
  <p>Category 1 Total Points: $cat1TotalPoints</p>
  <p>Category 2 Total Points: $cat2TotalPoints</p>
  <p>Category 3 Total Points: $cat3TotalPoints</p>
</body>
</html>
";

// Email headers
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: ict@gmail.com" . "\r\n"; // Replace with your email

// Send email
$to = "pushti18depani@gmail.com"; // Replace with recipient email address
$subject = "Hourly Report";
$mailSent = mail($to, $subject, $emailBody, $headers);

// Check if mail was sent successfully
if ($mailSent) {
    echo "Email sent successfully";
} else {
    echo "Email sending failed";
}
?>