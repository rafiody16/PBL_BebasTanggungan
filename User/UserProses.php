<?php 


include "../Koneksi.php";

if (isset($_POST['simpanStaff'])) {
    $NIP = $_POST['NIP'];
    $Nama = $_POST['Nama'];
    $Username = $_POST['Username'];
    $Email = $_POST['Email'];
    $Password = password_hash($_POST['Password'], PASSWORD_BCRYPT); // Enkripsi password
    $Jabatan = $_POST['Jabatan'];
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

        // Debugging
        echo "ID_User yang diambil: " . $newUserID;

        // Masukkan data ke tabel Staff
        $sqlStaff = "INSERT INTO Staff (NIP, Nama, Jabatan, NoHp, ID_User) VALUES (?, ?, ?, ?, ?)";
        $paramsStaff = [$NIP, $Nama, $Jabatan, $NoHp, $newUserID];
        $stmtStaff = sqlsrv_query($conn, $sqlStaff, $paramsStaff);

        if (!$stmtStaff) {
            throw new Exception('Gagal menyimpan data Staff: ' . print_r(sqlsrv_errors(), true));
        }

        sqlsrv_commit($conn);
        echo "Data berhasil disimpan.";

    } catch (Exception $e) {
        sqlsrv_rollback($conn);
        echo "Terjadi kesalahan: " . $e->getMessage();
    }
}


// $sql = "SELECT u.ID_User, u.Username, u.Password, u.Email, r.Nama_Role FROM [User] as u INNER JOIN [Role] as r
//         ON u.Role_ID = r.Role_ID";
// $stmt = sqlsrv_query($conn, $sql);

// if ($stmt === false) {
//     die(print_r(sqlsrv_errors(), true));
// }

?>
