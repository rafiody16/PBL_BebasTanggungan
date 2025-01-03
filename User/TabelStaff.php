<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['Username'])) {
    // Jika belum login, redirect ke halaman login
    header("Location: ../Login/Login.php");
    exit();
}

// Cek hak akses
if ($_SESSION['Role_ID'] === 3 || $_SESSION['Role_ID'] === 4 || $_SESSION['Role_ID'] === 5 || $_SESSION['Role_ID'] === 6 || $_SESSION['Role_ID'] === 7 || $_SESSION['Role_ID'] === 8) {
    echo "<script>
    alert('Anda tidak memiliki akses ke halaman ini.');
    window.history.back();
    </script>";
}

$role = $_SESSION['Role_ID'];

// Kode halaman admin di sini
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Data Staff</title>
    <link
      rel="shortcut icon"
      href="../assets/img/logoJti.png"
      type="image/x-icon"
    />
    <link
      rel="shortcut icon"
      href="../assets/img/logoJti.png"
      type="image/png"
    />
    <link rel="stylesheet" crossorigin href="../assets/compiled/css/app.css">
    <link rel="stylesheet" crossorigin href="../assets/compiled/css/app-dark.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <script src="../assets/static/js/initTheme.js"></script>
    <div id="app">
    <?php include('../assets/Sidebar2.php'); ?>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            
            <div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>Tabel Staff</h3>
                            <p class="text-subtitle text-muted">Data staff.</p>
                            <?php if($role === 1) { ?>
                            <div>
                                <a href="FormStaff.php" class="btn btn-success">Tambah Data</a>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav
                            aria-label="breadcrumb"
                            class="breadcrumb-header float-start float-lg-end"
                            >
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                    <a href="../index.php">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                    Lihat Data Staff
                                    </li>
                            </ol>
                            </nav>
                            </div>
                    </div>
                    </div>
                </div>
                <section class="section">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                            <?php 
                                require_once '../Koneksi.php';
                                $db = new Database();
                                $conn = $db->getConnection();
                            ?>
                            <div class="card-header">
                                <h5 class="card-title">Tabel Staff</h5>
                                <form action="" method="get" class="form-inline">
                                    <div class="form-group mb-2">
                                        <label for="role" class="mr-2">Jabatan:</label>
                                        <select name="role" id="role" class="form-control">
                                            <option value=""></option>
                                            <?php 
                                                // Ambil daftar role dari database
                                                $stmtRole = sqlsrv_query($conn, "SELECT DISTINCT Nama_Role FROM Role");
                                                $selectedRole = isset($_GET['role']) ? $_GET['role'] : ''; // Ambil nilai role yang dipilih
                                                while ($rowRole = sqlsrv_fetch_array($stmtRole, SQLSRV_FETCH_ASSOC)) {
                                                    $selected = ($rowRole['Nama_Role'] == $selectedRole) ? 'selected' : ''; // Cek apakah ini yang dipilih
                                                    echo "<option value='" . htmlspecialchars($rowRole['Nama_Role']) . "' $selected>" . htmlspecialchars($rowRole['Nama_Role']) . "</option>";
                                                } 
                                            ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary mb-2">Filter</button>
                                </form>
                            </div>
                            <div class="card-body">
                                    <div class="table-responsive">
                            <table class="table table-lg">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>NIP</th>
                                        <th>Nama</th>
                                        <th>Jabatan</th>
                                        <th>Email</th>
                                        <th>No. HP</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                    require_once '../Models/Staff.php';
                                    $staff = new Staff($conn);
                                    $stmt = $staff->getAllStaff();
                                    $no = 1;
                                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                        if ($row) {
                                            $roleBtn = $_SESSION['Role_ID'];
                                            $nip = $row['NIP'];
                                            echo "<tr>";
                                                echo "<td>" . htmlspecialchars($no++) . "</td>";
                                                echo "<td>" . htmlspecialchars($nip) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['Nama']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['Nama_Role']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['Email']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['NoHp']) . "</td>";
                                                ?>
                                                <td>
                                                    <button data-id="<?= $nip ?>" class="btn btn-primary btn-detail">Detail</button>
                                                    <?php if ($roleBtn === 1) { ?>
                                                        <button data-id="<?= $nip ?>" class="btn btn-warning btn-edit">Edit</button>
                                                        <button data-id="<?= $nip ?>" class="btn btn-danger btn-delete">Hapus</button>
                                                    <?php } ?>  
                                                </td>
                                                <?php
                                            echo "</tr>";
                                        } else {
                                            echo "Belum ada data";
                                        }
                                    }
                                ?>
                                </tbody>
                            </table>
                            <a href="TabelStaff.php" class="btn btn-secondary mb-3">Reset Filter</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
            </div>

            <footer>
                <div class="footer clearfix mb-0 text-muted">
        <div class="float-start">
            <p>2023 &copy; Mazer</p>
            <!-- <p>2024 &copy; BeTaTI</p> -->
        </div>
        <div class="float-end">
            <p>Crafted with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
            by <a href="https://saugi.me">Saugi</a></p>
            <!-- <p>Crafted with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                by <a href="https://github.com/rafiody16/PBL_BebasTanggungan">Kelompok 1</a></p> -->
        </div>
                </div>
            </footer>
        </div>
    </div>
    <script>
        $(document).ready(function() {
    // Lihat detail
    $(".btn-detail").click(function() {
        var nip = $(this).data("id");
        $.ajax({
            url: "DetailStaff.php",
            type: "POST",
            data: { NIP: nip, action: "read" },
            success: function(response) {
                location.href = "DetailStaff.php?NIP=" + nip;
            }
        });
    });

    $(".btn-edit").click(function() {
        var nip = $(this).data("id");
        $.ajax({
            url: "FormStaff.php",
            type: "POST",
            data: { NIP: nip, action: "edit" },
            success: function(response) {
                location.href = "FormStaff.php?NIP=" + nip;
            }
        })
    });

    // Hapus data
    $(".btn-delete").click(function() {
        var nip = $(this).data("id");
        if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
            $.ajax({
                url: "../Controllers/UserControllers.php?action=deleteStaff",
                type: "POST",
                data: { NIP: nip},
                success: function(response) {
                    alert("Data staff dengan NIP " + nip + " berhasil dihapus");
                    location.reload();
                }
            });
        }
    });

    // Tutup modal
    $("#modalClose").click(function() {
        $("#modal").hide();
    });
});

    </script>
    <script src="../assets/static/js/components/dark.js"></script>
    <script src="../assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/compiled/js/app.js"></script>
    <script src="../assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
    <script src="../assets/static/js/pages/simple-datatables.js"></script>
</body>

</html>