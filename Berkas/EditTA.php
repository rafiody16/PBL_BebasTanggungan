<?php
session_start();
include('../Koneksi.php');
include('ProsesBerkas.php');

// Cek apakah pengguna sudah login
if (!isset($_SESSION['Username'])) {
    // Jika belum login, redirect ke halaman login
    header("Location: ../Login/Login.php");
    exit();
}

// Cek hak akses
if ($_SESSION['Role_ID'] != 8) {
    echo "<script>
    alert('Anda tidak memiliki akses ke halaman ini.');
    window.history.back();
    </script>";
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
                <h3>Edit Berkas Tugas Akhir</h3>
                <br>
            </div>
            <div class="col-12 col-md-3 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../User/mahasiswa/dashboardMHS.php">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="DetailBerkas.php">Berkas Bebas Tanggungan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Berkas Tugas Akhir</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="row">
        <form action="ProsesBerkas.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="NIM" value="<?php echo $NIM; ?>">
        <input type="hidden" name="action" value="editTA">
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
                            <input type="file" class="with-validation-filepond-laporan-edit"
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
                            <input type="file" class="with-validation-filepond-program-edit"
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
                                <input type="file" class="with-validation-filepond-publikasi-edit"  
                                data-max-file-size="1MB" name="Pernyataan_Publikasi" data-max-files="1">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-sm-12 d-flex justify-content-end">
                <button data-id="<?= $NIM ?>" class="btn btn-success btn-edit me-2 mb-2" style="font-size: 1.3rem; padding: 1rem 2rem;">Edit</button>
                <a href="DetailBerkas.php?NIM=<?= $NIM ?>" class="btn btn-light-secondary me-2 mb-2" style="font-size: 1.3rem; padding: 1rem 2rem;">Kembali</a>
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
    <script>
        document.querySelector('.with-validation-filepond-laporan').addEventListener('change', function(event) {
            const fileInput = event.target;
            const file = fileInput.files[0];
            const linkElement = document.getElementById('uploaded-file-link');

            if (file) {
                const fileURL = URL.createObjectURL(file);

                linkElement.href = fileURL;
                linkElement.textContent = file.name;

                fileInput.addEventListener('change', () => URL.revokeObjectURL(fileURL));
            } else {
           
                linkElement.href = "#";
                linkElement.textContent = "Tidak ada file";
            }
        });
        FilePond.create(document.querySelector('.with-validation-filepond-laporan'), {
            files: [
                {
                    source: '<?= $laporantaurl ?>',
                    options: {
                        type: 'remote',
                        file: {
                            name: '<?= htmlspecialchars($laporanta) ?>',
                            size: 12345,
                            type: 'application/pdf'
                        }
                    }
                }
            ]
        });

        $(document).ready(function() {
            $(".btn-edit").click(function(event) {
                event.preventDefault();

                var formData = new FormData($("form")[0]);
                formData.append("action", "editTA"); 

                var nim = $("input[name='NIM']").val();

                $.ajax({
                    url: "ProsesBerkas.php",
                    type: "POST",
                    data: formData,
                    contentType: false, 
                    processData: false, 
                    success: function(response) {
                        alert("Data berhasil diubah.");
                        location.href = "FormBerkas.php";
                    },
                    error: function(xhr, status, error) {
                        alert("Terjadi kesalahan. Silakan coba lagi.");
                    }
                });
            });
        });

    </script>
    

    
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