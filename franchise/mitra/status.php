<?php
require_once '../db_connection.php'; // Sesuaikan dengan path yang benar
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'mitra') {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: /franchise/login.php"); // Mengarahkan ke root aplikasi
    exit();
}

$mitra_id = $_SESSION['user_id']; // Mengambil mitra_id dari sesi pengguna

// Query untuk mendapatkan data dari tabel Mitra dan Pendaftaran
$sql = "SELECT m.name, m.address, m.phone_number, p.ktp_file, p.registration_id, k.title, k.harga, p.status, p.payment_receipt 
        FROM Mitra m 
        JOIN Pendaftaran p ON m.mitra_id = p.mitra_id
        JOIN katalog k ON p.catalog_id = k.catalog_id 
        WHERE m.mitra_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $mitra_id);
$stmt->execute();
$result = $stmt->get_result();

function getStatusBadgeClass($status) {
    switch ($status) {
        case 'pending':
            return 'bg-warning text-dark'; // Warna kuning untuk status pending
        case 'approved':
            return 'bg-success'; // Warna hijau untuk status approved
        case 'rejected':
            return 'bg-danger'; // Warna merah untuk status rejected
        default:
            return 'bg-secondary'; // Warna default jika status tidak dikenali
    }
}

function getStatusText($status) {
    switch ($status) {
        case 'pending':
            return 'Sedang Di Validasi';
        case 'approved':
            return 'Di Setujui';
        case 'rejected':
            return 'Di Tolak';
        default:
            return 'Status Tidak Dikenali';
    }
}
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
                        <h1 class="mt-4">Status</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Mitra/Status</li>
                        </ol>
                        
                        <div class="row row-cols-1 row-cols-md-3 g-4">
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <div class="col">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">Nama: <?php echo htmlspecialchars($row['name']); ?></h5>
                <p class="card-text">Alamat: <?php echo htmlspecialchars($row['address']); ?></p>
                <p class="card-text">Nomor HP: <?php echo htmlspecialchars($row['phone_number']); ?></p>
                <p class="card-text">Katalog: <?php echo htmlspecialchars($row['title']); ?></p>
                <p class="card-text">Harga: Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></p>
                <p class="card-text">Foto KTP: 
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ktpModal<?php echo $row['registration_id']; ?>">Lihat KTP</button>
                </p>
                <p class="card-text">Bukti Pembayaran: 
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bayarModal<?php echo $row['registration_id']; ?>">Lihat Bukti Bayar</button>
                </p>

                <!-- Menampilkan status dengan badge -->
                <h2 class="card-text text-center mt-2">
                    <span class="badge <?php echo getStatusBadgeClass($row['status']); ?>">
                        <?php echo getStatusText($row['status']); ?>
                    </span>
                </h2>
            </div>
        </div>
    </div>
    <!-- KTP Modal -->
    <div class="modal fade" id="ktpModal<?php echo $row['registration_id']; ?>" tabindex="-1" aria-labelledby="ktpModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ktpModalLabel">KTP</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="data:image/jpeg;base64,<?php echo $row['ktp_file']; ?>" alt="KTP Image" class="img-fluid">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="bayarModal<?php echo $row['registration_id']; ?>" tabindex="-1" aria-labelledby="bayarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bayarModalLabel">KTP</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="data:image/jpeg;base64,<?php echo $row['payment_receipt']; ?>" alt="Bayar Image" class="img-fluid">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
        <script>
            $(document).ready(function() {
    // jQuery code that depends on $ can go here
    // Example:
    $('#myModal').modal('show');
});
jQuery(document).ready(function($) {
    // Use $ inside this function now safely
    // Example:
    $('#myModal').modal('show');
});

        </script>
    </body>
</html>
