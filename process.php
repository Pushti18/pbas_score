<?php
include("db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $year = $_POST['year'];
    $target = $_POST['target'];
    $category = $_POST['category'];

    // Assuming you have a session variable storing the employee's information
    // Adjust this accordingly based on how you manage user sessions
    $employeeId = 1; 

    if (!empty($year) && !empty($target) && !empty($category)) {
        $sql = "INSERT INTO pbas_score (year, target, category, employee_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $year, $target, $category, $employeeId);

        if ($stmt->execute()) {
            $selectedCategory = $_POST['category'];
            $redirectUrl = '';

            switch ($selectedCategory) {
                case 'Category 1':
                    $redirectUrl = 'cat_1.php?category=' . $category . '&employee_id=' . $employeeId;
                    break;
                case 'Category 2':
                    $redirectUrl = 'cat_2.php?category=' . $category . '&employee_id=' . $employeeId;
                    break;
                case 'Category 3':
                    $redirectUrl = 'cat_3.php?category=' . $category . '&employee_id=' . $employeeId;
                    break;
                default:
                    $redirectUrl = 'default_page.php';
            }

            header("Location: $redirectUrl");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Invalid data submitted!";
    }
} else {
    // Handle cases where the request method is not POST
}

$conn->close();
?>