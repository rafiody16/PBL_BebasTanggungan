<?php
session_start();

if ($_SESSION['Role_ID'] === 7 || $_SESSION['Role_ID'] === 8) {
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
                    <h5 class="card-title">Detail Tugas Akhir</h5>
                </div>
                <div class="card-body">
                        <div class="card-header">
                            <h4 class="card-title">Data Mahasiswa</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form form-vertical">
                                    <?php 
                                        require_once '../Koneksi.php';
                                        require_once '../Models/TugasAkhir.php';
                                        
                                        $db = new Database();
                                        $TAModel = new TugasAkhir($db->getConnection());
                                        
                                        $id = isset($_GET['ID_Aplikasi']) ? $_GET['ID_Aplikasi'] : '';
                                        $TA = null;
                                        
                                        if ($id) {
                                            $TA = $TAModel->getTaById($id);
                                        }
                                    ?>
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="NIM">NIM</label>
                                                    <div class="text-bold-500"><?= isset($TA['NIM']) ? htmlspecialchars($TA['NIM']) : '' ?></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="Nama">Nama</label>
                                                    <div class="text-bold-500"><?= isset($TA['Nama']) ? htmlspecialchars($TA['Nama']) : '' ?></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="Prodi">Prodi</label>
                                                    <div class="text-bold-500"><?= isset($TA['Prodi']) ? htmlspecialchars($TA['Prodi']) : '' ?></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="Tahun_Angkatan">Angkatan</label>
                                                    <div class="text-bold-500"><?= isset($TA['Tahun_Angkatan']) ? htmlspecialchars($TA['Tahun_Angkatan']) : '' ?></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="Prodi">Status Verifikasi</label>
                                                    <br>
                                                    <?php 
                                                        $status = $TA['Status_Verifikasi'];
                                                        if ($status === 'Menunggu') {
                                                            echo "<td><span class='badge bg-warning'>" . htmlspecialchars($status) . "</span></td>";
                                                        } else if ($status === 'Terverifikasi') {
                                                            echo "<td><span class='badge bg-success'>" . htmlspecialchars($status) . "</span></td>";
                                                        } else if ($status === 'Ditolak') {
                                                            echo "<td><span class='badge bg-danger'>" . htmlspecialchars($status) . "</span></td>";
                                                        }
                                                    ?>
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
                                                <div class="text-bold-500"> <a href="<?= htmlspecialchars('../Uploads/'.$TA['File_Aplikasi']) ?>" target="_blank"><?= htmlspecialchars($TA['File_Aplikasi']) ?></a></div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="Laporan_Magang">Laporan Tugas Akhir</label>
                                                <div class="text-bold-500"><a href="<?= htmlspecialchars('../Uploads/'.$TA['Laporan_TA']) ?>"><?= isset($TA['Laporan_TA']) ? htmlspecialchars($TA['Laporan_TA']) : '' ?></a></div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="Bebas_Kompensasi">Pernyataan Publikasi</label>
                                                <div class="text-bold-500"><a href="<?= htmlspecialchars('../Uploads/'.$TA['Pernyataan_Publikasi']) ?>"><?= isset($TA['Pernyataan_Publikasi']) ? htmlspecialchars($TA['Pernyataan_Publikasi']) : '' ?></a></div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="Tanggal_Upload">Tanggal Upload</label>
                                                <div class="text-bold-500"><?= isset($TA['Tanggal_Upload']) ? htmlspecialchars($TA['Tanggal_Upload'] instanceof DateTime ? $TA['Tanggal_Upload']->format('d-m-Y') : $TA['Tanggal_Upload']) : '' ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="Tanggal_Verifikasi">Tanggal Verifikasi</label>
                                                <div class="text-bold-500"><?= isset($TA['Tanggal_Verifikasi']) ? htmlspecialchars($TA['Tanggal_Verifikasi'] instanceof DateTime ? $TA['Tanggal_Verifikasi']->format('d-m-Y') : $TA['Tanggal_Verifikasi']) : '-' ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="Keterangan">Keterangan</label>
                                                <div class="text-bold-500"><?= isset($TA['Keterangan']) ? htmlspecialchars($TA['Keterangan']) : '-' ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="Verifikator">Verifikator</label>
                                                <div class="text-bold-500"><?= isset($TA['Verifikator']) ? htmlspecialchars($TA['Verifikator']) : 'Belum Diverifikasi' ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <button class="btn btn-success btn-verifikasi" data-id="<?= $id ?>">Verifikasi</button>
                <button data-bs-toggle='modal' data-bs-target='#default' class='btn btn-danger'>Tolak</button>
                <button class="btn btn-secondary btn-kembali">Kembali</button>
            </div>
        </div>
    </section>
</div>
<div class="modal fade text-left" id="default" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel1">Tolak Verifikasi</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="ProsesBerkas.php" method="POST">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="Keterangan">Keterangan</label>
                                <input type="text" class="form-control" name="Keterangan" placeholder="Masukkan Keterangan">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tutup</span>
                    </button>
                    <button type="button" class="btn btn-danger btn-tolak" data-bs-dismiss="modal" data-id="<?= $id ?>">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tolak</span>
                    </button>
                </div>
            </div>
        </div>
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
            $(".btn-kembali").click(function() {
                window.history.back();
            });

            $(".btn-verifikasi").click(function() {
                var ID_Aplikasi = $(this).data("id");
                if (confirm("Apakah Anda yakin ingin memverifikasi data ini?")) {
                    $.ajax({
                    url: "../Controllers/BerkasControllers.php?action=verifTA",
                    type: "POST",
                    data: { ID_Aplikasi: ID_Aplikasi },
                        success: function(response) {
                            location.reload();
                        }
                    });   
                }   
            });

            $('.btn-tolak').on('click', function () {
                var ID_Aplikasi = $(this).data('id');
                var Keterangan = $("input[name='Keterangan']").val();
                if (!Keterangan) {
                    alert('Keterangan harus diisi!');
                    return;
                }
                $.ajax({
                    url: "../Controllers/BerkasControllers.php?action=tolakTA",
                    type: 'POST',
                    data: {
                        ID_Aplikasi: ID_Aplikasi,
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