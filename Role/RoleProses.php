<?php 

include "../Koneksi.php";

if (isset($_POST['simpanRole'])) {
    $Role_ID = $_POST['Role_ID'];
    $Nama_Role = $_POST['Nama_Role'] ?? null;
    $Deskripsi = $_POST['Deskripsi'] ?? null;

    try {
        $checkUserSql = "SELECT Role_ID FROM [Role] WHERE Role_ID = ?";
        $checkUserStmt = sqlsrv_query($conn, $checkUserSql, [$Role_ID]);
        $existingUser = sqlsrv_fetch_array($checkUserStmt, SQLSRV_FETCH_ASSOC);

        if ($existingUser) {
            $sql = "UPDATE [Role] SET Role_ID = ?, Nama_Role = ?, Deskripsi = ? WHERE Role_ID = ?";
            $params = array($Role_ID, $Nama_Role, $Deskripsi, $Role_ID);
            $input = sqlsrv_query($conn, $sql, $params);

            if ($input === false) {
                die(print_r(sqlsrv_errors(), true));
            }
        
            if ($input) {
                echo "<script>alert('Data successfully saved.'); window.location.href = 'TabelRole.php';</script>";
            } else {
                echo "<script>alert('Data saving failed.'); window.location.href = 'FormRole.php';</script>";
            }
        } else {
            $sql = "INSERT INTO Role (Role_ID, Nama_Role, Deskripsi) VALUES (?,?, ?)";
            $params = array($Role_ID, $Nama_Role, $Deskripsi);
            $input = sqlsrv_query($conn, $sql, $params);

            if ($input === false) {
                die(print_r(sqlsrv_errors(), true));
            }
        
            if ($input) {
                echo "<script>alert('Data successfully saved.'); window.location.href = 'TabelRole.php';</script>";
            } else {
                echo "<script>alert('Data saving failed.'); window.location.href = 'FormRole.php';</script>";
            }
        }
    } catch (Exception $e) {
        sqlsrv_rollback($conn);
        echo "<script>alert('Data gagal diubah! ".$e->getMessage() . "'); window.location.href = 'TabelRole.php';</script>";
    }
}

function getRoleById() {
    global $conn;
    global $Role_ID, $nama, $deskripsi;
    $Role_ID = $_GET['Role_ID'] ?? null;
    $sql = "SELECT * FROM [Role] WHERE Role_ID = ?";
    $params = array($Role_ID);
    $stmt = sqlsrv_query($conn, $sql, $params);
    
    if ($stmt === false) {
        echo "Query failed: ";
        print_r(sqlsrv_errors());
        exit;
    }
    
    if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $Role_ID = $row['Role_ID'];
        $nama = $row['Nama_Role'];
        $deskripsi = $row['Deskripsi'];
    } else {
        echo "No data found for the given NIP.";
    }
}

function deleteRole() {
    global $conn;

    $Role_ID = $_POST['Role_ID'];

    sqlsrv_begin_transaction($conn);

    try {
        $checkUserSql = "SELECT Role_ID FROM [Role] WHERE Role_ID = ?";
        $checkUserStmt = sqlsrv_query($conn, $checkUserSql, [$Role_ID]);
        $existingUser = sqlsrv_fetch_array($checkUserStmt, SQLSRV_FETCH_ASSOC);

        if ($existingUser) {
            $deleteMahasiswaSql = "DELETE FROM [Role] WHERE Role_ID = ?";
            $stmtDeleteMahasiswa = sqlsrv_query($conn, $deleteMahasiswaSql, [$Role_ID]);

            if (!$stmtDeleteMahasiswa) {
                throw new Exception('Gagal menghapus data Mahasiswa: ' . print_r(sqlsrv_errors(), true));
            }

            sqlsrv_commit($conn);
            echo "<script>alert('Data berhasil dihapus!'); window.location.href = 'TabelRole.php';</script>";
        } else {
            throw new Exception('Data Mahasiswa dengan NIM tersebut tidak ditemukan.');
        }
    } catch (Exception $e) {
        sqlsrv_rollback($conn);
        echo "<script>alert('Data gagal dihapus! ".$e->getMessage() . "'); window.location.href = 'TabelMahasiswa.php';</script>";
    }
}



$sql = "SELECT * FROM [Role]";
$stmt = sqlsrv_query($conn, $sql);

// Check if query was successful
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

?>
