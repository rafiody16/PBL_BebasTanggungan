<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['Username'])) {
    // Jika belum login, redirect ke halaman login
    header("Location: ../Login/Login.php");
    exit();
}

// Cek hak akses
if ($_SESSION['Role_ID'] === 6 || $_SESSION['Role_ID'] === 7 || $_SESSION['Role_ID'] === 8) {
    echo "<script>
    alert('Anda tidak memiliki akses ke halaman ini.');
    window.history.back();
    </script>";
}



// Kode halaman admin di sini
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Data Mahasiswa</title>
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
                            <h3>Tabel Mahasiswa</h3>
                            <p class="text-subtitle text-muted">Data mahasiswa.</p>
                            <?php if($role === 1 || $role === 2 || $role === 3 || $role === 4 || $role === 5) { ?>
                                <div>
                                    <a href="FormMahasiswa.php" class="btn btn-success">Tambah Data</a>
                                </div>
                                <br>
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
                                    Lihat Data Mahasiswa
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <section class="section">
                    <div class="row align-items-center mb-3">
                        <div class="col-md-12">
                            <div class="card">
                            <?php 
                                require_once '../Koneksi.php';
                                $db = new Database();
                                $conn = $db->conn;
                            ?>
                            <div class="card-header">
                                <h5 class="card-title">Tabel Mahasiswa</h5>
                                <form action="" method="get" class="form-inline">
                                    <div class="form-group mb-2">
                                        <label for="prodi" class="mr-2">Prodi:</label>
                                        <select name="prodi" id="prodi" class="form-control">
                                            <option value=""></option>
                                            <?php 
                                                if($_SESSION['Role_ID'] === 1 || $_SESSION['Role_ID'] === 2 ) {
                                                    $stmtProdi = sqlsrv_query($conn, "SELECT DISTINCT Prodi FROM Mahasiswa");
                                                    $selectedProdi = isset($_GET['prodi']) ? $_GET['prodi'] : ''; // Ambil nilai prodi yang dipilih
                                                    while ($rowProdi = sqlsrv_fetch_array($stmtProdi, SQLSRV_FETCH_ASSOC)) {
                                                        $selected = ($rowProdi['Prodi'] == $selectedProdi) ? 'selected' : ''; // Cek apakah ini yang dipilih
                                                        echo "<option value='" . htmlspecialchars($rowProdi['Prodi']) . "' $selected>" . htmlspecialchars($rowProdi['Prodi']) . "</option>";
                                                    }     
                                                } else if ($_SESSION['Role_ID'] === 3) {
                                                    $stmtProdi = sqlsrv_query($conn, "SELECT DISTINCT Prodi FROM Mahasiswa");
                                                    $selectedProdi = isset($_GET['prodi']) ? $_GET['prodi'] : 'TI'; // Ambil nilai prodi yang dipilih
                                                    while ($rowProdi = sqlsrv_fetch_array($stmtProdi, SQLSRV_FETCH_ASSOC)) {
                                                        $selected = ($rowProdi['Prodi'] == $selectedProdi) ? 'selected' : ''; // Cek apakah ini yang dipilih
                                                        echo "<option value='" . htmlspecialchars($rowProdi['Prodi']) . "' $selected>" . htmlspecialchars($rowProdi['Prodi']) . "</option>";
                                                    }     
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="tahunAngkatan" class="mr-2">Tahun Angkatan:</label>
                                        <select name="tahunAngkatan" id="tahunAngkatan" class="form-control">
                                            <option value=""></option>
                                            <?php 
                                                // Ambil daftar tahun angkatan dari database
                                                $stmtTahunAngkatan = sqlsrv_query($conn, "SELECT DISTINCT Tahun_Angkatan FROM Mahasiswa");
                                                $selectedTahunAngkatan = isset($_GET['tahunAngkatan']) ? $_GET['tahunAngkatan'] : ''; // Ambil nilai tahun angkatan yang dipilih
                                                while ($rowTahunAngkatan = sqlsrv_fetch_array($stmtTahunAngkatan, SQLSRV_FETCH_ASSOC)) {
                                                    $selected = ($rowTahunAngkatan['Tahun_Angkatan'] == $selectedTahunAngkatan) ? 'selected' : ''; // Cek apakah ini yang dipilih
                                                    echo "<option value='" . htmlspecialchars($rowTahunAngkatan['Tahun_Angkatan']) . "' $selected>" . htmlspecialchars($rowTahunAngkatan['Tahun_Angkatan']) . "</option>";
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
                                                    <th>NIM</th>
                                                    <th>Nama</th>
                                                    <th>Alamat</th>
                                                    <th>Prodi</th>
                                                    <th>Jenis Kelamin</th>
                                                    <th>No. HP</th>
                                                    <th>Tahun Angkatan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                                require_once '../Models/Mahasiswa.php';
                                                $mhs = new Mahasiswa($conn);
                                                $stmt2 = $mhs->getAllMhs();
                                                $no = 1;
                                                while ($row = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)) {
                                                    if ($row) {
                                                        $nim = $row['NIM'];
                                                        echo "<tr>";
                                                            echo "<td>" . htmlspecialchars($no++) . "</td>";
                                                            echo "<td>" . htmlspecialchars($nim) . "</td>";
                                                            echo "<td>" . htmlspecialchars($row['Nama']) . "</td>";
                                                            echo "<td>" . htmlspecialchars($row['Alamat']) . "</td>";
                                                            echo "<td>" . htmlspecialchars($row['Prodi']) . "</td>";
                                                            echo "<td>" . htmlspecialchars($row['JenisKelamin']) . "</td>";
                                                            echo "<td>" . htmlspecialchars($row['NoHp']) . "</td>";
                                                            echo "<td>" . htmlspecialchars($row['Tahun_Angkatan']) . "</td>";
                                                            ?>
                                                            <td>
                                                                <button data-id="<?= $nim ?>" class="btn btn-primary btn-detail">Detail</button>
                                                                <button data-id="<?= $nim ?>" class="btn btn-warning btn-edit">Edit</button>
                                                                <button data-id="<?= $nim ?>" class="btn btn-danger btn-delete">Hapus</button>
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
                                        <a href="TabelMahasiswa.php" class="btn btn-secondary mb-3">Reset Filter</a>
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
                        <!-- <p>2024 &copy; BeTaTI</p> -->
                        <p>2023 &copy; Mazer</p>
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
            $(".btn-detail").click(function() {
                var nim = $(this).data("id");
                $.ajax({
                url: "DetailMahasiswa.php",
                type: "POST",
                data: { NIM: nim, action: "getByNim" },
                    success: function(response) {
                        location.href = "DetailMahasiswa.php?NIM=" + nim;
                    }
                });
            });

            $(".btn-edit").click(function() {
                var nim = $(this).data("id");
                    $.ajax({
                    url: "FormMahasiswa.php",
                    type: "POST",
                    data: { NIM: nim, action: "getByNim" },
                    success: function(response) {
                        location.href = "FormMahasiswa.php?NIM=" + nim;
                    }
                })   
            });

            $(".btn-delete").click(function() {
                var nim = $(this).data("id");
                if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                    $.ajax({
                        url: "../Controllers/UserControllers.php?action=deleteMhs",
                        type: "POST",
                        data: { NIM: nim},
                        success: function(response) {
                            alert("Data mahasiswa dengan NIM " + nim + " berhasil dihapus");
                            location.reload();
                        }
                    });
                }
            });

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