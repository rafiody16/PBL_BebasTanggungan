<?php 


include "../Koneksi.php";

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'delete':
        deleteDataStaff();
        break;
    case 'edit':
        getDataStaffByNip();
        break;
    case 'editMahasiswa':
        getDataMahasiswaByNim();
        break;
    case 'deleteMahasiswa':
        deleteDataMahasiswa();
        break;
    case 'readMahasiswa':
        getDataMahasiswaByNim();
        break;
    case 'read':
        getDataStaffByNip();
        break;  
    default:
        # code...
        break;
}

if (isset($_POST['simpanStaff'])) {
    $NIP = $_POST['NIP'];
    $Nama = $_POST['Nama'];
    $Username = $_POST['Username'];
    $Email = $_POST['Email'];
    $Password = password_hash($_POST['Password'], PASSWORD_BCRYPT); // Enkripsi password
    $Alamat = $_POST['Alamat'];
    $NoHp = $_POST['NoHp'];
    $Role_ID = $_POST['Role_ID'];

    // Mulai transaksi
    sqlsrv_begin_transaction($conn);

    try {
        // Cek apakah NIP sudah ada di database
        $checkUserSql = "SELECT ID_User FROM Staff WHERE NIP = ?";
        $checkUserStmt = sqlsrv_query($conn, $checkUserSql, [$NIP]);
        $existingUser = sqlsrv_fetch_array($checkUserStmt, SQLSRV_FETCH_ASSOC);

        if ($existingUser) {
            // Jika ada, update data User dan Staff
            $updateUserSql = "UPDATE [User] SET Username = ?, [Password] = ?, Email = ?, Role_ID = ? WHERE ID_User = (SELECT ID_User FROM Staff WHERE NIP = ?)";
            $paramsUserUpdate = [$Username, $Password, $Email, $Role_ID, $NIP];
            $stmtUserUpdate = sqlsrv_query($conn, $updateUserSql, $paramsUserUpdate);

            if (!$stmtUserUpdate) {
                throw new Exception('Gagal memperbarui data User: ' . print_r(sqlsrv_errors(), true));
            }

            $updateStaffSql = "UPDATE Staff SET Nama = ?, Alamat = ?, NoHp = ? WHERE NIP = ?";
            $paramsStaffUpdate = [$Nama, $Alamat, $NoHp, $NIP];
            $stmtStaffUpdate = sqlsrv_query($conn, $updateStaffSql, $paramsStaffUpdate);

            if (!$stmtStaffUpdate) {
                throw new Exception('Gagal memperbarui data Staff: ' . print_r(sqlsrv_errors(), true));
            }
        } else {
            // Jika tidak ada, lakukan insert
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

            $sqlStaff = "INSERT INTO Staff (NIP, Nama, Alamat, NoHp, ID_User) VALUES (?, ?, ?, ?, ?)";
            $paramsStaff = [$NIP, $Nama, $Alamat, $NoHp, $newUserID];
            $stmtStaff = sqlsrv_query($conn, $sqlStaff, $paramsStaff);

            if (!$stmtStaff) {
                throw new Exception('Gagal menyimpan data Staff: ' . print_r(sqlsrv_errors(), true));
            }
        }

        // Commit transaksi jika tidak ada error
        sqlsrv_commit($conn);
        echo "<script>alert('Data berhasil disimpan!'); window.location.href = 'TabelStaff.php';</script>";
    } catch (Exception $e) {
        sqlsrv_rollback($conn);
        echo "<script>alert('Data gagal disimpan! ".$e->getMessage() .  "'); window.location.href = 'TabelStaff.php';</script>";
    }
}

if (isset($_POST['simpanMahasiswa'])) {
    $NIM = $_POST['NIM'];
    $Nama = $_POST['Nama'];
    $Username = $_POST['Username'];
    $Email = $_POST['Email'];
    $Password = password_hash($_POST['Password'], PASSWORD_BCRYPT); // Enkripsi password
    $Alamat = $_POST['Alamat'];
    $NoHp = $_POST['NoHp'];
    $JenisKelamin = $_POST['JenisKelamin'];
    $Role_ID = 5;

    // Mulai transaksi
    sqlsrv_begin_transaction($conn);
    try {
        $sqlUser = "INSERT INTO [User] (Username, [Password], Email, Role_ID) 
                    OUTPUT INSERTED.ID_User 
                    VALUES (?, ?, ?, ?)";
        $paramsUser = [$Username, $Password, $Email, $Role_ID];
        $stmtUser = sqlsrv_query($conn, $sqlUser, $paramsUser);
    
        if (!$stmtUser) {
            throw new Exception('Error in User query: ' . print_r(sqlsrv_errors(), true));
        }
    
        $rowUserID = sqlsrv_fetch_array($stmtUser, SQLSRV_FETCH_ASSOC);
        if (!$rowUserID) {
            throw new Exception('No rows returned from User insert: ' . print_r(sqlsrv_errors(), true));
        }
        $newUserID = $rowUserID['ID_User'];
    
        $sqlMahasiswa = "INSERT INTO Mahasiswa (NIM, Nama, Alamat, NoHp, JenisKelamin, ID_User) 
                         VALUES (?, ?, ?, ?, ?, ?)";
        $paramsMahasiswa = [$NIM, $Nama, $Alamat, $NoHp, $JenisKelamin, $newUserID];
        $stmtMahasiswa = sqlsrv_query($conn, $sqlMahasiswa, $paramsMahasiswa);
    
        if (!$stmtMahasiswa) {
            throw new Exception('Error in Mahasiswa query: ' . print_r(sqlsrv_errors(), true));
        }
    
        // Commit the transaction if all queries succeed
        sqlsrv_commit($conn);
        echo "<script>alert('Data berhasil disimpan!'); window.location.href = 'TabelMahasiswa.php';</script>";
    
    } catch (Exception $e) {
        sqlsrv_rollback($conn);
        die('Transaction failed: ' . $e->getMessage());
    }
    
}

function deleteDataStaff() {
    global $conn;

    $NIP = $_POST['NIP'];

    sqlsrv_begin_transaction($conn);

    try {
        $checkUserSql = "SELECT ID_User FROM Staff WHERE NIP = ?";
        $checkUserStmt = sqlsrv_query($conn, $checkUserSql, [$NIP]);
        $existingUser = sqlsrv_fetch_array($checkUserStmt, SQLSRV_FETCH_ASSOC);

        if ($existingUser) {
            $ID_User = $existingUser['ID_User'];

            $deleteStaffSql = "DELETE FROM Staff WHERE NIP = ?";
            $stmtDeleteStaff = sqlsrv_query($conn, $deleteStaffSql, [$NIP]);

            if (!$stmtDeleteStaff) {
                throw new Exception('Gagal menghapus data Staff: ' . print_r(sqlsrv_errors(), true));
            }

            $deleteUserSql = "DELETE FROM [User] WHERE ID_User = ?";
            $stmtDeleteUser = sqlsrv_query($conn, $deleteUserSql, [$ID_User]);

            if (!$stmtDeleteUser) {
                throw new Exception('Gagal menghapus data User: ' . print_r(sqlsrv_errors(), true));
            }

            sqlsrv_commit($conn);
            echo "<script>alert('Data berhasil dihapus!'); window.location.href = 'TabelStaff.php';</script>";
        } else {
            throw new Exception('Data Staff dengan NIP tersebut tidak ditemukan.');
        }
    } catch (Exception $e) {
        sqlsrv_rollback($conn);
        echo "<script>alert('Data gagal dihapus! ".$e->getMessage() . "'); window.location.href = 'TabelStaff.php';</script>";
    }
}

function deleteDataMahasiswa() {
    global $conn;

    $NIM = $_POST['NIM'];

    sqlsrv_begin_transaction($conn);

    try {
        $checkUserSql = "SELECT ID_User FROM Mahasiswa WHERE NIM = ?";
        $checkUserStmt = sqlsrv_query($conn, $checkUserSql, [$NIM]);
        $existingUser = sqlsrv_fetch_array($checkUserStmt, SQLSRV_FETCH_ASSOC);

        if ($existingUser) {
            $ID_User = $existingUser['ID_User'];

            $deleteMahasiswaSql = "DELETE FROM Mahasiswa WHERE NIM = ?";
            $stmtDeleteMahasiswa = sqlsrv_query($conn, $deleteMahasiswaSql, [$NIM]);

            if (!$stmtDeleteMahasiswa) {
                throw new Exception('Gagal menghapus data Mahasiswa: ' . print_r(sqlsrv_errors(), true));
            }

            $deleteUserSql = "DELETE FROM [User] WHERE ID_User = ?";
            $stmtDeleteUser = sqlsrv_query($conn, $deleteUserSql, [$ID_User]);

            if (!$stmtDeleteUser) {
                throw new Exception('Gagal menghapus data User: ' . print_r(sqlsrv_errors(), true));
            }

            sqlsrv_commit($conn);
            echo "<script>alert('Data berhasil dihapus!'); window.location.href = 'TabelMahasiswa.php';</script>";
        } else {
            throw new Exception('Data Mahasiswa dengan NIM tersebut tidak ditemukan.');
        }
    } catch (Exception $e) {
        sqlsrv_rollback($conn);
        echo "<script>alert('Data gagal dihapus! ".$e->getMessage() . "'); window.location.href = 'TabelMahasiswa.php';</script>";
    }
}

function getDataMahasiswaByNim() {
    global $conn;
    global $nim, $nama, $username, $email, $alamat, $noHp, $jeniskelamin;
    $nim = $_GET['NIM'];
    $sql = "SELECT Mahasiswa.Nama, Mahasiswa.Alamat, Mahasiswa.NoHp, [User].Username, [User].Email, Mahasiswa.JenisKelamin FROM Mahasiswa INNER JOIN [User] ON Mahasiswa.ID_User = [User].ID_User  WHERE Mahasiswa.NIM = ?";
    $params = array($nim);
    $stmt = sqlsrv_query($conn, $sql, $params);
    
    if ($stmt === false) {
        echo "Query failed: ";
        print_r(sqlsrv_errors());
        exit;
    }
    
    if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        // Populate the form fields with existing data
        $nama = $row['Nama'];
        $username = $row['Username'];
        $email = $row['Email'];
        $alamat = $row['Alamat'];
        $noHp = $row['NoHp'];
        $jeniskelamin = $row['JenisKelamin'];
    } else {
        echo "No data found for the given NIM.";
    }
}

function getDataStaffByNip() {
    global $conn;
    global $nip, $nama, $username, $email, $alamat, $noHp, $roleID, $Nama_Role;
    $nip = $_GET['NIP'];
    $sql = "SELECT Staff.Nama, Staff.Alamat, Staff.NoHp, [User].Username, [User].Email, [User].Role_ID, [Role].Nama_Role FROM Staff INNER JOIN [User] ON Staff.ID_User = [User].ID_User  INNER JOIN [Role] ON [User].Role_ID = [Role].Role_ID WHERE Staff.NIP = ?";
    $params = array($nip);
    $stmt = sqlsrv_query($conn, $sql, $params);
    
    if ($stmt === false) {
        echo "Query failed: ";
        print_r(sqlsrv_errors());
        exit;
    }
    
    if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        // Populate the form fields with existing data
        $nama = $row['Nama'];
        $username = $row['Username'];
        $email = $row['Email'];
        $alamat = $row['Alamat'];
        $noHp = $row['NoHp'];
        $roleID = $row['Role_ID'];
        $Nama_Role = $row['Nama_Role'];
    } else {
        echo "No data found for the given NIP.";
    }
}

$sql = "SELECT s.NIP, s.Nama, r.Nama_Role, u.Email, s.NoHp FROM Staff AS s
        INNER JOIN [User] AS u ON s.ID_User = u.ID_User INNER JOIN Role AS r ON u.Role_ID = r.Role_ID";
$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$sql2 = "SELECT m.NIM, m.Nama, m.JenisKelamin, u.Email, m.Alamat, m.NoHp FROM Mahasiswa AS m
        INNER JOIN [User] AS u ON m.ID_User = u.ID_User INNER JOIN Role AS r ON u.Role_ID = r.Role_ID";
$stmt2 = sqlsrv_query($conn, $sql2);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

?>
