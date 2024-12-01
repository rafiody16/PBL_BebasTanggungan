<?php 

include "../Koneksi.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Username = $_POST['Username'];
    $Password = $_POST['Password'];

    // Query untuk memeriksa pengguna
    $sql = "SELECT * FROM [User] WHERE Username = ?";
    $params = array($Username);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        // Verifikasi password (gunakan password_hash dan password_verify untuk keamanan)
        if (password_verify($Password, $row['Password'])) {
            // Login berhasil
            $_SESSION['Username'] = $Username;
            $_SESSION['Role_ID'] = $row['Role_ID'];
            $_SESSION['ID_User'] = $row['ID_User'];

            // Ambil NIM berdasarkan ID_User
            $sqlNim = "SELECT NIM FROM Mahasiswa WHERE ID_User = ?";
            $paramsNim = array($row['ID_User']);
            $stmtNim = sqlsrv_query($conn, $sqlNim, $paramsNim);

            if ($stmtNim === false) {
                die(print_r(sqlsrv_errors(), true));
            }

            if ($rowNim = sqlsrv_fetch_array($stmtNim, SQLSRV_FETCH_ASSOC)) {
                $_SESSION['NIM'] = $rowNim['NIM'];
            }

            sqlsrv_free_stmt($stmtNim);

            echo "<script>alert('Selamat Datang ".$Username.".'); window.location.href = '../index.php'; </script>";
        } else {
            echo "<script>alert('Username atau password salah.'); window.location.href = 'FormLogin.php'; </script>";
        }
    } else {
        echo "<script>alert('Username atau password salah.'); window.location.href = 'FormLogin.php'; </script>";
    }

    sqlsrv_free_stmt($stmt);
}

sqlsrv_close($conn);

?>
