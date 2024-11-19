<?php 


include "../Koneksi.php";

if (isset($_POST['simpanStaff'])) {
    $NIP = $_POST['NIP'];
    $Nama = $_POST['Nama'];
    $Username = $_POST['Username'];
    $Email = $_POST['Email'];
    $Password = password_hash($_POST['Password'], PASSWORD_BCRYPT); // Enkripsi password
    $Alamat = $_POST['Alamat'];
    $NoHp = $_POST['NoHp'];
    $Role_ID = $_POST['Role_ID'];

    sqlsrv_begin_transaction($conn);

    try {
        // Masukkan data ke tabel User dan ambil ID_User yang baru
        $sqlUser = "INSERT INTO [User] (Username, [Password], Email, Role_ID) 
                    OUTPUT INSERTED.ID_User 
                    VALUES (?, ?, ?, ?)";
        $paramsUser = [$Username, $Password, $Email, $Role_ID];
        $stmtUser = sqlsrv_query($conn, $sqlUser, $paramsUser);

        if (!$stmtUser) {
            throw new Exception('Gagal menyimpan data User: ' . print_r(sqlsrv_errors(), true));
        }

        $rowUserID = sqlsrv_fetch_array($stmtUser, SQLSRV_FETCH_ASSOC);
        $newUserID = $rowUserID['ID_User'];

        // Masukkan data ke tabel Staff
        $sqlStaff = "INSERT INTO Staff (NIP, Nama, Alamat, NoHp, ID_User) VALUES (?, ?, ?, ?, ?)";
        $paramsStaff = [$NIP, $Nama, $Alamat, $NoHp, $newUserID];
        $stmtStaff = sqlsrv_query($conn, $sqlStaff, $paramsStaff);

        if (!$stmtStaff) {
            throw new Exception('Gagal menyimpan data Staff: ' . print_r(sqlsrv_errors(), true));
        }

        sqlsrv_commit($conn);
        echo "<script>alert('Data berhasil disimpan!'); window.location.href = 'TabelUser.php';</script>";

    } catch (Exception $e) {
        sqlsrv_rollback($conn);
        echo "<script>alert('Data gagal disimpan! ".$e->getMessage() .  "'); window.location.href = 'TabelUser.php';</script>";
    }
}


$sql = "SELECT s.NIP, s.Nama, r.Nama_Role, u.Email, s.NoHp FROM Staff AS s
        INNER JOIN [User] AS u ON s.ID_User = u.ID_User INNER JOIN Role AS r ON u.Role_ID = r.Role_ID";
$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

?>
