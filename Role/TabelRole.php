<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel Role</title>
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
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>Tabel Role</h3>
                            <p class="text-subtitle text-muted">Data Role.</p>
                        </div>
                    </div>
                </div>
                <section class="section">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Tabel Role</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-lg">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>ID Role</th>
                                                    <th>Nama Role</th>
                                                    <th>Deskripsi</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                                include('RoleProses.php');
                                                $no = 1;
                                                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                                    $Role_ID = $row['Role_ID'];
                                                    if ($row != null) {
                                                        echo "<tr>";
                                                        echo "<td>" . htmlspecialchars($no++) . "</td>";
                                                        echo "<td>" . htmlspecialchars($Role_ID) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['Nama_Role']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['Deskripsi']) . "</td>";
                                                        ?>
                                                        <td><button data-id="<?= $Role_ID ?>" class="btn btn-warning btn-edit">Edit</button></td>
                                                        <td><button data-id="<?= $Role_ID ?>" class="btn btn-danger btn-delete">Hapus</button></td>
                                                <?php
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
            $(".btn-edit").click(function() {
                var Role_ID = $(this).data("id");
                $.ajax({
                    url: "FormRole.php",
                    type: "POST",
                    data: { Role_ID: Role_ID, action: "edit" },
                    success: function(response) {
                        location.href = "FormRole.php?Role_ID=" + Role_ID;
                    }
                })
            });

            $(".btn-delete").click(function() {
                var Role_ID = $(this).data("id");
                if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                    $.ajax({
                        url: "RoleProses.php",
                        type: "POST",
                        data: { Role_ID: Role_ID, action: "delete" },
                        success: function(response) {
                            alert(Role_ID);
                            location.reload();
                        }
                    });
                }
            });

            // Tutup modal
            $("#modalClose").click(function() {
                $("#modal").hide();
            });
        });
    </script>
    <script src="../assets/static/js/components/dark.js"></script>
    <script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/compiled/js/app.js"></script>
</body>

</html>