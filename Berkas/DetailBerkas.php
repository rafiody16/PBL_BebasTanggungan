<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['Username'])) {
    // Jika belum login, redirect ke halaman login
    header("Location: ../Login/Login.php");
    exit();
}

// Cek hak akses
if ($_SESSION['Role_ID'] != 8) {
    // Jika bukan admin, redirect atau tampilkan pesan error
    echo "<script>alert('Anda tidak memiliki akses ke halaman ini.'); window.location.href = '../Login/Login.php';</script>";
    exit();
}

$NIM = $_SESSION['NIM'];

// include('ProsesBerkas.php');
// GetAllBerkas();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Berkas - BeTaTI</title>
    
    <link rel="shortcut icon" href="../assets/img/logoJti.png" type="image/x-icon">
    <link rel="shortcut icon" href="../assets/img/logoJti.png" type="image/png">
    
    <link rel="stylesheet" href="../assets/extensions/filepond/filepond.css">
    <link rel="stylesheet" href="../assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.css">
    <link rel="stylesheet" href="../assets/extensions/toastify-js/src/toastify.css">

    <link rel="stylesheet" crossorigin href="../assets/compiled/css/app.css">
    <link rel="stylesheet" crossorigin href="../assets/compiled/css/app-dark.css">


  <style>

</style>
</head>

<body>
    <script src="../assets/static/js/initTheme.js"></script>
    <div id="app">
    <?php include('../assets/Sidebar2.php'); ?>
        </div>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-9 order-md-1 order-last">
                <h3>Berkas Bebas Tanggungan</h3>
                <br>
            </div>
            <div class="col-12 col-md-3 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../User/mahasiswa/dashboardMHS.php">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Berkas Bebas Tanggungan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="row">
        <form>
        <?php 
        require_once '../Koneksi.php';
        require_once '../Models/Pengumpulan.php';
        require_once '../Models/Administrasi.php';
        require_once '../Models/TugasAkhir.php';
        $db = new Database();
        $conn = $db->getConnection();

        $pgModel = new Pengumpulan($conn);
        $taModel = new TugasAkhir($conn);
        $admModel = new Administrasi($conn);

        $nim = isset($_GET['NIM']) ? $_GET['NIM'] : '';
        $pg = null;
        $ta = null;
        $adm = null;
        
        if ($nim) {
            $pg = $pgModel->getByNim($nim);
            $ta = $taModel->getByNimTA($nim);
            $adm = $admModel->getByNimAdm($nim);
        }
        
        ?>
        <div class="col-12 col-md-12">
        <div class="card">
                <div class="card-body">
                        <div class="card-header">
                            <h4 class="card-title">Status Unggah Berkas</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form form-vertical">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="table-responsive">
                                                <table class="table table-bordered mb-0" style="border: 1px solid black;">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>SUB BAGIAN</th>
                                                            <th>TANGGAL UPLOAD</th>
                                                            <th>TANGGAL VERIFIKASI</th>
                                                            <th>STATUS</th>
                                                            <th>KETERANGAN</th>
                                                            <th>AKSI</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-bold-500">1</td>
                                                            <td class="text-bold-500">Tugas Akhir</td>
                                                            <td class="text-bold-500"><?= isset($ta['Tanggal_Upload']) ? htmlspecialchars($ta['Tanggal_Upload'] instanceof DateTime ? $ta['Tanggal_Upload']->format('d-m-Y') : $ta['Tanggal_Upload']) : '' ?></td>
                                                            <td class="text-bold-500"><?= isset($ta['Tanggal_Verifikasi']) ? htmlspecialchars($ta['Tanggal_Verifikasi'] instanceof DateTime ? $ta['Tanggal_Verifikasi']->format('d-m-Y') : $ta['Tanggal_Verifikasi']) : 'Belum Terverifikasi' ?></td>
                                                            <td class="text-bold-500">
                                                            <?php
                                                                if ($ta['Status_Verifikasi'] === 'Menunggu') {
                                                                ?>
                                                                    <span class="badge bg-warning"><?= htmlspecialchars($ta['Status_Verifikasi']) ?></span>
                                                                <?php 
                                                                } else if ($ta['Status_Verifikasi'] === 'Terverifikasi') {
                                                                ?>
                                                                    <span class="badge bg-success"><?= htmlspecialchars($ta['Status_Verifikasi']) ?></span>
                                                                <?php
                                                                } else if ($ta['Status_Verifikasi'] === 'Ditolak') {
                                                                ?>
                                                                    <span class="badge bg-danger"><?= htmlspecialchars($ta['Status_Verifikasi']) ?></span>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <span class="badge bg-secondary">Status Tidak Diketahui</span>
                                                                <?php
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="text-bold-500"><?= htmlspecialchars($ta['Keterangan']) ?></td>
                                                            <td>
                                                                <?php
                                                                    if ($ta['Status_Verifikasi'] === 'Menunggu') {
                                                                ?>
                                                                    <button class="btn btn-warning"><a href="EditTA.php?NIM=<?= $NIM ?>" style="color: black; text-decoration: none;">Edit</a></button>
                                                                <?php 
                                                                    } else if ($ta['Status_Verifikasi'] === 'Terverifikasi') {
                                                                ?>
                                                                    <h5 style="text-align:center;">&#10004;</h5>
                                                                <?php
                                                                    } else if ($ta['Status_Verifikasi'] === 'Ditolak') {
                                                                ?>
                                                                    <button class="btn btn-warning"><a href="EditTA.php?NIM=<?= $NIM ?>" style="color: black; text-decoration: none;">Edit</a></button>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-bold-500">2</td>
                                                            <td class="text-bold-500">Administrasi Program Studi</td>
                                                            <td class="text-bold-500"><?= isset($adm['Tanggal_Upload']) ? htmlspecialchars($adm['Tanggal_Upload'] instanceof DateTime ? $adm['Tanggal_Upload']->format('d-m-Y') : $adm['Tanggal_Upload']) : '' ?></td>
                                                            <td class="text-bold-500"><?= isset($adm['Tanggal_Verifikasi']) ? htmlspecialchars($adm['Tanggal_Verifikasi'] instanceof DateTime ? $adm['Tanggal_Verifikasi']->format('d-m-Y') : $adm['Tanggal_Verifikasi']) : 'Belum Terverifikasi' ?></td>
                                                            <td class="text-bold-500">
                                                                <?php
                                                                    if ($adm['Status_Verifikasi'] === 'Menunggu') {
                                                                ?>
                                                                    <span class="badge bg-warning"><?= htmlspecialchars($adm['Status_Verifikasi']) ?></span>
                                                                <?php 
                                                                    } else if ($adm['Status_Verifikasi']  === 'Terverifikasi') {
                                                                ?>
                                                                    <span class="badge bg-success"><?= htmlspecialchars($adm['Status_Verifikasi']) ?></span>
                                                                <?php
                                                                    } else if ($adm['Status_Verifikasi']  === 'Ditolak') {
                                                                ?>
                                                                    <span class="badge bg-danger"><?= htmlspecialchars($adm['Status_Verifikasi'] ) ?></span>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </td>
                                                            <td class="text-bold-500"><?= htmlspecialchars($adm['Keterangan'] ) ?></td>
                                                            <td>
                                                                <?php
                                                                    if ($adm['Status_Verifikasi']  === 'Menunggu') {
                                                                ?>
                                                                    <button class="btn btn-warning"><a href="EditAdministrasi.php?NIM=<?= $NIM ?>" style="color: black; text-decoration: none;">Edit</a></button>
                                                                <?php 
                                                                    } else if ($adm['Status_Verifikasi']  === 'Terverifikasi') {
                                                                ?>
                                                                    <h5 style="text-align:center;">&#10004;</h5>
                                                                <?php
                                                                    } else if ($adm['Status_Verifikasi']  === 'Ditolak') {
                                                                ?>
                                                                    <button class="btn btn-warning"><a href="EditAdministrasi.php?NIM=<?= $NIM ?>" style="color: black; text-decoration: none;">Edit</a></button>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-bold-500">3</td>
                                                            <td class="text-bold-500">Verifikasi Berkas </td>
                                                            <td class="text-bold-500 text-center align-middle"  colspan="2">
                                                                <?php
                                                                    if ($pg['Status_Pengumpulan'] === 'Menunggu') {
                                                                ?>
                                                                    <span class="badge bg-warning"><?= htmlspecialchars($pg['Status_Pengumpulan']) ?></span>
                                                                <?php 
                                                                    } else if ($pg['Status_Pengumpulan']=== 'Terverifikasi') {
                                                                ?>
                                                                    <span class="badge bg-success"><?= htmlspecialchars($pg['Status_Pengumpulan']) ?></span>
                                                                <?php
                                                                    } else if ($pg['Status_Pengumpulan'] === 'Ditolak') {
                                                                ?>
                                                                    <span class="badge bg-danger"><?= htmlspecialchars($pg['Status_Pengumpulan']) ?></span>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </td>
                                                            <td colspan="3" class="text-bold-500"><?= htmlspecialchars($pg['Keterangan']) ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <br>
                                                <?php if($pg['Status_Pengumpulan'] === 'Terverifikasi') {?>
                                                    <div style="display: flex; justify-content: center; margin-top: 20px;">
                                                        <a href="GeneratePdf.php?NIM=<?= $NIM ?>" class="btn btn-success">
                                                            <i class="bi bi-printer">&nbsp;</i>Cetak Bebas Tanggungan
                                                        </a>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Laporan Skripsi</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <p class="card-text">Catatan: Upload dalam bentuk ZIP / RAR (Maksimal 100 MB)</p>
                            <!-- Basic file uploader -->
                            <div class="form-group position-relative has-icon-left">
                            <div class="text-bold-500"> <a href="<?= htmlspecialchars('../Uploads/' . basename($pg['Laporan_Skripsi'])) ?>" target="_blank"><?= htmlspecialchars($pg['Laporan_Skripsi']) ?></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Laporan Magang</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <p class="card-text">Catatan: Upload dalam bentuk ZIP / RAR (Maksimal 100 MB)</p>
                            <!-- Basic file uploader -->
                            <div class="form-group position-relative has-icon-left">
                                <div class="text-bold-500"> <a href="<?= htmlspecialchars('../Uploads/' . basename($pg['Laporan_Magang'])) ?>" target="_blank"><?= htmlspecialchars($pg['Laporan_Magang']) ?></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Bebas Kompen</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <p class="card-text">Catatan: Upload dalam bentuk ZIP / RAR (Maksimal 100 MB)</p>
                            <!-- Basic file uploader -->
                            <div class="form-group position-relative has-icon-left">
                                <div class="text-bold-500"> <a href="<?= htmlspecialchars('../Uploads/' . basename($pg['Bebas_Kompensasi'])) ?>" target="_blank"><?= htmlspecialchars($pg['Bebas_Kompensasi']) ?></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Scan Toeic</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <p class="card-text">Catatan: Upload dalam bentuk ZIP / RAR (Maksimal 100 MB)</p>
                            <!-- Basic file uploader -->
                            <div class="form-group position-relative has-icon-left">
                                <div class="text-bold-500"> <a href="<?= htmlspecialchars('../Uploads/' . basename($pg['Scan_Toeic'])) ?>" target="_blank"><?= htmlspecialchars($pg['Scan_Toeic']) ?></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Laporan Tugas Akhir</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="desc">
                                Laporan terdiri dari:
                                <ul>
                                    <li>Cover</li>
                                    <li>Daftar Isi-Gambar-Tabel</li>
                                    <li>Kata Pengantar</li>
                                    <li>Abstrak Indo-Inggris</li>
                                    <li>Bab 1 sampai Penutup</li>
                                    <li>Daftar Pustaka</li>
                                    <li>Lampiran (bila ada)</li>
                                </ul>
                            </div>
                            <p class="card-text">Catatan: Upload dalam bentuk PDF dan sudah bertanda tangan (Maksimal 10 MB)</p>
                            <div class="form-group position-relative has-icon-left">
                                <div class="text-bold-500"> <a href="<?= htmlspecialchars('../Uploads/' . basename($pg['Laporan_TA'])) ?>" target="_blank"><?= htmlspecialchars($pg['Laporan_TA']) ?></a></div>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Program / Aplikasi Tugas Akhir / Skripsi</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <p class="card-text">Catatan: Upload dalam bentuk ZIP / RAR (Maksimal 100 MB)</p>
                            <!-- Basic file uploader -->
                            <div class="form-group position-relative has-icon-left">
                                <div class="text-bold-500"> <a href="<?= htmlspecialchars('../Uploads/' . basename($pg['File_Aplikasi'])) ?>" target="_blank"><?= htmlspecialchars($pg['File_Aplikasi']) ?></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Pernyataan Publikasi</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <p class="card-text">Catatan: Upload dalam bentuk PDF (Maksimal 1 MB)
                            <!-- Link to Surat Pernyataan Publikasi -->
                            <p>
                                <a href="https://intip.in/SuratPernyataanPublikasi/" target="_blank" style="text-decoration: underline;">
                                    Surat Pernyataan Publikasi
                                </a>
                            </p>
                            </p>
                            <div class="form-group position-relative has-icon-left">
                                <div class="text-bold-500"> <a href="<?= htmlspecialchars('../Uploads/' . basename($pg['Pernyataan_Publikasi'])) ?>" target="_blank"><?= htmlspecialchars($pg['Pernyataan_Publikasi']) ?></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        </div>
    </section>
</div>

            <footer>
    <div class="footer clearfix mb-0 text-muted">
        <div class="float-start">
            <p>2024 &copy; BeTaTI</p>
        </div>
        <div class="float-end">
            <p>Crafted <span class="text-danger"></span>
                by <a href="https://saugi.me">Kelompok 1</a></p>
        </div>
    </div>
</footer>
        </div>
    </div>
    <script src="../assets/static/js/components/dark.js"></script>
    <script src="../assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    
    
    <script src="../assets/compiled/js/app.js"></script>
    

    
<script src="../assets/extensions/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js"></script>
<script src="../assets/extensions/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.min.js"></script>
<script src="../assets/extensions/filepond-plugin-image-crop/filepond-plugin-image-crop.min.js"></script>
<script src="../assets/extensions/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js"></script>
<script src="../assets/extensions/filepond-plugin-image-filter/filepond-plugin-image-filter.min.js"></script>
<script src="../assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js"></script>
<script src="../assets/extensions/filepond-plugin-image-resize/filepond-plugin-image-resize.min.js"></script>
<script src="../assets/extensions/filepond/filepond.js"></script>
<script src="../assets/extensions/toastify-js/src/toastify.js"></script>
<script src="../assets/static/js/pages/filepond.js"></script>
<script src="../assets/extensions/jquery/jquery.min.js"></script>
<script src="../assets/extensions/parsleyjs/parsley.min.js"></script>
<script src="../assets/static/js/pages/parsley.js"></script>

</body>

</html>