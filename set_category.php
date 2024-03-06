<?php
session_start();

// Get category from request body
$category = $_POST['category'];

// Set session variable based on category
switch ($category) {
    case 'Category 1':
        $_SESSION['cat1'] = "cat1";
        $redirectUrl = 'cat_1.php?employee_id=' . $employeeId;
        break;
    case 'Category 2':
        $_SESSION['cat2'] = "cat2";
        $redirectUrl = 'cat_2.php?employee_id=' . $employeeId;
        break;
    case 'Category 3':
        $_SESSION['cat3'] = "cat3";
        $redirectUrl = 'cat_3.php?employee_id=' . $employeeId;
        break;
    default:
    // Handle invalid category
}

// Echo the redirect URL for the AJAX response
echo $redirectUrl;
?>