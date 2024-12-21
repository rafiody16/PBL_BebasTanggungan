<?php
session_start();


header("Cache-Control: no-cache, no-store, must-revalidate"); // Untuk HTTP/1.1
header("Pragma: no-cache"); // Untuk HTTP/1.0
header("Expires: 0");// Untuk memastikan halaman tidak disimpan

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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unggah Berkas - Berkas Tugas Akhir</title>
    
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
    <?php include('../assets/Sidebar2.php'); 
        // require_once '../Koneksi.php';
        // $db = new Database();
        // $conn = $db->getConnection();
        
        // $sqlCheck = "SELECT COUNT(*) AS total FROM Pengumpulan WHERE NIM = ?";
        // $paramsCheck = [$NIM];
        // $stmtCheck = sqlsrv_query($conn, $sqlCheck, $paramsCheck);
        
        // $rowCheck = sqlsrv_fetch_array($stmtCheck, SQLSRV_FETCH_ASSOC);
        // if ($rowCheck['total'] > 0) {
        //     echo "<script>window.location.href = 'DetailBerkas.php?NIM=".urlencode($NIM)."';</script>";
        // }        
    ?>
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
                <h3>Unggah Berkas</h3>
                <p class="text-subtitle text-muted">Bagi mahasiswa lulusan Jurusan Teknologi Informasi yang bermasalah pada hosting, dapat mengganti hosting dengan Google Drive masing-masing!</p>
            </div>
            <div class="col-12 col-md-3 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../User/mahasiswa/dashboardMHS.php">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Unggah Berkas</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="row">
        <form method="POST" action="../Controllers/BerkasControllers.php?action=uploadFile" enctype="multipart/form-data">
        <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Bukti Distribusi Buku Skripsi / Laporan Akhir</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <p class="card-text">Catatan : Upload dalam bentuk pdf (Maksimal 10 MB)</p>
                            <!-- Basic file uploader -->
                            <div class="form-group position-relative has-icon-left">
                                <input type="file" class="with-validation-filepond-admin1" required 
                                data-max-file-size="10MB" name="Laporan_Skripsi" data-max-files="1">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Bukti Distribusi Laporan PKL</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <p class="card-text">Catatan : Upload dalam bentuk pdf (Maksimal 10 MB)</p>
                            <div class="form-group position-relative has-icon-left">
                                <input type="file" class="with-validation-filepond-admin1" required 
                                data-max-file-size="10MB" name="Laporan_Magang" data-max-files="1">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Bukti Bebas Kompen</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <p class="card-text">Catatan : Upload dalam bentuk pdf (Maksimal 1 MB)</p>
                            <!-- Basic file uploader -->
                            <input type="file" class="with-validation-filepond-admin2" required 
                            data-max-file-size="1MB" name="Bebas_Kompensasi" data-max-files="1">
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
                            <p class="card-text">Catatan : Upload dalam bentuk pdf (Maksimal 1 MB)</p>
                            <!-- Basic file uploader -->
                            <input type="file" class="with-validation-filepond-admin2" required 
                            data-max-file-size="1MB" name="Scan_Toeic" data-max-files="1">
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
                            <input type="file" class="with-validation-filepond-laporan" required 
                            data-max-file-size="10MB" name="Laporan_TA" data-max-files="1">
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
                            <input type="file" class="with-validation-filepond-program" required 
                            data-max-file-size="100MB" name="File_Aplikasi" data-max-files="1">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Bukti Publikasi</h5>
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
                            <div  class="form-group position-relative has-icon-left">
                                <input type="file" class="with-validation-filepond-publikasi" required 
                                data-max-file-size="1MB" name="Pernyataan_Publikasi" data-max-files="1">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-sm-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary me-2 mb-2" style="font-size: 1.3rem; padding: 1rem 2rem;" name="simpanBerkas">Submit</button>
                <button type="reset" class="btn btn-light-secondary me-2 mb-2" style="font-size: 1.3rem; padding: 1rem 2rem;">Reset</button>
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
    <script src="../assets/extensions/jquery/jquery.min.js"></script>
    <script>
        // $(document).ready(function() {
        //     $('form').submit(function(e) {
        //         e.preventDefault();
            
        //         var formData = new FormData(this);
            
        //         var buttonName = $('button[type="submit"]').attr('name');

        //         if (buttonName === 'simpanBerkas') {
        //             var url = '../Controllers/BerkasControllers.php?action=uploadFile';
        //         } 
        //         jQuery.ajax({
        //             url: url,
        //             type: 'POST',
        //             data: formData,
        //             processData: false,
        //             contentType: false,
        //             success: function(response) {
        //                 alert(response);
        //                 location.reload(); // Memuat ulang halaman setelah submit berhasil
        //             },
        //             error: function(xhr, status, error) {
        //                 console.error('AJAX Error:', status, error);
        //                 alert('Terjadi kesalahan: ' + error);
        //             }
        //         });
        //     });

        // });
    </script>
    
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
<script src="../assets/extensions/parsleyjs/parsley.min.js"></script>
<script src="../assets/static/js/pages/parsley.js"></script>

</body>

</html>