<?php 

require_once '../Koneksi.php';
require_once '../Models/User.php';
require_once '../Models/Staff.php';
require_once '../Models/Mahasiswa.php';

class UserController {

    public $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Method untuk membuat user baru
    public function createUser($username, $password, $email, $roleId) {
        try {
            $userModel = new User($this->conn, $username, $password, $email, $roleId);
            $newUserID = $userModel->saveUser($username, $password, $email, $roleId);
            
            return $newUserID;
        } catch (Exception $e) {
            return null;
        }
    }

    public function createStaff($NIP, $Nama, $Alamat, $NoHp, $JenisKelamin, $Tempat_Lahir, $Tanggal_Lahir, $TTD, $Username, $Password, $Email, $Role_ID) {
        try {
            $newUserID = $this->createUser($Username, $Password, $Email, $Role_ID);

            $uploadDir = "../Uploads/";
    
            function uploadFile($file, $uploadDir) {
                if (!$file || !isset($file['tmp_name']) || empty($file['tmp_name'])) {
                    return false;
                }
            
                $fileName = basename($file['name']);
                $targetFilePath = $uploadDir . $fileName;
            
                // Validasi apakah file adalah gambar
                $fileType = mime_content_type($file['tmp_name']);
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            
                if (!in_array($fileType, $allowedTypes)) {
                    return false; // File bukan gambar
                }
            
                if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
                    return $fileName; 
                } else {
                    return false; 
                }
            }
    
            $ttdFile = uploadFile($TTD, $uploadDir);

            if ($newUserID) {
                $staffModel = new Staff($this->conn, $newUserID, $Username, $Password, $Email, $Role_ID, $NIP, $Nama, $Alamat, $NoHp, $JenisKelamin, $Tempat_Lahir, $Tanggal_Lahir, $ttdFile);
                $staffModel->saveStaff($NIP, $Nama, $Alamat, $NoHp, $JenisKelamin, $Tempat_Lahir, $Tanggal_Lahir, $ttdFile, $newUserID);

                echo json_encode(['success' => true]);
            } else {
                throw new Exception('Failed to create User');
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function createMahasiswa($NIM, $Nama, $Alamat, $NoHp, $JenisKelamin, $Prodi, $tahunAngkatan, $Tempat_Lahir, $Tanggal_Lahir, $Username, $Password, $Email) {
        try {
            $newUserIDMhs = $this->createUser($Username, $Password, $Email, 8);

            if ($newUserIDMhs) {
                $mhsModel = new Mahasiswa($this->conn, null, $Username, $Password, $Email, $NIM, $Nama, $Alamat, $NoHp, $JenisKelamin, $Prodi, $Tempat_Lahir, $Tanggal_Lahir, $tahunAngkatan);
                $mhsModel->saveMahasiswa($NIM, $Nama, $Alamat, $NoHp, $JenisKelamin, $Tempat_Lahir, $Tanggal_Lahir, $Prodi, $tahunAngkatan, $newUserIDMhs);

                echo json_encode(['success' => true]);
            } else {
                throw new Exception('Failed to create User');
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function updateMhs($username, $email, $NIM, $Nama, $Alamat, $NoHp, $JenisKelamin, $Prodi, $tahunAngkatan, $Tempat_Lahir, $Tanggal_Lahir) {
        try {
            // Menginstansiasi User Model dan update user mahasiswa
            $userModel = new User($this->conn, $username,  $email);
            $userModel->updateUserMhs($username, $email, $NIM);
    
            // Menginstansiasi Mahasiswa Model untuk update data Mahasiswa
            $mhsModel = new Mahasiswa($this->conn, $NIM, $Nama, $Alamat, $NoHp, $JenisKelamin, $Prodi, $Tempat_Lahir, $Tanggal_Lahir, $tahunAngkatan);
            $mhsModel->updateMahasiswa($Nama, $Alamat, $NoHp, $JenisKelamin, $Prodi, $tahunAngkatan, $Tempat_Lahir, $Tanggal_Lahir, $NIM);
    
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function deleteMhs($NIM) {
        try {
            if (empty($NIM)) {
                throw new Exception('NIM tidak boleh kosong.');
            }

            $mhsModel = new Mahasiswa($this->conn);
            $mhsModel->deleteMhsUser($NIM);

            echo json_encode([
                'status' => 'success',
                'message' => 'Mahasiswa dan user terkait berhasil dihapus.'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

}

$database = new Database(); // Membuat objek Database untuk mendapatkan koneksi
$conn = $database->conn; 


$userController = new UserController($conn);

// Mengambil action dari request
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'createUser':
        $userController->createUser($_POST['username'], $_POST['password'], $_POST['email'], $_POST['roleId']);
        break;
    case 'createStaff':
        $userController->createStaff($_POST['NIP'], $_POST['Nama'], $_POST['Alamat'], $_POST['NoHp'], $_POST['JenisKelamin'], $_POST['Tempat_Lahir'], $_POST['Tanggal_Lahir'], $_FILES['TTD'], $_POST['Username'], $_POST['Password'], $_POST['Email'], $_POST['Role_ID']);
        break;
    case 'createMahasiswa':
        $userController->createMahasiswa(
            $_POST['NIM'], 
            $_POST['Nama'], 
            $_POST['Alamat'], 
            $_POST['NoHp'], 
            $_POST['JenisKelamin'], 
            $_POST['Prodi'], 
            $_POST['Tahun_Angkatan'], // tahunAngkatan pada posisi ke-7
            $_POST['Tempat_Lahir'], 
            $_POST['Tanggal_Lahir'], 
            $_POST['Username'], 
            $_POST['Password'], 
            $_POST['Email']
        );        
        break;
    case 'updateMhs':
        $userController->updateMhs(
            $_POST['Username'], 
            $_POST['Email'], 
            $_POST['NIM'], 
            $_POST['Nama'],
            $_POST['Alamat'],
            $_POST['NoHp'],
            $_POST['JenisKelamin'],
            $_POST['Prodi'],
            $_POST['Tahun_Angkatan'],
            $_POST['Tempat_Lahir'],
            $_POST['Tanggal_Lahir'],
        );
        break;
    case 'deleteMhs':
        $userController->deleteMhs($_POST['NIM']);
        break;
    default:
        echo json_encode(['message' => 'Action not found']);
        break;
}


?>