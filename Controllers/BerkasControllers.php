<?php 

require_once '../Koneksi.php';
require_once '../Models/Pengumpulan.php';
require_once '../Models/Administrasi.php';
require_once '../Models/TugasAkhir.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class BerkasControllers {

    public $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Method untuk membuat user baru
    public function createPengumpulan($NIM) {
        try {
            $pgModel = new Pengumpulan($this->conn, $NIM);
            $newPgId = $pgModel -> savePengumpulan($NIM);
            
            return $newPgId;
        } catch (Exception $e) {
            return null;
        }
    }

    public function uploadBerkas($NIM, $LaporanSkripsi, $LaporanMagang, $BebasKompen, $ScanToeic,
                              $FileAplikasi, $LaporanTA, $PernyataanPublikasi) {
        try {

            $newPgID = $this->createPengumpulan($NIM);

            $uploadDir = "../Uploads/";
    
            $LaporanSkripsi = $this->uploadFile($_FILES['Laporan_Skripsi'], $uploadDir);
            $LaporanMagang = $this->uploadFile($_FILES['Laporan_Magang'], $uploadDir);
            $BebasKompen = $this->uploadFile($_FILES['Bebas_Kompensasi'], $uploadDir);
            $ScanToeic = $this->uploadFile($_FILES['Scan_Toeic'], $uploadDir);
            $FileAplikasi = $this->uploadFile($_FILES['File_Aplikasi'], $uploadDir);
            $LaporanTA = $this->uploadFile($_FILES['Laporan_TA'], $uploadDir);
            $PernyataanPublikasi = $this->uploadFile($_FILES['Pernyataan_Publikasi'], $uploadDir);

            if ($newPgID) {
                $AdmModel = new Administrasi($this->conn, $newPgID, $LaporanSkripsi, $LaporanMagang, $BebasKompen, $ScanToeic);
                $AdmModel -> saveAdm($LaporanSkripsi, $LaporanMagang, $BebasKompen, $ScanToeic, $newPgID, "Menunggu", date("Y-m-d"), "-");

                $TAModel = new TugasAkhir($this->conn, $newPgID,$FileAplikasi, $LaporanTA, $PernyataanPublikasi);
                $TAModel -> saveTA($newPgID, $FileAplikasi, $LaporanTA, $PernyataanPublikasi);

                echo json_encode(['success' => true]);
            } else {
                throw new Exception('Failed to create User');
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
    
    private function uploadFile($file, $uploadDir) {
        if (!$file || empty($file['tmp_name'])) {
            throw new Exception('No file uploaded.');
        }
    
        $fileName = basename($file['name']);
        $targetFilePath = $uploadDir . $fileName;
    
        $allowedTypes = ['application/pdf', 'application/zip', 'application/x-rar-compressed'];
        $fileType = mime_content_type($file['tmp_name']);
    
        if (!in_array($fileType, $allowedTypes)) {
            throw new Exception('Invalid file type: ' . $fileType);
        }

        error_log("Uploading file to: " . $targetFilePath);
    
        if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
            return $fileName;
        } else {
            throw new Exception('Failed to move uploaded file.');
        }
    }

}

$database = new Database(); // Membuat objek Database untuk mendapatkan koneksi
$conn = $database->getConnection(); 


$berkasControllers = new BerkasControllers($conn);

// Mengambil action dari request
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'uploadFile':
        $berkasControllers->uploadBerkas(
            $_SESSION['NIM'],
            $_FILES['Laporan_Skripsi'],
            $_FILES['Laporan_Magang'],
            $_FILES['Bebas_Kompensasi'],
            $_FILES['Scan_Toeic'],
            $_FILES['File_Aplikasi'],
            $_FILES['Laporan_TA'],
            $_FILES['Pernyataan_Publikasi']
        );
        break;
    case 'deleteMhs':
        $userController->deleteMhs($_POST['NIM']);
        break;
    case 'deleteStaff':
        $userController->deleteStaff($_POST['NIP']);
        break;
    default:
        echo json_encode(['message' => 'Action not found']);
        break;
}


?>