<?php
session_start();
echo 'Session NIP: ' . (isset($_SESSION['NIP']) ? $_SESSION['NIP'] : 'Session NIP tidak ditemukan');
header("Cache-Control: no-cache, no-store, must-revalidate"); // Untuk HTTP/1.1
header("Pragma: no-cache"); // Untuk HTTP/1.0
header("Expires: 0");// Untuk memastikan halaman tidak disimpan

if (!isset($_SESSION['Username'])) {
  // Jika belum login, redirect ke halaman login
  header("Location: Login/Login.php");
  exit();
}

// Cek hak akses
if ($_SESSION['Role_ID'] != 1) {
  echo "<script>
    alert('Anda tidak memiliki akses ke halaman ini.');
    window.history.back();
    </script>";
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Admin - BeTaTI</title>

    <link
      rel="shortcut icon"
      href="assets/img/logoJti.png"
      type="image/x-icon"
    />
    <link
      rel="shortcut icon"
      href="assets/img/logoJti.png"
      type="image/png"
    />

    <link rel="stylesheet" crossorigin href="assets/compiled/css/app.css" />
    <link
      rel="stylesheet"
      crossorigin
      href="assets/compiled/css/app-dark.css"
    />
    <link
      rel="stylesheet"
      crossorigin
      href="assets/compiled/css/iconly.css"
    />
    <script>
      if (performance.navigation.type === 2) { // Deteksi navigasi 'Back'
        window.location.href = 'index.php'; // Redirect ke dashboard
      }

    </script>
  </head>

  <body>
    <script src="assets/static/js/initTheme.js"></script>
    <div id="app">
    <?php 
      include('sidebar3.php'); 
    ?>
      <div id="main">
        <header class="mb-3">
          <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
          </a>
        </header>

        <div class="page-heading">
          <h3>Selamat Datang, Admin <?= htmlspecialchars($_SESSION['Username'])?></h3>
        </div>
        <div class="page-content">
          <section class="row">
            <div class="col-12 col-lg-12">
              <div class="row">
                <div class="col-6 col-lg-3 col-md-6">
                  <div class="card">
                    <div class="card-body px-4 py-4-5">
                      <div class="row">
                        <div
                          class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start"
                        >
                          <div class="stats-icon purple mb-2">
                            <i class="iconly-boldShow"></i>
                          </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                          <h6 class="text-muted font-semibold">
                            Jumlah User Mahasiswa
                          </h6>
                          <h6 class="font-extrabold mb-0">
                            <?php 
                              require_once 'Koneksi.php';
                              $db = new Database();
                              $conn = $db->getConnection();
                              $sql = "SELECT COUNT(NIM) AS jumlah_mahasiswa FROM Mahasiswa";
                              $stmt = sqlsrv_query($conn, $sql);
                              
                              if ($stmt === false) {
                                  die("Query gagal: " . print_r(sqlsrv_errors(), true));
                              }
                              
                              // Ambil hasil query
                              $jumlahMahasiswa = 0;
                              if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                  $jumlahMahasiswa = $row['jumlah_mahasiswa'];
                              }
                            
                              echo number_format($jumlahMahasiswa);
                            ?>
                          </h6>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                  <div class="card">
                    <div class="card-body px-4 py-4-5">
                      <div class="row">
                        <div
                          class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start"
                        >
                          <div class="stats-icon blue mb-2">
                            <i class="iconly-boldProfile"></i>
                          </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                          <h6 class="text-muted font-semibold">Jumlah User Staff</h6>
                          <h6 class="font-extrabold mb-0">
                            <?php 
                            $sql = "SELECT COUNT(NIP) AS jumlah_staff FROM Staff";
                            $stmt = sqlsrv_query($conn, $sql);
                            
                            if ($stmt === false) {
                                die("Query gagal: " . print_r(sqlsrv_errors(), true));
                            }
                            
                            // Ambil hasil query
                            $jumlahStaff = 0;
                            if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                $jumlahStaff = $row['jumlah_staff'];
                            }

                            echo number_format($jumlahStaff);
                            ?>
                          </h6>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                  <div class="card">
                    <div class="card-body px-4 py-4-5">
                      <div class="row">
                        <div
                          class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start"
                        >
                          <div class="stats-icon green mb-2">
                            <i class="iconly-boldAdd-User"></i>
                          </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                          <h6 class="text-muted font-semibold">Jumlah Verifikasi</h6>
                          <h6 class="font-extrabold mb-0">
                            <?php 
                            $sql = "SELECT COUNT(ID_Pengumpulan) AS jml_verifikasi FROM Pengumpulan
                                    WHERE Status_Pengumpulan != 'Terverifikasi';";
                            $stmt = sqlsrv_query($conn, $sql);
                            
                            if ($stmt === false) {
                                die("Query gagal: " . print_r(sqlsrv_errors(), true));
                            }
                            
                            // Ambil hasil query
                            $jumlahVerifikasi = 0;
                            if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                $jumlahVerifikasi = $row['jml_verifikasi'];
                            }

                            echo number_format($jumlahVerifikasi);
                            ?>
                          </h6>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                  <div class="card">
                    <div class="card-body px-4 py-4-5">
                      <div class="row">
                        <div
                          class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start"
                        >
                          <div class="stats-icon red mb-2">
                            <i class="iconly-boldBookmark"></i>
                          </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                          <h6 class="text-muted font-semibold">Jumlah Arsip Data</h6>
                          <h6 class="font-extrabold mb-0">
                            <?php 
                            $sql = "SELECT COUNT(ID_Pengumpulan) AS jml_verifikasi FROM Pengumpulan
                                    WHERE Status_Pengumpulan = 'Terverifikasi';";
                            $stmt = sqlsrv_query($conn, $sql);
                            
                            if ($stmt === false) {
                                die("Query gagal: " . print_r(sqlsrv_errors(), true));
                            }
                            
                            // Ambil hasil query
                            $jumlahVerifikasi = 0;
                            if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                $jumlahVerifikasi = $row['jml_verifikasi'];
                            }

                            echo number_format($jumlahVerifikasi);
                            ?>
                          </h6>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

        <footer>
          <div class="footer clearfix mb-0 text-muted">
            <div class="float-start">
              <p>2023 &copy; Mazer</p>
            </div>
            <div class="float-end">
              <!-- <p>
                Crafted with
                <span class="text-danger"
                  ><i class="bi bi-heart-fill icon-mid"></i
                ></span>
                by <a href="https://github.com/rafiody16/PBL_BebasTanggungan">Kelompok 1</a>
              </p> -->
              <p>Crafted with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
              by <a href="https://saugi.me">Saugi</a></p>
            </div>
          </div>
        </footer>
      </div>
    </div>
    <script src="assets/static/js/components/dark.js"></script>
    <script src=assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>

    <script src="assets/compiled/js/app.js"></script>

    <!-- Need: Apexcharts -->
    <script src="assets/extensions/apexcharts/apexcharts.min.js"></script>
    <script src="assets/static/js/pages/dashboard.js"></script>
  </body>
</html>
