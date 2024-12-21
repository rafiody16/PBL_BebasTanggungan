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
            // Create Pengumpulan record first
            $newPgID = $this->createPengumpulan($NIM);
            if (!$newPgID) {
                throw new Exception('Failed to create Pengumpulan');
            }

            $uploadDir = "../Uploads/";

            // Upload files
            $Laporan_Skripsi = $this->uploadFile($_FILES['Laporan_Skripsi'], $uploadDir);
            $Laporan_Magang = $this->uploadFile($_FILES['Laporan_Magang'], $uploadDir);
            $Bebas_Kompensasi = $this->uploadFile($_FILES['Bebas_Kompensasi'], $uploadDir);
            $Scan_Toeic = $this->uploadFile($_FILES['Scan_Toeic'], $uploadDir);
            $File_Aplikasi = $this->uploadFile($_FILES['File_Aplikasi'], $uploadDir);
            $Laporan_TA = $this->uploadFile($_FILES['Laporan_TA'], $uploadDir);
            $Pernyataan_Publikasi = $this->uploadFile($_FILES['Pernyataan_Publikasi'], $uploadDir);

            // Process Administrasi and TugasAkhir separately
            $this->processAdministrasi($newPgID, $Laporan_Skripsi, $Laporan_Magang, $Bebas_Kompensasi, $Scan_Toeic);
            $this->processTugasAkhir($newPgID, $File_Aplikasi, $Laporan_TA, $Pernyataan_Publikasi);

            echo json_encode(['success' => true]);

        } catch (Exception $e) {
            error_log("Error in uploadBerkas: " . $e->getMessage()); // Log error message
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    function uploadFile($file, $uploadDir) {
        $fileName = basename($file['name']);
        $targetFilePath = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
            return $fileName; 
        } else {
            return false; 
        }
    }

    // Separate method to handle Administrasi
    private function processAdministrasi($newPgID, $Laporan_Skripsi, $Laporan_Magang, $Bebas_Kompensasi, $Scan_Toeic) {
        $AdmModel = new Administrasi($this->conn, $newPgID, $Laporan_Skripsi, $Laporan_Magang, $Bebas_Kompensasi, $Scan_Toeic);
        $AdmModel->saveAdm($Laporan_Skripsi, $Laporan_Magang, $Bebas_Kompensasi, $Scan_Toeic, $newPgID, "Menunggu", date("Y-m-d"), "-");
    }

    // Separate method to handle TugasAkhir
    private function processTugasAkhir($newPgID, $File_Aplikasi, $Laporan_TA, $Pernyataan_Publikasi) {
        $TAModel = new TugasAkhir($this->conn, $newPgID, $File_Aplikasi, $Laporan_TA, $Pernyataan_Publikasi);
        $TAModel->saveTA($newPgID, $File_Aplikasi, $Laporan_TA, $Pernyataan_Publikasi);
    }
}

$database = new Database(); // Create Database object to get connection
$conn = $database->conn; 

$berkasControllers = new BerkasControllers($conn);

// Get action from request
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
