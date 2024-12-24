<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['Username'])) {
    // Jika belum login, redirect ke halaman login
    header("Location: ../Login/Login.php");
    exit();
}

// Cek hak akses
if ($_SESSION['Role_ID'] === 6 || $_SESSION['Role_ID'] === 7 || $_SESSION['Role_ID'] === 8 || $_SESSION['Role_ID'] === 5 || $_SESSION['Role_ID'] === 6) {
    echo "<script>
    alert('Anda tidak memiliki akses ke halaman ini.');
    window.history.back();
    </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Tambah Data Mahasiswa</title>
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
                            <h3>Tambah Data Mahasiswa</h3>
                            <p class="text-subtitle text-muted">Tambahkan data mahasiswa</p>
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
                            Tambah Data Mahasiswa
                            </li>
                        </ol>
                    </nav>
                    </div>
                </div>
            </div>
                <section id="basic-vertical-layouts">
                    <div class="row match-height">
                        <div class="col-md-6 col-12">
                            <div class="card" style="width: 1280px; margin-left:5px">
                                <div class="card-header">
                                    <h4 class="card-title">Tambah Data Mahasiswa</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form form-vertical" method="POST">
                                            <?php 
                                                require_once '../Koneksi.php';
                                                require_once '../Models/Mahasiswa.php';
                                                
                                                $db = new Database();
                                                $mhsModel = new Mahasiswa($db->getConnection());
                                                
                                                $nim = isset($_GET['NIM']) ? $_GET['NIM'] : '';
                                                $mhs = null;
                                                
                                                if ($nim) {
                                                    $mhs = $mhsModel->findByNIM($nim);
                                                }
                                            
                                            ?>
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="NIM">NIM</label>
                                                            <input type="text" class="form-control" name="NIM" value="<?= isset($mhs['NIM']) ? htmlspecialchars($mhs['NIM']) : '' ?>" placeholder="Masukkan NIM">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="Nama">Nama</label>
                                                            <input type="text" class="form-control" name="Nama" value="<?= isset($mhs['Nama']) ? htmlspecialchars($mhs['Nama']) : '' ?>" placeholder="Masukkan Nama">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="Username">Username</label>
                                                            <input type="text" class="form-control" name="Username" value="<?= isset($mhs['Username']) ? htmlspecialchars($mhs['Username']) : '' ?>" placeholder="Masukkan Nama">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="Email">Email</label>
                                                            <input type="email" class="form-control" name="Email" value="<?= isset($mhs['Email']) ? htmlspecialchars($mhs['Email']) : '' ?>" placeholder="Masukkan Email">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="Password">Password</label>
                                                            <input type="password" class="form-control" name="Password" placeholder="Masukkan Password">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="Alamat">Alamat</label>
                                                            <textarea class="form-control" name="Alamat" rows="3"><?= isset($mhs['Alamat']) ? htmlspecialchars($mhs['Alamat']) : '' ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="NoHp">No.Hp</label>
                                                            <input type="text" class="form-control" name="NoHp" value="<?= isset($mhs['NoHp']) ? htmlspecialchars($mhs['NoHp']) : '' ?>" placeholder="Masukkan No Hp">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="Tempat_Lahir">Tempat Lahir</label>
                                                            <input type="text" class="form-control" value="<?= isset($mhs['Tempat_Lahir']) ? htmlspecialchars($mhs['Tempat_Lahir']) : '' ?>" name="Tempat_Lahir" placeholder="Masukkan Tempat Lahir"> 
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="Tanggal_Lahir">Tanggal Lahir</label>
                                                            <input type="date" class="form-control flatpickr-always-open" name="Tanggal_Lahir" value="<?= isset($mhs['Tanggal_Lahir']) ? htmlspecialchars($mhs['Tanggal_Lahir'] instanceof DateTime ? $mhs['Tanggal_Lahir']->format('Y-m-d') : (new DateTime($mhs['Tanggal_Lahir']))->format('Y-m-d')) : '' ?>" placeholder="Select date.">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="Prodi">Prodi</label>
                                                            <fieldset class="form-group">
                                                                <select class="form-select" name="Prodi" id="basicSelect">
                                                                    <option>-- Silahkan Pilih Prodi --</option>
                                                                    <option value="TI" <?= (isset($mhs['Prodi']) && $mhs['Prodi'] === 'TI') ? 'selected' : '' ?>>D-IV Teknik Informatika</option>
                                                                    <option value="SIB" <?= (isset($mhs['Prodi']) && $mhs['Prodi'] === 'SIB') ? 'selected' : '' ?>>D-IV Sistem Informasi Bisnis</option>
                                                                    <option value="PPLS" <?= (isset($mhs['Prodi']) && $mhs['Prodi'] === 'PPLS') ? 'selected' : '' ?>>D-II Pengembangan Piranti Lunak Situs</option>
                                                                </select>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="Tahun_Angkatan">Tahun Angkatan</label>
                                                            <input type="text" class="form-control" name="Tahun_Angkatan" value="<?= isset($mhs['Tahun_Angkatan']) ? htmlspecialchars($mhs['Tahun_Angkatan']) : '' ?>" placeholder="Masukkan Tahun Angkatan">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="JenisKelamin">Jenis Kelamin</label>
                                                            <br>
                                                            <input class="form-check-input" type="radio" name="JenisKelamin" id="jenkel1" value="L" required="true" 
                                                                <?= (isset($mhs['JenisKelamin']) && $mhs['JenisKelamin'] === 'L') ? 'checked' : '' ?>> Laki-laki 
                                                            <input class="form-check-input" type="radio" name="JenisKelamin" id="jenkel2" value="P" 
                                                                <?= (isset($mhs['JenisKelamin']) && $mhs['JenisKelamin'] === 'P') ? 'checked' : '' ?>> Perempuan
                                                            <br>
                                                            <br>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 d-flex justify-content-start">
                                                        <button type="submit" class="btn btn-primary me-1 mb-1" 
                                                                name="<?= isset($mhs['NIM']) ? 'updateMahasiswa' : 'simpanMahasiswa' ?>" 
                                                                value="<?= isset($mhs['NIM']) ? 'update' : 'tambah' ?>">
                                                            <?= isset($mhs['NIM']) ? 'Update' : 'Tambah' ?>
                                                        </button>
                                                        <!-- <button type="reset" class="btn btn-light-secondary me-1 mb-1">Kembali</button> -->
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
                        <!-- <p>2024 &copy; BeTaTI</p> -->
                        <p>2023 &copy; Mazer</p>
                    </div>
                    <div class="float-end">
                        <!-- <p>Crafted with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                            by <a href="https://github.com/rafiody16/PBL_BebasTanggungan">Kelompok 1</a></p> -->
                        <p>Crafted with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                        by <a href="https://saugi.me">Saugi</a></p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('form').submit(function(e) {
                e.preventDefault();
            
                var formData = $(this).serialize();
            
                var buttonName = $('button[type="submit"]').attr('name');

                if (buttonName === 'updateMahasiswa') {
                    var url = '../Controllers/UserControllers.php?action=updateMhs';
                } else {
                    var url = '../Controllers/UserControllers.php?action=createMahasiswa';
                }

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        alert(response);
                        window.location.reload(); // Memuat ulang halaman setelah submit berhasil
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                        alert('Terjadi kesalahan: ' + error);
                    }
                });
            });

        });
    </script>
    <script src="../assets/static/js/components/dark.js"></script>
    <script src="../assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/compiled/js/app.js"></script>
</body>
</html>