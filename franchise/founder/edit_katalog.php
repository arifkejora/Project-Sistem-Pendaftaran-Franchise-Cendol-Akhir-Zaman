<?php
// Pastikan Anda sudah mengatur koneksi ke database sebelumnya
require_once '../db_connection.php'; // Sesuaikan dengan path yang benar

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'founder') {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $catalog_id = $_POST['catalog_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $harga = $_POST['harga'];

    // Update data katalog
    $sql = "UPDATE katalog SET title='$title', description='$description', harga='$harga' WHERE catalog_id='$catalog_id'";

    if ($conn->query($sql) === TRUE) {
        // Periksa apakah file gambar diupload
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $imageTmpName = $_FILES['image']['tmp_name'];
            $imageName = $_FILES['image']['name'];
            $imagePath = '../canaz/uploads/' . $imageName;
            
            // Pindahkan file gambar ke folder uploads
            if (move_uploaded_file($imageTmpName, $imagePath)) {
                // Update nama file gambar di database
                $sql = "UPDATE katalog SET image='$imageName' WHERE catalog_id='$catalog_id'";
                if ($conn->query($sql) !== TRUE) {
                    echo "Error updating image: " . $conn->error;
                }
            } else {
                echo "Error uploading image.";
            }
        }
        header("Location: ../katalog.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>
