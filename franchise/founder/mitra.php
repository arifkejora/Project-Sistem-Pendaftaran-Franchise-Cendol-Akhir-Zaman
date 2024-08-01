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

$sql = "SELECT mitra_id, name, address, phone_number, status_mitra FROM mitra";
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
        <title>Dashboard Founder</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand ps-3" href="index.php">Cendol Akhir Zaman</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
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
                        <h1 class="mt-4">Data Mitra</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Founder/Mitra</li>
                        </ol>
                        <div class="container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Nomor HP</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                        <tr>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo $row['address']; ?></td>
                                            <td><?php echo $row['phone_number']; ?></td>
                                            <td><?php echo $row['status_mitra']; ?></td>
                                            <td>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['mitra_id']; ?>">
                                                Edit
                                            </button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <?php
        // Di dalam loop while untuk menampilkan setiap modal edit
        $sql = "SELECT * FROM mitra";
        $result = $conn->query($sql);
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <!-- Edit Modal -->
        <div class="modal fade" id="editModal<?php echo $row['mitra_id']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?php echo $row['mitra_id']; ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel<?php echo $row['mitra_id']; ?>">Edit Mitra</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form edit mitra -->
                        <form action="edit_mitra.php" method="POST">
                            <input type="hidden" name="mitra_id" value="<?php echo $row['mitra_id']; ?>">
                            <div class="mb-3">
                                <label for="edit_name<?php echo $row['mitra_id']; ?>" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="edit_name<?php echo $row['mitra_id']; ?>" name="edit_name" value="<?php echo $row['name']; ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="edit_status<?php echo $row['mitra_id']; ?>" class="form-label">Status</label>
                                <select class="form-select" id="edit_status<?php echo $row['mitra_id']; ?>" name="edit_status" required>
                                    <option value="aktif" <?php if ($row['status_mitra'] == 'aktif') echo 'selected'; ?>>Aktif</option>
                                    <option value="nonaktif" <?php if ($row['status_mitra'] == 'nonaktif') echo 'selected'; ?>>Nonaktif</option>
                                </select>
                            </div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php } ?>

        <?php
        // Di dalam loop while untuk menampilkan setiap modal delete
        $result = $conn->query($sql);
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <!-- Delete Modal -->
            <div class="modal fade" id="deleteModal<?php echo $row['catalog_id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?php echo $row['catalog_id']; ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel<?php echo $row['catalog_id']; ?>">Delete Katalog</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this catalog item?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <a href="delete_katalog.php?catalog_id=<?php echo $row['catalog_id']; ?>" class="btn btn-danger">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>



        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
