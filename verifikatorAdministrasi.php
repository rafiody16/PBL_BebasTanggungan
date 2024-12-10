<?php
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate"); // Untuk HTTP/1.1
header("Pragma: no-cache"); // Untuk HTTP/1.0
header("Expires: 0");// Untuk memastikan halaman tidak disimpan

if (!isset($_SESSION['Username'])) {
  // Jika belum login, redirect ke halaman login
  header("Location: Login/Login.php");
  exit();
}

// Cek hak akses
if ($_SESSION['Role_ID'] != 7) {
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
    <title>Dashboard Verifikator Administrasi - BeTaTI</title>

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
        window.location.href = 'verifikatorAdministrasi.php'; // Redirect ke dashboard
      }

    </script>
  </head>

  <body>
    <script src="assets/static/js/initTheme.js"></script>
    <div id="app">
    <?php include('sidebar3.php'); ?>
      <div id="main">
        <header class="mb-3">
          <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
          </a>
        </header>

        <div class="page-heading">
          <h3>Selamat Datang di BeTaTI!</h3>
        </div>
        <div class="page-content">
          <section class="row">
          <div class="col-20 col-lg-12">
            <div class="card">
                <div class="card-body">
                  <div class="" style="padding: 20px; border-radius: 100px;">
                    <h5>Halo, verifikator Berkas Administrasi!</h5>
                    <p>Selamat datang di beranda sistem informasi Bebas Tanggungan Jurusan Teknologi Informasi (BeTaTI). 
                        Ini adalah tempat di mana Anda dapat mengakses semua informasi penting yang berkaitan dengan bebas tanggungan mahasiswa jurusan Teknologi Informasi dan berbagai layanan akademik lainnya.</p>
                  </div>
                </div>
              </div>
          </div>
          </section>
        </div>
        <div class="page-content">
          <section class="row">
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
                          <h6 class="font-extrabold mb-0">112.000</h6>
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
                          <h6 class="font-extrabold mb-0">183.000</h6>
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
                          <h6 class="text-muted font-semibold">Following</h6>
                          <h6 class="font-extrabold mb-0">80.000</h6>
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
                          <h6 class="text-muted font-semibold">Saved Post</h6>
                          <h6 class="font-extrabold mb-0">112</h6>
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
              <p>
                Crafted with
                <span class="text-danger"
                  ><i class="bi bi-heart-fill icon-mid"></i
                ></span>
                by <a href="https://github.com/rafiody16/PBL_BebasTanggungan">Kelompok 1</a>
              </p>
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