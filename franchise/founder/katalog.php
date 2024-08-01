<?php
require_once '../db_connection.php'; // Sesuaikan dengan path yang benar
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'founder') {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../login.php"); // Mengarahkan ke root aplikasi
    exit();
}

// Handle delete request
if (isset($_POST['action']) && $_POST['action'] == 'delete' && isset($_POST['catalog_id'])) {
    $catalog_id = $_POST['catalog_id'];
    $stmt = $conn->prepare("DELETE FROM katalog WHERE catalog_id = ?");
    $stmt->bind_param("i", $catalog_id);
    if ($stmt->execute()) {
        echo "<script>alert('Katalog berhasil dihapus!'); window.location.href = 'katalog.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus katalog.'); window.location.href = 'katalog.php';</script>";
    }
    $stmt->close();
}

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
                    <h1 class="mt-4">Katalog</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Founder/Katalog</li>
                    </ol>
                    <div class="container">
                        <button type="button" class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#addModal">
                            Tambah Katalog Baru
                        </button>
                        <br></br>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Gambar</th>
                                    <th>Title</th>
                                    <th>Deskripsi</th>
                                    <th>Harga</th>

                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result)) { 
                                    $imagePath = '' . htmlspecialchars($row['gambar']);
                                ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['catalog_id']); ?></td>
                                        <td>
                                            <img src="<?php echo $imagePath; ?>" alt="Image" style="width: 100px; height: auto;">
                                        </td>
                                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                                        <td><?php echo htmlspecialchars($row['harga']); ?></td>

                                        <td>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?php echo htmlspecialchars($row['catalog_id']); ?>">
                                                Edit
                                            </button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo htmlspecialchars($row['catalog_id']); ?>">
                                                Delete
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
    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Katalog Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form tambah katalog -->
                    <form action="insert_katalog.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="number" class="form-control" id="harga" name="harga" required>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Upload Gambar</label>
                            <input type="file" class="form-control" id="image" name="image" required>
                        </div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
    // Di dalam loop while untuk menampilkan setiap modal edit
    $result = $conn->query($sql); // Mengambil kembali data dari database
    while ($row = mysqli_fetch_assoc($result)) {
    ?>
        <!-- Edit Modal -->
        <div class="modal fade" id="editModal<?php echo htmlspecialchars($row['catalog_id']); ?>" tabindex="-1" aria-labelledby="editModalLabel<?php echo htmlspecialchars($row['catalog_id']); ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel<?php echo htmlspecialchars($row['catalog_id']); ?>">Edit Katalog</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form edit katalog -->
                        <form action="edit_katalog.php" method="POST">
                            <input type="hidden" name="catalog_id" value="<?php echo htmlspecialchars($row['catalog_id']); ?>">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required><?php echo htmlspecialchars($row['description']); ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="harga" class="form-label">Harga</label>
                                <input type="number" class="form-control" id="harga" name="harga" value="<?php echo htmlspecialchars($row['harga']); ?>" required>
                            </div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <!-- Delete Modal -->
<div class="modal fade" id="deleteModal<?php echo htmlspecialchars($row['catalog_id']); ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?php echo htmlspecialchars($row['catalog_id']); ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel<?php echo htmlspecialchars($row['catalog_id']); ?>">Hapus Katalog</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus katalog ini?</p>
            </div>
            <div class="modal-footer">
                <form action="katalog.php" method="POST">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="catalog_id" value="<?php echo htmlspecialchars($row['catalog_id']); ?>">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <?php
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>
