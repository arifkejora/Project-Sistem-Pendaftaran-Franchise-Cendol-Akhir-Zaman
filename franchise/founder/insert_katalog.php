<?php
require_once '../db_connection.php'; // Sesuaikan dengan path yang benar

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'founder') {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $title = $_POST['title'];
    $description = $_POST['description'];
    $harga = $_POST['harga'];
    $founder_id = $_SESSION['user_id']; // Ambil founder_id dari session

    // Handle file upload
    $target_dir = "../../uploads/"; // Directory where the file will be uploaded
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Lakukan sanitasi data jika diperlukan

            // Query untuk insert data ke tabel katalog dengan founder_id dan image path
            $sql = "INSERT INTO katalog (title, description, gambar, harga, founder_id) VALUES ('$title', '$description', '$target_file', '$harga', '$founder_id')";

            if ($conn->query($sql) === TRUE) {
                // Jika insert berhasil, arahkan kembali ke halaman katalog
                header("Location: katalog.php");
                exit();
            } else {
                // Jika ada error dalam proses insert, Anda bisa menangani sesuai kebutuhan
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

$conn->close();
?>
