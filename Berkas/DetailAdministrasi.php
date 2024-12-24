<?php
session_start();
header("Cache-Control: no-cache, no-store, must-revalidate"); // Untuk HTTP/1.1
header("Pragma: no-cache"); // Untuk HTTP/1.0
header("Expires: 0");


if ($_SESSION['Role_ID'] === 6 || $_SESSION['Role_ID'] === 8) {
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
    <title>Detail Berkas - Verifikasi Administrasi</title>
    
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
                <h3>Verifikasi Administrasi Mahasiswa</h3>
                <p class="text-subtitle text-muted">-</p>
            </div>
            <div class="col-12 col-md-3 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../verifikatorAdministrasi.php">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Verifikasi</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Detail Administrasi</h5>
                </div>
                <div class="card-body">
                        <div class="card-header">
                            <h4 class="card-title">Data Mahasiswa</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <?php 
                                    require_once '../Koneksi.php';
                                    require_once '../Models/Administrasi.php';

                                    $db = new Database();
                                    $conn = $db->getConnection();

                                    $admModel = new Administrasi($conn);

                                    $id = isset($_GET['ID_Administrasi']) ? $_GET['ID_Administrasi'] : '';
                                    $adm = null;

                                    if($id) {
                                        $adm = $admModel->getAdmById($id);
                                    }
                                ?>
                                <form class="form form-vertical">
                                    <div class="form-body">
                                    <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="NIM">NIM</label>
                                                    <div class="text-bold-500"><?= isset($adm['NIM']) ? htmlspecialchars($adm['NIM']) : '' ?></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="Nama">Nama</label>
                                                    <div class="text-bold-500"><?= isset($adm['Nama']) ? htmlspecialchars($adm['Nama']) : '' ?></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="Prodi">Prodi</label>
                                                    <div class="text-bold-500"><?= isset($adm['Prodi']) ? htmlspecialchars($adm['Prodi']) : '' ?></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="Tahun_Angkatan">Angkatan</label>
                                                    <div class="text-bold-500"><?= isset($adm['Tahun_Angkatan']) ? htmlspecialchars($adm['Tahun_Angkatan']) : '' ?></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="Prodi">Status Verifikasi</label>
                                                    <br>
                                                    <?php 
                                                        $status = $adm['Status_Verifikasi'];
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
                                                <label for="Laporan_Skripsi">Laporan Skripsi</label>
                                                <div class="text-bold-500"> <a href="<?= htmlspecialchars($adm['Laporan_Skripsi']) ?>" target="_blank"><?= htmlspecialchars($adm['Laporan_Skripsi']) ?></a></div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="Laporan_Magang">Laporan Magang</label>
                                                <div class="text-bold-500"><a href="<?= htmlspecialchars($adm['Laporan_Magang']) ?>"><?= isset($adm['Laporan_Magang']) ? htmlspecialchars($adm['Laporan_Magang']) : '' ?></a></div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="Bebas_Kompensasi">Bebas Kompen</label>
                                                <div class="text-bold-500"><a href="<?= htmlspecialchars($adm['Bebas_Kompensasi']) ?>"><?= isset($adm['Bebas_Kompensasi']) ? htmlspecialchars($adm['Bebas_Kompensasi']) : '' ?></a></div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="Laporan_Skripsi">Scan Toeic</label>
                                                <div class="text-bold-500"><a href="<?= htmlspecialchars($adm['Scan_Toeic']) ?>"><?= isset($adm['Scan_Toeic']) ? htmlspecialchars($adm['Scan_Toeic']) : '' ?></a></div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="Tanggal_Upload">Tanggal Upload</label>
                                                <div class="text-bold-500"><?= isset($adm['Tanggal_Upload']) ? htmlspecialchars($adm['Tanggal_Upload'] instanceof DateTime ? $adm['Tanggal_Upload']->format('d-m-Y') : $adm['Tanggal_Upload']) : '' ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="Tanggal_Verifikasi">Tanggal Verifikasi</label>
                                                <div class="text-bold-500"><?= isset($adm['Tanggal_Verifikasi']) ? htmlspecialchars($adm['Tanggal_Verifikasi'] instanceof DateTime ? $adm['Tanggal_Verifikasi']->format('d-m-Y') : $adm['Tanggal_Verifikasi']) : '-' ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="Keterangan">Keterangan</label>
                                                <div class="text-bold-500"><?= isset($adm['Keterangan']) ? htmlspecialchars($adm['Keterangan']) : '' ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="Verifikator">Verifikator</label>
                                                <div class="text-bold-500"><?= isset($adm['Verifikator']) ? htmlspecialchars($adm['Verifikator']) : 'Belum Diverifikasi' ?></div>
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
            <!-- <p>2024 &copy; BeTaTI</p> -->
            <p>2023 &copy; Mazer</p>
        </div>
        <div class="float-end">
            <!-- <p>Crafted <span class="text-danger"></span>
                by <a href="https://saugi.me">Kelompok 1</a></p> -->
            <p>Crafted with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
            by <a href="https://saugi.me">Saugi</a></p>
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
                var ID_Administrasi = $(this).data("id");
                if (confirm("Apakah Anda yakin ingin memverifikasi data ini?")) {
                    $.ajax({
                        url: "../Controllers/BerkasControllers.php?action=verifAdm",
                        type: "POST",
                        data: {
                            ID_Administrasi: ID_Administrasi,
                        },
                        success: function(response) {
                            location.reload();
                        }
                    })
                }
            });

            $('.btn-tolak').on('click', function () {
                var ID_Administrasi = $(this).data('id');
                var Keterangan = $("input[name='Keterangan']").val();
                if (!Keterangan) {
                    alert('Keterangan harus diisi!');
                    return;
                }
                if (confirm("Apakah Anda yakin ingin menolak data ini?")) {
                    $.ajax({
                        url: "../Controllers/BerkasControllers.php?action=tolakAdm",
                        type: "POST",
                        data: {
                            ID_Administrasi: ID_Administrasi,
                            Keterangan: Keterangan
                        },
                        success: function(response) {
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            console.error('Terjadi kesalahan:', error);
                            console.log('Response:', xhr.responseText)
                            alert('Gagal memproses data. Silakan coba lagi.', xhr.responseText);
                        }
                    });
                }
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