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
 
            // Redirect berdasarkan Role_ID
            switch ($row['Role_ID']) {
                case 1:
                    echo "<script>alert('Selamat Datang Admin ".$Username.".'); window.location.href = '../index.php'; </script>";
                    $sqlVrf = "SELECT Nama FROM Staff WHERE ID_User = ?";
                    $paramsVrf = array($row['ID_User']);
                    $stmtVrf = sqlsrv_query($conn, $sqlVrf, $paramsVrf);

                    if ($stmtVrf === false) {
                        die(print_r(sqlsrv_errors(), true));
                    }

                    if ($rowVrf = sqlsrv_fetch_array($stmtVrf, SQLSRV_FETCH_ASSOC)) {
                        $_SESSION['NIP'] = $rowVrf['NIP'];
                        $_SESSION['Nama'] = $rowVrf['Nama'];
                    }

                    sqlsrv_free_stmt($stmtVrf);
                    break;
                case 2:
                    echo "<script>alert('Selamat Datang Kepala Jurusan TI ".$Username.".'); window.location.href = '../Dosen/dashboardDosen.html'; </script>";
                    $sqlVrf = "SELECT Nama FROM Staff WHERE ID_User = ?";
                    $paramsVrf = array($row['ID_User']);
                    $stmtVrf = sqlsrv_query($conn, $sqlVrf, $paramsVrf);

                    if ($stmtVrf === false) {
                        die(print_r(sqlsrv_errors(), true));
                    }

                    if ($rowVrf = sqlsrv_fetch_array($stmtVrf, SQLSRV_FETCH_ASSOC)) {
                        $_SESSION['NIP'] = $rowVrf['NIP'];
                        $_SESSION['Nama'] = $rowVrf['Nama'];
                    }
                    break;
                case 3:
                    echo "<script>alert('Selamat Datang Kaprodi TI ".$Username.".'); window.location.href = '../User/mahasiswa/dashboardUser.html'; </script>";
                    $sqlVrf = "SELECT Nama FROM Staff WHERE ID_User = ?";
                    $paramsVrf = array($row['ID_User']);
                    $stmtVrf = sqlsrv_query($conn, $sqlVrf, $paramsVrf);

                    if ($stmtVrf === false) {
                        die(print_r(sqlsrv_errors(), true));
                    }

                    if ($rowVrf = sqlsrv_fetch_array($stmtVrf, SQLSRV_FETCH_ASSOC)) {
                        $_SESSION['NIP'] = $rowVrf['NIP'];
                        $_SESSION['Nama'] = $rowVrf['Nama'];
                    }
                    break;
                case 4:
                    echo "<script>alert('Selamat Datang Kaprodi SIB ".$Username.".'); window.location.href = '../Role4/dashboardRole4.html'; </script>";
                    $sqlVrf = "SELECT Nama FROM Staff WHERE ID_User = ?";
                    $paramsVrf = array($row['ID_User']);
                    $stmtVrf = sqlsrv_query($conn, $sqlVrf, $paramsVrf);

                    if ($stmtVrf === false) {
                        die(print_r(sqlsrv_errors(), true));
                    }

                    if ($rowVrf = sqlsrv_fetch_array($stmtVrf, SQLSRV_FETCH_ASSOC)) {
                        $_SESSION['NIP'] = $rowVrf['NIP'];
                        $_SESSION['Nama'] = $rowVrf['Nama'];
                    }
                    break;
                case 5:
                    echo "<script>alert('Selamat Datang Kaprodi PPLS ".$Username.".'); window.location.href = '../Role4/dashboardRole4.html'; </script>";
                    $sqlVrf = "SELECT Nama FROM Staff WHERE ID_User = ?";
                    $paramsVrf = array($row['ID_User']);
                    $stmtVrf = sqlsrv_query($conn, $sqlVrf, $paramsVrf);

                    if ($stmtVrf === false) {
                        die(print_r(sqlsrv_errors(), true));
                    }

                    if ($rowVrf = sqlsrv_fetch_array($stmtVrf, SQLSRV_FETCH_ASSOC)) {
                        $_SESSION['NIP'] = $rowVrf['NIP'];
                        $_SESSION['Nama'] = $rowVrf['Nama'];
                    }
                    break;
                case 6:
                    echo "<script>alert('Selamat Datang Admin TA ".$Username.".'); window.location.href = '../Role4/dashboardRole4.html'; </script>";
                    $sqlVrf = "SELECT Nama FROM Staff WHERE ID_User = ?";
                    $paramsVrf = array($row['ID_User']);
                    $stmtVrf = sqlsrv_query($conn, $sqlVrf, $paramsVrf);

                    if ($stmtVrf === false) {
                        die(print_r(sqlsrv_errors(), true));
                    }

                    if ($rowVrf = sqlsrv_fetch_array($stmtVrf, SQLSRV_FETCH_ASSOC)) {
                        $_SESSION['NIP'] = $rowVrf['NIP'];
                        $_SESSION['Nama'] = $rowVrf['Nama'];
                    }
                    break;
                case 7:
                    echo "<script>alert('Selamat Datang Admin Jurusan ".$Username.".'); window.location.href = '../Role4/dashboardRole4.html'; </script>";
                    $sqlVrf = "SELECT Nama FROM Staff WHERE ID_User = ?";
                    $paramsVrf = array($row['ID_User']);
                    $stmtVrf = sqlsrv_query($conn, $sqlVrf, $paramsVrf);

                    if ($stmtVrf === false) {
                        die(print_r(sqlsrv_errors(), true));
                    }

                    if ($rowVrf = sqlsrv_fetch_array($stmtVrf, SQLSRV_FETCH_ASSOC)) {
                        $_SESSION['NIP'] = $rowVrf['NIP'];
                        $_SESSION['Nama'] = $rowVrf['Nama'];
                    }
                    break;
                case 8:
                    echo "<script>alert('Selamat Datang Mahasiswa ".$Username.".'); window.location.href = '../User/mahasiswa/dashboardMHS.php'; </script>";
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
                    break;
                default:
                    echo "<script>alert('Role tidak dikenali.'); window.location.href = 'Login.php'; </script>";
                    break;
            }
        } else {
            echo "<script>alert('Username atau password salah.'); window.location.href = 'Login.php'; </script>";
        }
    } else {
        echo "<script>alert('Username atau password salah.'); window.location.href = 'Login.php'; </script>";
    }

    sqlsrv_free_stmt($stmt);
}

sqlsrv_close($conn);

?>