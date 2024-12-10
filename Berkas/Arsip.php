<?php
session_start();

// header("Cache-Control: no-cache, no-store, must-revalidate"); // Untuk HTTP/1.1
// header("Pragma: no-cache"); // Untuk HTTP/1.0
// header("Expires: 0");


if ($_SESSION['Role_ID'] === 8) {
    echo "<script>
    alert('Anda tidak memiliki akses ke halaman ini.');
    window.history.back();
    </script>";
  }
$role = $_SESSION['Role_ID'];


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
                            <h3>Arsip Berkas</h3>
                            <p class="text-subtitle text-muted">-</p>
                        </div>
                        <div class="col-12 col-md-3 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboardUser.html">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Arsip Berkas Mahasiswa</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <section class="section">
                    <div class="row">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Tabel Administrasi</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-lg">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>NIM</th>
                                                <th>Nama</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            include('ProsesBerkas.php');
                                            $stmt3 = Arsip();
                                            $no = 1;
                                            while ($row = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC)) {
                                                if ($row) {
                                                    if ($role === 6) {
                                                        $id = $row['ID_Aplikasi'];
                                                    } else if ($role === 7) {   
                                                        $id = $row['ID_Administrasi'];
                                                    } else {
                                                        $id = $row['ID_Pengumpulan'];   
                                                    }
                                                    $nim = $row['NIM'];
                                                    $status = $row['Status_Pengumpulan'];
                                                    echo "<tr>";
                                                    echo "<td style='display:none;'>" . htmlspecialchars($id) . "</td>";
                                                    echo "<td>" . htmlspecialchars($no++) . "</td>";
                                                    echo "<td>" . htmlspecialchars($nim) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['Nama']) . "</td>";
                                                    if ($status === 'Menunggu') {
                                                        ?>
                                                        <td><span class="badge bg-warning"><?= htmlspecialchars($status) ?></span></td>
                                                        <?php 
                                                    } else if ($status === 'Terverifikasi') {
                                                        ?>
                                                        <td><span class="badge bg-success"><?= htmlspecialchars($status) ?></span></td>
                                                        <?php
                                                    } else if ($status === 'Ditolak') {
                                                        ?>
                                                        <td><span class="badge bg-danger"><?= htmlspecialchars($status) ?></span></td>
                                                        <?php
                                                    }

                                                    if ($role === 1 || $role === 2 || $role === 3 || $role === 4 || $role === 5) {
                                            ?>
                                                    <td>
                                                        <button data-bs-toggle="modal" data-bs-target="#lihat" class="btn btn-primary">Detail</button>
                                                    </td>
                                            <?php
                                                    } else if ($role === 6) {
                                            ?> 
                                                    <td>
                                                        <a href="DetailTA.php?ID_Aplikasi=<?= $id ?>" class="btn btn-primary">Detail</a>
                                                    </td>
                                            <?php 
                                                    } else if ($role === 7) {
                                            ?>
                                                    <td>
                                                        <a href="DetailTA.php?ID_Aplikasi=<?= $id ?>" class="btn btn-primary">Detail</a>
                                                    </td>
                                            <?php
                                                    }
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
                </section>
            </div>
            <div class="modal fade text-left" id="lihat" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailModalLabel">Detail Informasi</h5>
                            <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                    <div class="modal-body">
                        <p>Pilih detail yang ingin ditampilkan:</p>
                        <div class="d-flex flex-column">
                            <table>
                                <tr>
                                    <td>Detail Administrasi:</td>
                                    <td><a href="DetailAdministrasi.php?ID_Administrasi=<?= $ID_Pengumpulan ?>" class="btn btn-primary my-2">Lihat Detail</a></td>
                                </tr>
                                <tr>
                                <td>Detail Tugas Akhir:</td>
                                <td><a href="DetailTA.php?ID_Aplikasi=<?= $ID_Pengumpulan ?>" class="btn btn-primary my-2">Lihat Detail</a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Tutup</span>
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

            $(".btn-verifikasi").click(function() {
                var ID_Pengumpulan = $(this).data("id");
                if (confirm("Apakah Anda yakin ingin memverifikasi data ini?")) {
                    $.ajax({
                        url: "ProsesBerkas.php",
                        type: "POST",
                        data: {
                            ID_Pengumpulan: ID_Pengumpulan,
                            action: "verifikasiBerkas"
                        },
                        success: function(response) {
                            location.reload();
                        }
                    })
                }
            });

            $('.btn-tolak').on('click', function() {
                var ID_Pengumpulan = $(this).data('id');
                var Keterangan = $("input[name='Keterangan']").val();
                var SubBagian = $("select[name='SubBagian']").val();
                if (!Keterangan) {
                    alert('Keterangan harus diisi!');
                    return;
                }
                if (!SubBagian) {
                    alert('Sub Bagian harus diisi!');
                    return;
                }
                if (confirm("Apakah Anda yakin ingin menolak data ini?")) {
                    $.ajax({
                        url: 'ProsesBerkas.php',
                        type: 'POST',
                        data: {
                            action: 'tolakBerkas',
                            ID_Pengumpulan: ID_Pengumpulan,
                            Keterangan: Keterangan,
                            SubBagian: SubBagian
                        },
                        success: function(response) {
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            console.error('Terjadi kesalahan:', error);
                            alert('Gagal memproses data. Silakan coba lagi.');
                        }
                    })
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