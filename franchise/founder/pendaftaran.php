<?php
require_once '../db_connection.php'; // Sesuaikan dengan path yang benar
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'founder') {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: /franchise/login.php"); // Mengarahkan ke root aplikasi
    exit();
}

$query = "SELECT p.*, m.name AS nama_mitra, m.address, m.phone_number, k.title, k.harga
          FROM pendaftaran p
          INNER JOIN mitra m ON p.mitra_id = m.mitra_id
          JOIN katalog k ON p.catalog_id = k.catalog_id
          WHERE p.status = 'pending'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard Founder</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">Cendol Akhir Zaman</a>
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
                            <div class="sb-sidenav-menu-heading">Interface</div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Data Master
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="katalog.php">Katalog</a>
                                    <a class="nav-link" href="mitra.php">Mitra</a>
                                </nav>
                            </div>
                            
                            <div class="sb-sidenav-menu-heading">Approval</div>
                            <a class="nav-link" href="pendaftaran.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Approval Pendaftaran
                            </a>
                            <a class="nav-link" href="dokumen.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Generate Dokumen
                            </a>
                        </div>
                    </div>

                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Approval Pendaftaran</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Approval Pendaftaran</li>
                        </ol>
                        
                        <div class="row">

                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title text-center font-weight-bold">Data Diri</h5>
                                        <p>Nama: <?= $row['nama_mitra'] ?></p>
                                        <p>No Telp: <?= $row['phone_number'] ?></p>
                                        <p>Alamat: <?= $row['address'] ?></p>
                                        <p>KTP:<img src="data:image/jpeg;base64,<?php echo $row['ktp_file']; ?>" alt="KTP" style="width:100px;height:100px;"/>
                                        </p>
                                        <p>Bukti Transfer:<img src="data:image/jpeg;base64,<?php echo $row['payment_receipt']; ?>" alt="BUKTI" style="width:100px;height:100px;"/></p>

                                        <h5 class="card-title text-center font-weight-bold">Mitra</h5>
                                        <p>Katalog: <?= $row['title'] ?></p>
                                        <p>Harga: <?= $row['harga'] ?></p>

                                        <a href="approve.php?id=<?= $row['registration_id'] ?>&status=approved" class="btn btn-success">Setujui</a>
                                        <a href="approve.php?id=<?= $row['registration_id'] ?>&status=rejected" class="btn btn-danger">Tidak Setujui</a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>

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
