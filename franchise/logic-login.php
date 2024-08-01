<?php
session_start();
include 'db_connection.php'; // File untuk menghubungkan ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Hash password menggunakan MD5

    // Query untuk memeriksa pengguna
    $sql = "SELECT * FROM Users WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['role'] = $row['role'];

        // Redirect berdasarkan role
        if ($row['role'] == 'founder') {
            header("Location: founder/index.php");
        } else {
            header("Location: mitra/index.php");
        }
    } else {
        echo "Email atau password salah.";
    }
}
?>
