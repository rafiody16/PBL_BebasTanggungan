<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Detail Mahasiswa</title>
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
    <link
      rel="stylesheet"
      crossorigin
      href="assets/compiled/css/iconly.css"
    />
    <link rel="stylesheet" crossorigin href="../assets/compiled/css/app.css">
    <link rel="stylesheet" crossorigin href="../assets/compiled/css/app-dark.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['Username'])) {
    // Jika belum login, redirect ke halaman login
    header("Location: ../Login/Login.php");
    exit();
}

// Cek hak akses
if ($_SESSION['Role_ID'] != 1 || $_SESSION['Role_ID'] != 2 || $_SESSION['Role_ID'] != 3 || $_SESSION['Role_ID'] != 4 || $_SESSION['Role_ID'] != 5) {
    echo "<script>
    alert('Anda tidak memiliki akses ke halaman ini.');
    window.history.back();
    </script>";
}

include('UserProses.php');
include('../Koneksi.php');

getDataMahasiswaByNim();

?>

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
                <section id="basic-vertical-layouts">
                    <div class="row match-height">
                        <div class="col-md-6 col-12">
                            <div class="card" style="width: 1280px; margin-left:30px">
                                <div class="card-header">
                                    <h4 class="card-title">Data Mahasiswa</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form form-vertical">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="NIM">NIM</label>
                                                            <h3><?= isset($nim) ? htmlspecialchars($nim) : '' ?></h3>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="Nama">Nama</label>
                                                            <h3><?= isset($nama) ? htmlspecialchars($nama) : '' ?></h3>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="Username">Username</label>
                                                            <h3><?= isset($username) ? htmlspecialchars($username) : '' ?></h3>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="Email">Email</label>
                                                            <h3><?= isset($email) ? htmlspecialchars($email) : '' ?></h3>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="Alamat">Alamat</label>
                                                            <h3><?= isset($alamat) ? htmlspecialchars($alamat) : '' ?></h3>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="NoHp">No.Hp</label>
                                                            <h3><?= isset($noHp) ? htmlspecialchars($noHp) : '' ?></h3>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="TempatTanggalLahir">Tempat Tanggal Lahir</label>
                                                            <h3><?= isset($Tempat_Lahir) ? htmlspecialchars($Tempat_Lahir) : '' ?> / <?= isset($Tanggal_Lahir) ? htmlspecialchars($Tanggal_Lahir instanceof DateTime ? $Tanggal_Lahir->format('d-m-Y') : $Tanggal_Lahir) : '' ?></h3>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="Prodi">Prodi</label>
                                                            <h3><?= isset($Prodi) ? htmlspecialchars($Prodi) : '' ?></h3>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="Tahun_Angkatan">Tahun Angkatan</label>
                                                            <h3><?= isset($TahunAngkatan) ? htmlspecialchars($TahunAngkatan) : '' ?></h3>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="JenisKelamin">Jenis Kelamin</label>
                                                            <h3><?= isset($jeniskelamin) ? ($jeniskelamin === 'L' ? 'Laki-Laki' : ($jeniskelamin === 'P' ? 'Perempuan' : '')) : '' ?></h3>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 d-flex justify-content-end">
                                                        <div><a href="TabelMahasiswa.php" class="btn btn-light-secondary me-1 mb-1">Kembali</a></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
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
    <script src="../assets/static/js/components/dark.js"></script>
    <script src="../assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/compiled/js/app.js"></script>
</body>
</html>
