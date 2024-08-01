<?php
require_once '../db_connection.php'; // Adjust the path as needed

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'founder') {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['catalog_id'])) {
    $catalog_id = intval($_GET['catalog_id']); // Sanitize input

    // Prepare the SQL statement
    $stmt = $conn->prepare("DELETE FROM katalog WHERE catalog_id = ?");
    $stmt->bind_param("i", $catalog_id); // "i" indicates the type is integer

    if ($stmt->execute()) {
        // If delete is successful, redirect back to katalog.php
        header("Location: katalog.php");
        exit();
    } else {
        // Handle the error
        echo "Error deleting record: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
