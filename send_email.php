<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$mail = new PHPMailer(true);

$email = $_POST['email'];
$subject = $_POST['subject'];
$body = $_POST['body'];

try {
  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com';
  $mail->SMTPAuth = true;
  $mail->Username = "crackemail001@gmail.com";
  $mail->Password = "edbw liug swdc xwdh";
  $mail->SMTPSecure = 'ssl';
  $mail->Port = 465;

  $mail->setFrom("crackemail001@gmail.com");
  $mail->addAddress($email);
  $mail->isHTML(true);

  $mail->Subject = 'Email subject';
  $mail->Body = 'This is the email message.';
  // $mail->Subject = $subject;
  // $mail->Body = $body;
  $mail->send();
  if (!$mail->send()) {
    echo 'Error sending email: ' . $mail->ErrorInfo;
  } else {
    echo 'Email sent successfully!';
  }
  ?>
  <!-- <script>
    alert("mail sended!");
    window.location.href = "./index.php";
  </script> -->
  <?php
} catch (Exception $e) {
  echo $e;
  echo "there will be problem of sending mail";
}