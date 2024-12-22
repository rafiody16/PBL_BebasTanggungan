<?php 
require_once "../Koneksi.php";
session_start();

class User {
    private $conn;
    private $username;
    private $password;

    public function __construct($conn, $username, $password) {
        $this->conn = $conn;
        $this->username = $username;
        $this->password = $password;
    }

    public function login() {
        $sql = "SELECT * FROM [User ] WHERE Username = ?";
        $params = array($this->username);
        $stmt = sqlsrv_query($this->conn, $sql, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            if (password_verify($this->password, $row['Password'])) {
                $this->setSession($row);
                $this->redirectUser ($row);
            } else {
                $this->alertAndRedirect('Username atau password salah.', 'Login.php');
            }
        } else {
            $this->alertAndRedirect('Username atau password salah.', 'Login.php');
        }

        sqlsrv_free_stmt($stmt);
    }

    private function setSession($row) {
        $_SESSION['Username'] = $this->username;
        $_SESSION['Role_ID'] = $row['Role_ID'];
        $_SESSION['ID_User'] = $row['ID_User'];
        $_SESSION['NIM'] = $row['NIM'];
        $_SESSION['Nama'] = $row['Nama'];

        // Ambil Nama dan NIP dari Staff
        $sqlVrf = "SELECT Nama, NIP FROM Staff WHERE ID_User = ?";
        $paramsVrf = array($row['ID_User']);
        $stmtVrf = sqlsrv_query($this->conn, $sqlVrf, $paramsVrf);

        if ($stmtVrf === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        if ($rowVrf = sqlsrv_fetch_array($stmtVrf, SQLSRV_FETCH_ASSOC)) {
            $_SESSION['NIP'] = $rowVrf['NIP'];
            $_SESSION['Nama'] = $rowVrf['Nama'];
        }

        $sqlVrf2 = "SELECT NIM FROM Mahasiswa WHERE ID_User = ?";
        $paramsVrf2 = array($row['ID_User']);
        $stmtVrf2 = sqlsrv_query($this->conn, $sqlVrf2, $paramsVrf2);

        if ($stmtVrf2 === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        if ($rowVrf2 = sqlsrv_fetch_array($stmtVrf2, SQLSRV_FETCH_ASSOC)) {
            $_SESSION['NIM'] = $rowVrf2['NIM'];
        }

        sqlsrv_free_stmt($stmtVrf);
        sqlsrv_free_stmt($stmtVrf2);
    }

    private function redirectUser ($row) {
        switch ($row['Role_ID']) {
            case 1:
                $this->alertAndRedirect('Selamat Datang Admin ' . $this->username, '../index.php');
                break;
            case 2:
                $this->alertAndRedirect('Selamat Datang Kepala Jurusan Teknologi Informasi ' . $this->username, '../User/kajur/dasborKajur.php');
                break;
            case 3:
                $this->alertAndRedirect('Selamat Datang Kaprodi TI ' . $this->username, '../kaprodiTI.php');
                break;
            case 4:
                $this->alertAndRedirect('Selamat Datang Kaprodi SIB ' . $this->username, '../kaprodiSIB.php');
                break;
            case 5:
                $this->alertAndRedirect('Selamat Datang Kaprodi PPLS ' . $this->username, '../kaprodiPPLS.php');
                break;
            case 6:
                $this->alertAndRedirect('Selamat Datang Admin TA ' . $this->username, '../verifikatorTA.php');
                break;
            case 7:
                $this->alertAndRedirect('Selamat Datang Admin Jurusan ' . $this->username, '../verifikatorAdministrasi.php');
                break;
            case 8:
                $sqlNim = "SELECT NIM FROM Mahasiswa WHERE ID_User = ?";
                $paramsNim = array($row['ID_User']);
                $stmtNim = sqlsrv_query($this->conn, $sqlNim, $paramsNim);

                if ($stmtNim === false) {
                    die(print_r(sqlsrv_errors(), true));
                }

                if ($rowNim = sqlsrv_fetch_array($stmtNim, SQLSRV_FETCH_ASSOC)) {
                    $_SESSION['NIM'] = $rowNim['NIM'];
                }

                sqlsrv_free_stmt($stmtNim);
                $this->alertAndRedirect('Selamat Datang Mahasiswa ' . $this->username, '../User /mahasiswa/dashboardMHS.php');
                break;
            default:
                $this->alertAndRedirect('Role tidak dikenali.', 'Login.php');
                break;
        }
    }

    private function alertAndRedirect($message, $url) {
        echo "<script>alert('$message'); window.location.href = '$url'; </script>";
        exit();
    }
}

$database = new Database(); // Membuat objek Database untuk mendapatkan koneksi
$conn = $database->getConnection(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['Username'];
    $password = $_POST['Password'];

    $user = new User($conn, $username, $password);
    $user->login();
}

sqlsrv_close($conn);

?>