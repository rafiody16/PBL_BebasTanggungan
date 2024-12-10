<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profil Akun - BeTaTI</title>

    <link
      rel="shortcut icon"
      href="../../assets/img/logoJti.png"
      type="image/x-icon"
    />
    <link
      rel="shortcut icon"
      href="../../assets/img/logoJti.png"
      type="image/png"
    />

    <link
      rel="stylesheet"
      crossorigin
      href="../../assets/compiled/css/app.css"
    />
    <link
      rel="stylesheet"
      crossorigin
      href="../../assets/compiled/css/app-dark.css"
    />
  </head>

  <?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['Username'])) {
    // Jika belum login, redirect ke halaman login
    header("Location: ../../Login/Login.php");
    exit();
}

// Cek hak akses
if ($_SESSION['Role_ID'] != 8) {
    // Jika bukan admin, redirect atau tampilkan pesan error
    echo "<script>alert('Anda tidak memiliki akses ke halaman ini.'); window.location.href = '../Login/Login.php';</script>";
    exit();
}

include('mhs_data.php');
include('../../Koneksi.php');

getDataMahasiswaByID();

?>

  <body>
    <script src="../../assets/static/js/initTheme.js"></script>
    <div id="app">
    <?php include('../../assets/sidebar/Sidebar.php'); ?>
      <div id="main">
        <header class="mb-3">
          <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
          </a>
        </header>

        <div class="page-heading">
          <div class="page-title">
            <div class="row">
              <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Profil Akun</h3>
                <!-- <p class="text-subtitle text-muted">Kustomisasi profil Anda</p> -->
              </div>
              <div class="col-12 col-md-6 order-md-2 order-first">
                <nav
                  aria-label="breadcrumb"
                  class="breadcrumb-header float-start float-lg-end"
                >
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                      <a href="dashboardMHS.php">Beranda</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                      Profil
                    </li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
          <section class="section">
            <div class="row">
              <!-- <div class="col-12 col-lg-4">
                <div class="card">
                  <div class="card-body">
                    <div
                      class="d-flex justify-content-center align-items-center flex-column"
                    >
                      <div class="avatar avatar-2xl">
                        <img
                          src="./../../assets/compiled/jpg/2.jpg"
                          alt="Avatar"
                        />
                      </div>

                      <h3 class="mt-3"></h3>
                      <p class="text-small">
                      </p>
                    </div>
                  </div>
                </div>
              </div> -->
              <div class="col-12 col-lg-12">
                <div class="card">
                  <div class="card-body">
                  <form class="form form-vertical">
                      <div class="form-body">
                          <div class="row">
                              <div class="col-md-6 col-12">
                                  <div class="form-group">
                                      <label for="Nama">Nama</label>
                                      <h4><?= isset($nama) ? htmlspecialchars($nama) : '' ?></h4>
                                  </div>
                              </div>
                              <div class="col-md-6 col-12">
                                  <div class="form-group">
                                      <label for="NIM">NIM</label>
                                      <h4><?= isset($nim) ? htmlspecialchars($nim) : '' ?></h4>
                                  </div>
                              </div>
                              <div class="col-md-6 col-12">
                                  <div class="form-group">
                                      <label for="Role_ID">Program Studi</label>
                                      <h4><?= (isset($Prodi) && $Prodi === 'TI') ? 'D-IV Teknik Informatika' : ((isset($Prodi) && $Prodi === 'SIB') ? 'D-IV Sistem Informasi Bisnis' : 'D-II Pengembangan Piranti Lunak Situs')?></h4>
                                  </div>
                              </div>
                              <div class="col-md-6 col-12">
                                  <div class="form-group">
                                      <label for="Username">Username</label>
                                      <h4><?= isset($username) ? htmlspecialchars($username) : '' ?></h4>
                                  </div>
                              </div>
                              <div class="col-md-6 col-12">
                                  <div class="form-group">
                                      <label for="Email">Email</label>
                                      <h4><?= isset($email) ? htmlspecialchars($email) : '' ?></h4>
                                  </div>
                              </div>
                              <div class="col-md-6 col-12">
                                  <div class="form-group">
                                      <label for="Alamat">Alamat</label>
                                      <h4><?= isset($alamat) ? htmlspecialchars($alamat) : '' ?></h4>
                                  </div>
                              </div>
                              <div class="col-md-6 col-12">
                                  <div class="form-group">
                                      <label for="NoHp">No.Hp</label>
                                      <h4><?= isset($noHp) ? htmlspecialchars($noHp) : '' ?></h4>
                                  </div>
                              </div>
                              <div class="col-md-6 col-12">
                                  <div class="form-group">
                                      <label for="TempatLahir">Tempat Lahir</label>
                                      <h4><?= isset($Tempat_Lahir) ? htmlspecialchars($Tempat_Lahir) : '' ?></h4>
                                  </div>
                              </div>
                              <div class="col-md-6 col-12">
                                  <div class="form-group">
                                      <label for="TanggalLahir">Tanggal Lahir</label>
                                      <h4><?php
                                      echo htmlspecialchars($Tanggal_Lahir->format('d-m-Y')); 
                                      ?></h4>
                                  </div>
                              </div>
                              <div class="col-md-6 col-12">
                                  <div class="form-group">
                                      <label for="JenisKelamin">Jenis Kelamin</label>
                                      <h4><?= isset($jeniskelamin) ? ($jeniskelamin === 'L' ? 'Laki-Laki' : ($jeniskelamin === 'P' ? 'Perempuan' : '')) : '' ?></h4>
                                  </div>
                              </div>
                          </div>
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
                by <a href="https://saugi.me">Kelompok 1</a>
              </p>
            </div>
          </div>
        </footer>
      </div>
    </div>
    <script src="../../assets/static/js/components/dark.js"></script>
    <script src="../../assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>

    <script src="../../assets/compiled/js/app.js"></script>
  </body>
</html>
