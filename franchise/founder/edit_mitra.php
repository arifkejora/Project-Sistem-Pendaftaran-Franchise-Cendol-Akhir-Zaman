<?php
require_once '../db_connection.php'; // Sesuaikan dengan path yang benar
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'founder') {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mitra_id = $_POST['mitra_id'];
    $new_status = $_POST['edit_status'];

    // Update status mitra
    $sql_update = "UPDATE mitra SET status_mitra = ? WHERE mitra_id = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("si", $new_status, $mitra_id);
    
    if ($stmt->execute()) {
        // Redirect back to mitra.php with success message
        $_SESSION['success_message'] = "Status mitra berhasil diperbarui.";
        header("Location: mitra.php");
        exit();
    } else {
        // Redirect back to mitra.php with error message
        $_SESSION['error_message'] = "Gagal memperbarui status mitra.";
        header("Location: mitra.php");
        exit();
    }

    $stmt->close();
} else {
    // If accessed directly without POST method, redirect to index.php
    header("Location: ../index.php");
    exit();
}
?>
