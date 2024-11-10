<?php 

    include "../Koneksi.php";

    // $username = $_POST['username'];
    // $password = md5($_POST['password']);
    // $query = "SELECT * FROM [User] WHERE Username = ? AND Password = ? ";
    // $params = array($username, $password);

    // $result = sqlsrv_query($conn, $query, $params);

    // if ($result === false) {
    //     die(print_r(sqlsrv_errors(), true));
    // }
    
    // if (sqlsrv_has_rows($result)) {
    //     echo "Login Berhasil";
    // } else {
    //     echo "Gagal";
        
    // }

    // sqlsrv_free_stmt($result);
    // sqlsrv_close($conn);

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
            if ($row['Password'] === $Password) {
                // Login berhasil
                $_SESSION['Username'] = $Username;
                echo "<script>alert('Selamat Datang ".$Username.".');  window.location.href = 'FormLogin.php'; </script>";
            } else {
                echo "<script>alert('Username atau password salah.');  window.location.href = 'FormLogin.php'; </script>";
            }
        } else {
            echo "<script>alert('Username atau password salah.');  window.location.href = 'FormLogin.php'; </script>";
        }
    
        sqlsrv_free_stmt($stmt);
    }
    
    sqlsrv_close($conn);

?>