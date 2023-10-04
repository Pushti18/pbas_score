<?php
session_start();
$_SESSION['id_entered'] = $_POST['id_entered'];
// echo $_SESSION['id_entered'];
// exit(0);
    if(isset($_POST['login_enter']))
    {
        $id_entered = $_POST['id_entered'];
        header('Location: dashboard.php');
        echo $_SESSION ['id_entered'];
    }
?>