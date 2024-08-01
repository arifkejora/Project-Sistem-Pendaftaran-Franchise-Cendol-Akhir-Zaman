<?php
session_start();
require_once '../db_connection.php'; // Adjust the path as necessary

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'mitra') {
    header("Location: ../login.php");
    exit();
}

if (isset($_POST['registration_id'])) {
    $registration_id = $_POST['registration_id'];

    // Check if file was uploaded
    if (!empty($_FILES['paymentReceipt']['tmp_name'])) {
        // Convert image to base64
        $fileType = pathinfo($_FILES['paymentReceipt']['name'], PATHINFO_EXTENSION);
        $base64Image = base64_encode(file_get_contents($_FILES['paymentReceipt']['tmp_name']));

        // Reconnect to MySQL
        if ($conn->connect_errno) {
            $_SESSION['error_message'] = "Koneksi ke database gagal: " . $conn->connect_error;
            header("Location: error.php"); // Redirect to error page or handle accordingly
            exit();
        }

        // Update database with base64 encoded image
        $sql = "UPDATE Pendaftaran SET payment_receipt = ? WHERE registration_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $base64Image, $registration_id);

        if ($stmt->execute()) {
            // Success message
            $_SESSION['success_message'] = "Bukti pembayaran berhasil diupload.";
        } else {
            // Error message
            $_SESSION['error_message'] = "Gagal mengupload bukti pembayaran: " . $conn->error;
        }

        // Close statement
        $stmt->close();
    } else {
        // No file uploaded
        $_SESSION['error_message'] = "Tidak ada file yang diunggah.";
    }
}

$conn->close(); // Close database connection

header("Location: status.php"); // Redirect back to status page
exit();

?>
