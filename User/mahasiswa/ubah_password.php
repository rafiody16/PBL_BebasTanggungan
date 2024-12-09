<?php
include '../../Koneksi.php';

session_start();

class User {
    private $conn;
    private $userId;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->userId = $_SESSION['ID_User'];
    }

    public function changePassword($oldPassword, $newPassword, $confirmPassword) {
        if ($newPassword !== $confirmPassword) {
            return "Password baru dan konfirmasi password tidak cocok.";
        }

        // Query untuk mendapatkan password lama berdasarkan ID_User
        $query = "SELECT password FROM [User ] WHERE ID_User = ?";
        $stmt = sqlsrv_prepare($this->conn, $query, array(&$this->userId));
        
        if (sqlsrv_execute($stmt)) {
            $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
            
            // Cek apakah password lama cocok
            if (password_verify($oldPassword, $row['password'])) {
                // Enkripsi password baru
                $newPasswordHash = password_hash($newPassword, PASSWORD_BCRYPT);

                // Query untuk mengupdate password
                $updateQuery = "UPDATE [User ] SET password = ? WHERE ID_User = ?";
                $updateStmt = sqlsrv_prepare($this->conn, $updateQuery, array(&$newPasswordHash, &$this->userId));

                if (sqlsrv_execute($updateStmt)) {
                    return "Password berhasil diubah.";
                } else {
                    return "Gagal mengubah password.";
                }
            } else {
                return "Password lama salah.";
            }
        } else {
            return "Terjadi kesalahan saat memeriksa password.";
        }
    }
}

// Cek apakah pengguna sudah login
if (!isset($_SESSION['ID_User'])) {
    die("Anda harus login terlebih dahulu.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $oldPassword = $_POST['current_password'];
    $newPassword = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Buat objek User
    $user = new User($conn);
    $message = $user->changePassword($oldPassword, $newPassword, $confirmPassword);

    echo "<script>alert('$message'); window.location.href = 'ubahPasswordMhs.html'; </script>";
}
?>