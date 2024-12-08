<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['Username'])) {
    // Jika belum login, redirect ke halaman login
    header("Location: ../Login/Login.php");
    exit();
}

// Cek hak akses
if ($_SESSION['Role_ID'] != 1) {
    // Jika bukan admin, redirect atau tampilkan pesan error
    echo "<script>alert('Anda tidak memiliki akses ke halaman ini.'); window.location.href = '../Login/Login.php';</script>";
    exit();
}

include('UserProses.php');
include('../Koneksi.php');

getDataStaffByNip();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Tambah Data Staff</title>
    <link
      rel="shortcut icon"
      href="../assets/img/logoJti.png"
      type="image/x-icon"
    />
    <link
      rel="shortcut icon"
      href="../assets/img/logoJti.png"
      type="image/png"
    />
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
        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo">
                            <a href="../index.php"><img src="../assets/img/logoBetati.png" alt="Logo" srcset=""></a>
                        </div>
                        <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                        role="img" class="iconify iconify--system-uicons" width="20" height="20"
                        preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                        <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path
                                d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                                opacity=".3"></path>
                            <g transform="translate(-210 -1)">
                                <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                <circle cx="220.5" cy="11.5" r="4"></circle>
                                <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"></path>
                            </g>
                        </g>
                    </svg>
                <div class="form-check form-switch fs-6">
                    <input class="form-check-input  me-0" type="checkbox" id="toggle-dark" style="cursor: pointer">
                    <label class="form-check-label"></label>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                    role="img" class="iconify iconify--mdi" width="20" height="20" preserveAspectRatio="xMidYMid meet"
                    viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                    </path>
                </svg>
            </div>
            <div class="sidebar-toggler  x">
                <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                <li
                    class="sidebar-item  ">
                    <a href="../index.php" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item has-sub">
                    <a href="#" class="sidebar-link">
                    <i class="bi bi-file-earmark-medical-fill"></i>
                    <span>Data Mahasiswa</span>
                    </a>

                    <ul class="submenu">
                    <li class="submenu-item">
                        <a href="FormMahasiswa.php" class="submenu-link"
                        >Tambah Data</a>
                    </li>
                    <li class="submenu-item">
                        <a href="TabelMahasiswa.php" class="submenu-link"
                        >Lihat Data</a>
                    </li>
                    </ul>
                </li>

                <li class="sidebar-item active has-sub">
                    <a href="#" class="sidebar-link">
                    <i class="bi bi-file-earmark-medical-fill"></i>
                    <span>Data Staff</span>
                    </a>

                    <ul class="submenu active">
                        <li class="submenu-item active">
                        <a href="FormStaff.php" class="submenu-link"
                            >Tambah Data</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="TabelStaff.php" class="submenu-link"
                        >Lihat Data</a>
                        </li>
                    </ul>
                </li>

                <li
                class="sidebar-item  has-sub">
                <a href="#" class='sidebar-link'>
                    <i class="bi bi-person-circle"></i>
                    <span>Akun</span>
                </a>
                
                <ul class="submenu ">
                    <li class="submenu-item  ">
                        <a href="admin/profilAdmin.php" class="submenu-link">Profil Saya</a>
                    </li>
                    <li class="submenu-item  ">
                        <a href="admin/ubahPassword.php" class="submenu-link">Keamanan</a>
                    </li>                    
                    <li class="submenu-item  ">
                        <a href="../Login/Logout.php" class="submenu-link">Logout</a>
                    </li>                    
                </ul>  

            </li>

            </ul>
        </div>
        </div>
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
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>Tambah Data Staff</h3>
                            <p class="text-subtitle text-muted">Tambahkan data staff</p>
                        </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav
                    aria-label="breadcrumb"
                    class="breadcrumb-header float-start float-lg-end"
                    >
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                            <a href="../index.php">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                            Tambah Data Staff
                            </li>
                        </ol>
                    </nav>
                    </div>
                </div>
            </div>
            
            <div class="page-heading">
                <section id="basic-vertical-layouts">
                    <div class="row match-height">
                        <div class="col-md-6 col-12">
                            <div class="card" style="width: 1280px; height: 100%; margin-left:5px">
                                <div class="card-header">
                                    <h4 class="card-title">Tambah Data Staff</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form form-vertical" action="UserProses.php" method="POST" enctype="multipart/form-data">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="NIP">NIP</label>
                                                            <input type="text" class="form-control" value="<?= isset($nip) ? htmlspecialchars($nip) : '' ?>" name="NIP" placeholder="Masukkan NIP">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="Nama">Nama</label>
                                                            <input type="text" class="form-control" value="<?= isset($nama) ? htmlspecialchars($nama) : '' ?>" name="Nama" placeholder="Masukkan Nama">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="Username">Username</label>
                                                            <input type="text" class="form-control" value="<?= isset($username) ? htmlspecialchars($username) : '' ?>" name="Username" placeholder="Masukkan Nama">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="Email">Email</label>
                                                            <input type="email" class="form-control" value="<?= isset($email) ? htmlspecialchars($email) : '' ?>" name="Email" placeholder="Masukkan Email">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="Password">Password</label>
                                                            <input type="password" class="form-control" name="Password" placeholder="Masukkan Password">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="Alamat">Alamat</label>
                                                            <textarea class="form-control" name="Alamat" rows="3"><?= isset($alamat) ? htmlspecialchars($alamat) : '' ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="NoHp">No.Hp</label>
                                                            <input type="text" class="form-control" value="<?= isset($noHp) ? htmlspecialchars($noHp) : '' ?>" name="NoHp" placeholder="Masukkan No Hp">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="JenisKelamin">Jenis Kelamin</label>
                                                            <br>
                                                            <input class="form-check-input" type="radio" name="JenisKelamin" id="jenkel1" value="L" required="true" 
                                                                <?= (isset($jeniskelamin) && $jeniskelamin === 'L') ? 'checked' : '' ?>> Laki-laki 
                                                                <input class="form-check-input" type="radio" name="JenisKelamin" id="jenkel2" value="P" 
                                                                <?= (isset($jeniskelamin) && $jeniskelamin === 'P') ? 'checked' : '' ?>> Perempuan
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="Tempat_Lahir">Tempat Lahir</label>
                                                            <input type="text" class="form-control" value="<?= isset($Tempat_Lahir) ? htmlspecialchars($Tempat_Lahir) : '' ?>" name="Tempat_Lahir" placeholder="Masukkan Tempat Lahir"> 
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="Tanggal_Lahir">Tanggal Lahir</label>
                                                            <input type="date" class="form-control flatpickr-always-open" name="Tanggal_Lahir" value="<?= isset($Tanggal_Lahir) ? htmlspecialchars($Tanggal_Lahir instanceof DateTime ? $Tanggal_Lahir->format('Y-m-d') : (new DateTime($Tanggal_Lahir))->format('Y-m-d')) : '' ?>" placeholder="Select date..">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="Role_ID">Role</label>
                                                            <select class="form-select" name="Role_ID" id="basicSelect">
                                                                <option value="">-- Pilih Role --</option>
                                                            <?php 
                                                                include('../Koneksi.php');
                                                                $sql = "SELECT Role_ID, Nama_Role FROM Role";
                                                                $stmt = sqlsrv_query($conn, $sql);
                                                                
                                                                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                                                    $selected = ($row["Role_ID"] == $roleID) ? 'selected' : '';
                                                                    echo '<option value="' . $row["Role_ID"] . '" ' . $selected . '>' . $row["Nama_Role"] . '</option>';
                                                                }
                                                            ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group">
                                                            <br>
                                                            <label for="TTD">Tanda Tangan</label>
                                                            <br>
                                                            <div class="card">
                                                                <div class="card-content">
                                                                    <div class="card-body">
                                                                        <!-- File uploader with image preview -->
                                                                        <input type="file" class="image-preview-filepond" accept="image/*"
                                                                        data-max-file-size="10MB" name="TTD" data-max-files="1">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                            <!-- <input type="file" class="image-preview-filepond" accept="image/*"
                                                            data-max-file-size="10MB" name="TTD" data-max-files="1"> -->
                                                        </div>
                                                    <div class="col-12 d-flex justify-content-end">
                                                        <button type="submit" class="btn btn-primary me-1 mb-1" name="simpanStaff">Simpan</button>
                                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">Kembali</button>
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
                        <p>Crafted with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                            by <a href="https://github.com/rafiody16/PBL_BebasTanggungan">Kelompok 1</a></p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="../assets/static/js/components/dark.js"></script>
    <script src="../assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
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
</body>
</html>