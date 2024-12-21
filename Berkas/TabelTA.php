<?php
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate"); // Untuk HTTP/1.1
header("Pragma: no-cache"); // Untuk HTTP/1.0
header("Expires: 0");


if ($_SESSION['Role_ID'] === 2 || $_SESSION['Role_ID'] === 3 || $_SESSION['Role_ID'] === 4 || $_SESSION['Role_ID'] === 5 || $_SESSION['Role_ID'] === 7) {
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
    <title>Verifikasi Berkas - Tugas Akhir</title>
    
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
                        <?php if ($role === 1) { ?>
                            <li class="breadcrumb-item"><a href="../index.php">Dashboard</a></li>
                        <?php } else if ($role === 6) { ?>
                            <li class="breadcrumb-item"><a href="../verifikatorTA.php">Dashboard</a></li>
                        <?php } ?>
                        <li class="breadcrumb-item active" aria-current="page">Berkas Tugas Akhir</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="row">
            <div class="card">
            <?php 
                require_once '../Koneksi.php';
                $db = new Database();
                $conn = $db->getConnection();
            ?>
            <div class="card-header">
                <h5 class="card-title">Tabel Tugas Akhir</h5>
                <form action="" method="get" class="form-inline">
                    <div class="form-group mb-2">
                        <label for="prodi" class="mr-2">Prodi:</label>
                        <select name="prodi" id="prodi" class="form-control">
                            <option value=""></option>
                            <?php 
                            // Ambil daftar Prodi dari database
                            $stmtProdi = sqlsrv_query($conn, "SELECT DISTINCT Prodi FROM Mahasiswa");
                            $selectedProdi = isset($_GET['prodi']) ? $_GET['prodi'] : ''; // Ambil nilai prodi yang dipilih
                            while ($rowProdi = sqlsrv_fetch_array($stmtProdi, SQLSRV_FETCH_ASSOC)) {
                                $selected = ($rowProdi['Prodi'] == $selectedProdi) ? 'selected' : ''; // Cek apakah ini yang dipilih
                                echo "<option value='" . htmlspecialchars($rowProdi['Prodi']) . "' $selected>" . htmlspecialchars($rowProdi['Prodi']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="tahunAngkatan" class="mr-2">Tahun Angkatan:</label>
                        <select name="tahunAngkatan" id="tahunAngkatan" class="form-control">
                            <option value=""></option>
                            <?php 
                            // Ambil daftar Tahun Angkatan dari database
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
                                        <th>Program Studi</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                    require_once '../Models/TugasAkhir.php';

                                    // Membuat objek dan memanggil fungsi
                                    $TA = new TugasAkhir($conn);
                                    $stmtTA = $TA->getAllTA();
                                    $no = 1;
                                    
                                    while ($row = sqlsrv_fetch_array($stmtTA, SQLSRV_FETCH_ASSOC)) {
                                        if ($row) {
                                            // Tampilkan data
                                            $status = $row['Status_Verifikasi'];
                                            $ID_Aplikasi = $row['ID_Aplikasi'];
                                            $nim = $row['NIM'];
                                            echo "<tr>";
                                                echo "<td style='display:none;'>" . htmlspecialchars($ID_Aplikasi) . "</td>";
                                                echo "<td>" . htmlspecialchars($no++) . "</td>";
                                                echo "<td>" . htmlspecialchars($nim) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['Nama']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['Prodi']) . "</td>";
                                                // Badge status
                                                if ($status === 'Menunggu') {
                                                    echo "<td><span class='badge bg-warning'>" . htmlspecialchars($status) . "</span></td>";
                                                } else if ($status === 'Terverifikasi') {
                                                    echo "<td><span class='badge bg-success'>" . htmlspecialchars($status) . "</span></td>";
                                                } else if ($status === 'Ditolak') {
                                                    echo "<td><span class='badge bg-danger'>" . htmlspecialchars($status) . "</span></td>";
                                                }
                                                echo "<td>" . htmlspecialchars($row['Keterangan']) . "</td>";
                                                // Tombol aksi
                                                echo "<td>";
                                                    echo "<button data-id='" . $ID_Aplikasi . "' class='btn btn-primary btn-detail'>Detail</button>";
                                                    echo "<button data-id='" . $ID_Aplikasi . "' class='btn btn-success btn-verifikasi'>Verifikasi</button>";
                                                    echo "<button data-bs-toggle='modal' data-bs-target='#default' class='btn btn-danger'>Tolak</button>";
                                                echo "</td>";
                                            echo "</tr>";
                                        } else {
                                            echo "Belum ada data.";
                                        }
                                    }                                    
                                ?>
                                </tbody>
                            </table>
                            <a href="TabelTA.php" class="btn btn-secondary mb-3">Reset Filter</a>
                        </div>
                    </div>
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
                    <button type="button" class="btn btn-danger btn-tolak" data-bs-dismiss="modal" data-id="<?= $ID_Aplikasi ?>">
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
            $(".btn-detail").click(function() {
                var ID_Aplikasi = $(this).data("id");
                $.ajax({
                url: "DetailTA.php",
                type: "GET",
                data: { ID_Aplikasi: ID_Aplikasi, action: "detailTA" },
                    success: function(response) {
                        location.href = "DetailTA.php?ID_Aplikasi=" + ID_Aplikasi;
                    }
                });
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
                    url: 'ProsesBerkas.php',
                    type: 'POST',
                    data: {
                        action: 'tolakTA',
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