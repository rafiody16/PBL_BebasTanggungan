<?php
session_start();

include('ProsesBerkas.php');

GetByIdTA();

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                <h3>Verifikasi Tugas Akhir Mahasiswa</h3>
                <p class="text-subtitle text-muted">-</p>
            </div>
            <div class="col-12 col-md-3 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboardUser.html">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Berkas Tugas Akhir</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Tabel Tugas Akhir</h5>
                </div>
                <div class="card-body">
                        <div class="card-header">
                            <h4 class="card-title">Detail Tugas Akhir</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form form-vertical">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="NIM">NIM</label>
                                                    <div class="text-bold-500"><?= isset($nim) ? htmlspecialchars($nim) : '' ?></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="Nama">Nama</label>
                                                    <div class="text-bold-500"><?= isset($nama) ? htmlspecialchars($nama) : '' ?></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="Prodi">Prodi</label>
                                                    <div class="text-bold-500"><?= isset($prodi) ? htmlspecialchars($prodi) : '' ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="Laporan_Skripsi">File Aplikasi</label>
                                                <div class="text-bold-500"> <a href="<?= htmlspecialchars($fileaplikasiurl) ?>" target="_blank"><?= htmlspecialchars($fileaplikasi) ?></a></div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="Laporan_Magang">Laporan Tugas Akhir</label>
                                                <div class="text-bold-500"><a href="<?= htmlspecialchars($laporantaurl) ?>"><?= isset($laporanta) ? htmlspecialchars($laporanta) : '' ?></a></div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="Bebas_Kompensasi">Link Pernyataan Publikasi</label>
                                                <div class="text-bold-500"><a href="<?= htmlspecialchars($pernyataanpublikasiurl) ?>"><?= isset($pernyataanpublikasi) ? htmlspecialchars($pernyataanpublikasi) : '' ?></a></div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="Tanggal_Upload">Tanggal Upload</label>
                                                <div class="text-bold-500"><?= isset($tanggalUpload) ? htmlspecialchars($tanggalUpload instanceof DateTime ? $tanggalUpload->format('d-m-Y') : $tanggalUpload) : '' ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="Status_Verifikasi">Status Verifikasi</label>
                                                <div class="text-bold-500"><?= isset($statusVerifikasi) ? htmlspecialchars($statusVerifikasi) : '' ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="Tanggal_Verifikasi">Tanggal Verifikasi</label>
                                                <div class="text-bold-500"><?= isset($tanggalVerifikasi) ? htmlspecialchars($tanggalVerifikasi instanceof DateTime ? $tanggalVerifikasi->format('d-m-Y') : $tanggalVerifikasi) : '-' ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="Keterangan">Keterangan</label>
                                                <div class="text-bold-500"><?= isset($keterangan) ? htmlspecialchars($keterangan) : '' ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="Verifikator">Verifikator</label>
                                                <div class="text-bold-500"><?= isset($verifikator) ? htmlspecialchars($verifikator) : 'Belum Diverifikasi' ?></div>
                                            </div>
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
        $(document).ready(function() {
            $(".btn-detail").click(function() {
                var ID_Administrasi = $(this).data("id");
                $.ajax({
                url: "DetailAdministrasi.php",
                type: "POST",
                data: { ID_Administrasi: ID_Administrasi, action: "readAdministrasi" },
                    success: function(response) {
                        location.href = "DetailMahasiswa.php?NIM=" + ID_Administrasi;
                    }
                });
            });

            $(".btn-verifikasi").click(function() {
                var ID_Administrasi = $(this).data("id");
                    $.ajax({
                    url: "ProsesBerkas.php",
                    type: "POST",
                    data: { ID_Administrasi: ID_Administrasi, action: "verifikasiAdministrasi" },
                    success: function(response) {
                        location.reload();
                    }
                })   
            });

            $('.btn-tolak').on('click', function () {
                var ID_Administrasi = $(this).data('id');
                var Keterangan = $("input[name='Keterangan']").val();
                if (!Keterangan) {
                    alert('Keterangan harus diisi!');
                    return;
                }
                $.ajax({
                    url: 'ProsesBerkas.php',
                    type: 'POST',
                    data: {
                        action: 'tolakAdministrasi',
                        ID_Administrasi: ID_Administrasi,
                        Keterangan: Keterangan
                    },
                    success: function (response) {
                        location.reload(); 
                    },
                    error: function (xhr, status, error) {
                        console.error('Terjadi kesalahan:', error);
                        alert('Gagal memproses data. Silakan coba lagi.');
                    }
                });
            });

            $("#modalClose").click(function() {
                $("#modal").hide();
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