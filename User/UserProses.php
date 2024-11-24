<?php 


include "../Koneksi.php";

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'delete':
        deleteDataStaff($conn);
        break;
    case 'edit':
        editDataStaff();
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

function deleteDataStaff($conn) {
    $nip = $_GET['NIP'];
    $sql = "DELETE FROM Staff WHERE NIP = ?";
    $stmt = sqlsrv_query($conn, $sql, [$nip]);

    if ($stmt) {
        echo "Data berhasil dihapus.";
    } else {
        echo "Gagal menghapus data.";
    }
}


function editDataStaff() {
    global $conn;
    global $nip, $nama, $username, $email, $alamat, $noHp, $roleID;
    $nip = $_GET['NIP'];
    $sql = "SELECT Staff.Nama, Staff.Alamat, Staff.NoHp, [User].Username, [User].Email, [User].Role_ID FROM Staff INNER JOIN [User] ON Staff.ID_User = [User].ID_User WHERE Staff.NIP = ?";
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

?>
