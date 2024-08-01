<?php
require_once '../db_connection.php'; // Sesuaikan dengan path yang benar
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'mitra') {
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../../index.html");    
    exit();
}


$mitra_id = $_SESSION['user_id'];
$sql_mitra = "SELECT * FROM mitra WHERE mitra_id = ?";
$stmt_mitra = $conn->prepare($sql_mitra);
$stmt_mitra->bind_param('i', $mitra_id);
$stmt_mitra->execute();
$result_mitra = $stmt_mitra->get_result();
$mitra_data = $result_mitra->fetch_assoc();

$sql = "SELECT * FROM katalog";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard Mitra</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">Kedai Akhir Zaman</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a href="?logout=true" class="dropdown-item">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <a class="nav-link" href="profil.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Lengkapi Profil
                            </a>
                            <a class="nav-link" href="status.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Status
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                <div class="container-fluid px-4">
                            <h1 class="mt-4">Pendaftaran</h1>
                            <ol class="breadcrumb mb-4">
                                <li class="breadcrumb-item active">Mitra/Pendaftaran</li>
                            </ol>
                            <div class="row row-cols-1 row-cols-md-3 g-4">
                                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <div class="col">
                                        <div class="card h-100">
                                            <img src="<?php echo htmlspecialchars($row['gambar']); ?>" class="card-img-top" alt="Image" style="height: 200px; object-fit: cover;">
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                                                <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p>
                                                <p class="card-text" style="font-size: 1.5rem; font-weight: bold;">
                                                    Rp. <?php echo number_format($row['harga'], 0, ',', '.'); ?>
                                                </p>
                                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#daftarModal<?php echo htmlspecialchars($row['catalog_id']); ?>">Daftar</button>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Modal -->
                                    <div class="modal fade" id="daftarModal<?php echo htmlspecialchars($row['catalog_id']); ?>" tabindex="-1" aria-labelledby="daftarModalLabel<?php echo htmlspecialchars($row['catalog_id']); ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="daftarModalLabel<?php echo htmlspecialchars($row['catalog_id']); ?>">Formulir Pendaftaran</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="formDaftar<?php echo htmlspecialchars($row['catalog_id']); ?>" method="POST" action="submit_pendaftaran.php" enctype="multipart/form-data">
                                                <input type="hidden" name="catalog_id" value="<?php echo htmlspecialchars($row['catalog_id']); ?>">
                                                <input type="hidden" name="mitra_id" value="<?php echo htmlspecialchars($mitra_id); ?>">
                                                
                                                <h5 class="text-center font-weight-bold">Data Diri</h5>
                                                <div class="mb-3">
                                                    <label for="nama" class="form-label">Nama</label>
                                                    <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($mitra_data['name']); ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="alamat" class="form-label">Alamat</label>
                                                    <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo htmlspecialchars($mitra_data['address']); ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                                                    <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon" value="<?php echo htmlspecialchars($mitra_data['phone_number']); ?>" required>
                                                </div>
                                                
                                                <h5 class="text-center font-weight-bold">Identitas</h5>
                                                <div class="mb-3">
                                                    <label for="ktp_file" class="form-label">Unggah KTP</label>
                                                    <input type="file" class="form-control" id="ktp_file" name="ktp_file" required>
                                                </div>
                                                
                                                <h5 class="text-center font-weight-bold">Masukkan Rencana Lokasi</h5>
                                                <div class="mb-3">
                                                    <label for="longitude" class="form-label">Longitude</label>
                                                    <input type="text" class="form-control" id="longitude" name="longitude" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="latitude" class="form-label">Latitude</label>
                                                    <input type="text" class="form-control" id="latitude" name="latitude" required>
                                                </div>

                                                <h5 class="text-center font-weight-bold">Masukkan Bukti Pembayaran</h5>
                                                <div class="mb-3">
                                                    <label for="nama_rekening" class="form-label">Nama Rekening Bank</label>
                                                    <input type="text" class="form-control" id="nama_rekening" name="nama_rekening" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nomor_rekening" class="form-label">Nomor Rekening Bank</label>
                                                    <input type="text" class="form-control" id="nomor_rekening" name="nomor_rekening" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nama_pemilik" class="form-label">Nama Pemilik Bank</label>
                                                    <input type="text" class="form-control" id="nama_pemilik" name="nama_pemilik" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nominal" class="form-label">Nominal</label>
                                                    <input type="text" class="form-control" id="nominal" name="nominal" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="payment_receipt" class="form-label">Unggah Bukti Transfer</label>
                                                    <input type="file" class="form-control" id="payment_receipt" name="payment_receipt" required>
                                                </div>

                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <?php } ?>
                            </div>
                        </div>
                </main>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
