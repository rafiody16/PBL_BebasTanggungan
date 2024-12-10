<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['Username'])) {
    // Jika belum login, redirect ke halaman login
    header("Location: ../Login/Login.php");
    exit();
}

// Cek hak akses
if ($_SESSION['Role_ID'] != 1) {
    // Jika bukan admin, redirect atau tampilkan pesan error
    echo "<script>alert('Anda tidak memiliki akses ke halaman ini.'); window.location.href = '../Login/Login.php';</script>";
    exit();
}

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
                                <div class="card-header">
                                    <h5 class="card-title">Tabel User</h5>
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
                                    include('UserProses.php');
                                    $no = 1;
                                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                        if ($row) {
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
                                                    <button data-id="<?= $nip ?>" class="btn btn-warning btn-edit">Edit</button>
                                                    <button data-id="<?= $nip ?>" class="btn btn-danger btn-delete">Hapus</button>
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
            <p>2024 &copy; BeTaTI</p>
        </div>
        <div class="float-end">
            <p>Crafted with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                by <a href="https://github.com/rafiody16/PBL_BebasTanggungan">Kelompok 1</a></p>
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
                url: "UserProses.php",
                type: "POST",
                data: { NIP: nip, action: "delete" },
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
</body>

</html>