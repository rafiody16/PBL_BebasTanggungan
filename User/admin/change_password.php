<?php
// Include file koneksi database
include '../../Koneksi.php';

session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['ID_User'])) {
    die("Anda harus login terlebih dahulu.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $oldPassword = $_POST['current_password'];
    $newPassword = $_POST['password'];

    // Ambil ID_User dari session
    $userId = $_SESSION['ID_User'];

    // Query untuk mendapatkan password lama berdasarkan ID_User
    $query = "SELECT password FROM [User] WHERE ID_User = ?";
    $stmt = sqlsrv_prepare($conn, $query, array(&$userId));
    
    if (sqlsrv_execute($stmt)) {
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        
        // Cek apakah password lama cocok
        if (password_verify($oldPassword, $row['password'])) {
            // Enkripsi password baru
            $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

            // Query untuk mengupdate password
            $updateQuery = "UPDATE [User] SET password = ? WHERE ID_User = ?";
            $updateStmt = sqlsrv_prepare($conn, $updateQuery, array(&$newPasswordHash, &$userId));

            if (sqlsrv_execute($updateStmt)) {
                echo "Password berhasil diubah.";
            } else {
                echo "Gagal mengubah password.";
            }
        } else {
            echo "Password lama salah.";
        }
    } else {
        echo "Terjadi kesalahan saat memeriksa password.";
    }
}
?>
