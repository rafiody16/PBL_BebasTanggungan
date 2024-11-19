<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/usercss.css">
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" rel="stylesheet"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
</head>
<body>
    <div class="card">
        <h3 class="card-title mb-4">Tambah User</h3>
        <form action="UserProses.php" method="POST">
            <div class="row mb-3">
                <div class="col">
                    <label for="ID_User" class="form-label">ID User<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="ID_User">
                </div>
                <div class="col">
                    <label for="Username" class="form-label">Username<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="Username" placeholder="Masukkan Username">
                </div>
            </div>
            <div class="mb-3">
                <label for="Email" class="form-label">Email<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="Email" placeholder="Masukkan Email">
            </div>
            <div class="mb-3">
                <label for="Password" class="form-label">Password<span class="text-danger">*</span></label>
                <input type="password" class="form-control" name="Password" placeholder="Masukkan Password">
            </div>
            <div class="mb-3">
                <label for="Role_ID" class="form-label">Role<span class="text-danger">*</span></label>
                <select class="form-select" aria-label="Default select example" name="Role_ID">
                    <option selected>Pilih Role</option>
                    <?php 
                         include '../Koneksi.php';
                         $sql = "SELECT Role_ID, Nama_Role FROM [ROLE];";
                         $params = array();
                         $stmt = sqlsrv_query($conn, $sql, $params);
    
                         while ($rec = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                            if ($rec !== null) {
                                ?>
                                <option value="<?= htmlspecialchars($rec['Role_ID']) ?>"><?= htmlspecialchars($rec['Nama_Role']) ?></option>
                                <?php
                            }
                        }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="simpanUser">Input</button>
        </form>
    </div>
</body>
</html>