<?php
require_once '../db_connection.php'; // Sesuaikan dengan path yang benar
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'mitra') {
    header("Location: ../index.php");
    exit();
}

$user_id = $_POST['user_id'];
$name = $_POST['name'];
$address = $_POST['address'];
$phone_number = $_POST['phone_number'];

// Update query
$sql = "INSERT INTO mitra (user_id, name, address, phone_number, status_mitra) VALUES (?, ?, ?, ?, 'Pending') ON DUPLICATE KEY UPDATE name = VALUES(name), address = VALUES(address), phone_number = VALUES(phone_number), status_mitra = VALUES(status_mitra), updated_at = CURRENT_TIMESTAMP";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isss", $user_id, $name, $address, $phone_number);

if ($stmt->execute()) {
    header("Location: profil.php?success=1");
} else {
    header("Location: profil.php?error=1");
}

exit();
?>
