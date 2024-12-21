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
    private $Pengumpulan;
    private $Administrasi;
    private $tugasAkhir;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->Pengumpulan = new Pengumpulan($conn);
        $this->Administrasi = new Administrasi($conn);
        $this->tugasAkhir = new TugasAkhir($conn);
    }

    // Method untuk membuat user baru
    public function handleUpload($NIM, $files, $uploadDir) {
        $Tanggal_Pengumpulan = date("Y-m-d");

        sqlsrv_begin_transaction($this->conn);

        try {
            // Save Pengumpulan data
            $ID_Pengumpulan = $this->Pengumpulan->create($NIM, $Tanggal_Pengumpulan);

            // Handle file uploads
            $uploadedFiles = [];
            foreach ($files as $key => $file) {
                $uploadedFiles[$key] = $this->uploadFile($file, $uploadDir);
                if (!$uploadedFiles[$key]) {
                    throw new Exception("Gagal mengunggah file: " . $key);
                }
            }

            // Save Administrasi data
            $this->Administrasi->createAdm(
                $ID_Pengumpulan,
                $uploadedFiles['Laporan_Skripsi'],
                $uploadedFiles['Laporan_Magang'],
                $uploadedFiles['Bebas_Kompensasi'],
                $uploadedFiles['Scan_Toeic'],
                "Menunggu",
                $Tanggal_Pengumpulan,
                ""
            );

            // Save Tugas Akhir data
            $this->tugasAkhir->createTA(
                $ID_Pengumpulan,
                $uploadedFiles['File_Aplikasi'],
                $uploadedFiles['Laporan_TA'],
                $uploadedFiles['Pernyataan_Publikasi'],
                "Menunggu",
                $Tanggal_Pengumpulan,
                ""
            );

            sqlsrv_commit($this->conn);
            echo "<script>alert('Data berhasil disimpan!'); window.location.href = '../Berkas/DetailBerkas.php?NIM=" . urlencode($NIM) . "';</script>";
        } catch (Exception $e) {
            sqlsrv_rollback($this->conn);
            echo "<script>alert('" . $e->getMessage() . "');</script>";
        }
    }

    private function uploadFile($file, $uploadDir) {
        $fileName = basename($file['name']);
        $targetFilePath = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
            return $fileName;
        } else {
            return false;
        }
    }

    public function VerifikasiAdministrasi($id, $verifikator) {
        try {
            $adm = new Administrasi($this->conn, $id);
            $adm->setStatus_Verifikasi($id, 'Terverifikasi');
            $adm->setVerifikator($verifikator, $id);
            $adm->set_Keterangan('-', $id);
            $adm->setTanggalVerifikasi(date('Y-m-d'), $id);

            echo "Berhasil terverifikasi";
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function VerifikasiTA($id, $verifikator) {
        try {
            $ta = new TugasAkhir($this->conn, $id);
            $ta->setStatus_Verifikasi($id, 'Terverifikasi');
            $ta->setVerifikator($verifikator, $id);
            $ta->set_Keterangan('-', $id);
            $ta->setTanggalVerifikasi(date('Y-m-d'), $id);

            echo "Berhasil terverifikasi";
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}

$database = new Database(); // Create Database object to get connection
$conn = $database->conn; 

$berkasControllers = new BerkasControllers($conn);

// Get action from request
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'uploadFile':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $NIM = $_SESSION['NIM'];
            $uploadDir = '../uploads/'; // Tentukan direktori unggahan
    
            // Pastikan direktori unggahan ada
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
    
            $berkasControllers->handleUpload($NIM, $_FILES, $uploadDir);
        } else {
            echo "<script>alert('Metode request tidak valid!');</script>";
        }
        break;
    case 'verifTA':
        $berkasControllers->VerifikasiTA($_POST['ID_Aplikasi'], $_SESSION['Nama']);
        break;
}
?>
