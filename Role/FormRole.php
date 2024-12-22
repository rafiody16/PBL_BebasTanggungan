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
    <title>Checkout Page - Mazer Admin Dashboard</title>
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
    <link rel="stylesheet" crossorigin href="../assets/compiled/css/app.css">
    <link rel="stylesheet" crossorigin href="../assets/compiled/css/app-dark.css">
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
                <section id="basic-vertical-layouts">
                    <div class="row match-height">
                        <div class="col-md-6 col-12">
                            <div class="card" style="width: 1280px; margin-left:30px">
                                <div class="card-header">
                                    <h4 class="card-title">Tambah Data Role</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form form-vertical" method="POST">
                                            <?php 
                                                require_once '../Koneksi.php';
                                                require_once '../Models/Role.php';
                                                
                                                $db = new Database();
                                                $conn = $db->getConnection();
                                                $roleModel = new Role($conn);
                                                
                                                $id = isset($_GET['Role_ID']) ? $_GET['Role_ID'] : '';
                                                $rl = null;
                                                
                                                if ($id) {
                                                    $rl = $roleModel->findById($id);
                                                }
                                            ?>
                                            <div class="form-body">
                                                <div class="row">
                                                <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="first-name-vertical">ID Role</label>
                                                            <input type="text" class="form-control" name="Role_ID" value="<?= isset($rl['Role_ID']) ? htmlspecialchars($rl['Role_ID']) : '' ?>" placeholder="Masukkan ID_Role">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="first-name-vertical">Nama Role</label>
                                                            <input type="text" class="form-control" name="Nama_Role" value="<?= isset($rl['Nama_Role']) ? htmlspecialchars($rl['Nama_Role']) : '' ?>" placeholder="Masukkan jenis role">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="contact-info-vertical">Deskripsi</label>
                                                            <textarea class="form-control" name="Deskripsi" rows="3"><?= isset($rl['Deskripsi']) ? htmlspecialchars($rl['Deskripsi']) : '' ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 d-flex justify-content-start">
                                                        <button type="submit" class="btn btn-primary me-1 mb-1" 
                                                            name="<?= empty($rl['Role_ID']) ? 'simpanRole' : 'updateRole' ?>"
                                                            value="<?= empty($rl['Role_ID']) ? 'tambah' : 'update' ?>">
                                                            <?= empty($rl['Role_ID']) ? 'Tambah' : 'Update' ?>
                                                        </button>
                                                        <button class="btn btn-light-secondary me-1 mb-1 btn-kembali">Kembali</button>
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
                        <p>2023 &copy; Mazer</p>
                    </div>
                    <div class="float-end">
                        <p>Crafted with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                            by <a href="https://saugi.me">Saugi</a></p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('form').submit(function(e) {
                e.preventDefault();
            
                var formData = new FormData(this);
            
                var buttonName = $('button[type="submit"]').attr('name');

                if (buttonName === 'updateRole') {
                    var url = '../Controllers/RoleController.php?action=updateRole';
                } else {
                    var url = '../Controllers/RoleController.php?action=createRole';
                }

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        alert(response);
                        location.href="TabelRole.php"; // Memuat ulang halaman setelah submit berhasil
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                        alert('Terjadi kesalahan: ' + error);
                    }
                });
            });
            $(".btn-kembali").click(function() {
                window.history.back();
            });

        });
    </script>
    <script src="../assets/static/js/components/dark.js"></script>
    <script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/compiled/js/app.js"></script>
</body>
</html>