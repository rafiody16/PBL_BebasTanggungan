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
                $Tanggal_Pengumpulan,
                "Menunggu",
                ""
            );

            // Save Tugas Akhir data
            $this->tugasAkhir->createTA(
                $ID_Pengumpulan,
                $uploadedFiles['File_Aplikasi'],
                $uploadedFiles['Laporan_TA'],
                $uploadedFiles['Pernyataan_Publikasi'],
                $Tanggal_Pengumpulan,
                "Menunggu",
                ""
            );

            sqlsrv_commit($this->conn);
            echo "<script>alert('Data berhasil disimpan!'); window.location.href = '../Berkas/DetailBerkas.php?NIM=" . urlencode($NIM) . "';</script>";
        } catch (Exception $e) {
            sqlsrv_rollback($this->conn);
            echo "<script>alert('" . $e->getMessage() . "');</script>";
        }
    }

    public function editAdministrasi($NIM) {
        try {

            $uploadDir = '../Uploads/';

            $Laporan_Skripsi = $this->uploadFile($_FILES['Laporan_Skripsi'], $uploadDir);
            $Laporan_Magang = $this->uploadFile($_FILES['Laporan_Magang'], $uploadDir);
            $Bebas_Kompensasi = $this->uploadFile($_FILES['Bebas_Kompensasi'], $uploadDir);
            $Scan_Toeic = $this->uploadFile($_FILES['Scan_Toeic'], $uploadDir);
            $Tanggal_Pengumpulan = date("Y-m-d");


            $currentData = $this->Administrasi->getByNimAdm($NIM);

            $Laporan_Skripsi = $Laporan_Skripsi ?: $currentData['Laporan_Skripsi'];
            $Laporan_Magang = $Laporan_Magang ?: $currentData['Laporan_Magang'];
            $Bebas_Kompensasi = $Bebas_Kompensasi ?: $currentData['Bebas_Kompensasi'];
            $Scan_Toeic = $Scan_Toeic ?: $currentData['Scan_Toeic'];
                

            $this->Administrasi->editAdm(
                $NIM,
                $Laporan_Skripsi,
                $Laporan_Magang,
                $Bebas_Kompensasi,
                $Scan_Toeic,
                'Menunggu',
                $Tanggal_Pengumpulan,
                '-',
                null
            );

            $this->Pengumpulan->editPengumpulan(
                $NIM, 
            $Tanggal_Pengumpulan,
            'Menunggu',
            null,
            null,
            null,
            '-'
            );

            sqlsrv_commit($this->conn);
            echo "<script>alert('Data berhasil diubah!'); window.location.href = '../Berkas/DetailBerkas.php?NIM=" . urlencode($NIM) . "';</script>";
        } catch (Exception $e) {
            sqlsrv_rollback($this->conn);
            echo "<script>alert('" . $e->getMessage() . "');</script>";
        }
    }

    public function editTA($NIM) {
        try {

            $uploadDir = '../Uploads/';

            $File_Aplikasi = $this->uploadFile($_FILES['File_Aplikasi'], $uploadDir);
            $Laporan_TA = $this->uploadFile($_FILES['Laporan_TA'], $uploadDir);
            $Pernyataan_Publikasi = $this->uploadFile($_FILES['Pernyataan_Publikasi'], $uploadDir);
            $Tanggal_Pengumpulan = date("Y-m-d");

            $currentData = $this->tugasAkhir->getByNimTA($NIM);

            $File_Aplikasi = $File_Aplikasi ?: $currentData['File_Aplikasi'];
            $Laporan_TA = $Laporan_TA ?: $currentData['Laporan_TA'];
            $Pernyataan_Publikasi = $Pernyataan_Publikasi ?: $currentData['Pernyataan_Publikasi'];

            $this->tugasAkhir->editTA(
                $File_Aplikasi,
                $Laporan_TA,
                $Pernyataan_Publikasi,
                $NIM
            );

            $this->Pengumpulan->editPengumpulan(
            $NIM, 
            $Tanggal_Pengumpulan,
            'Menunggu',
            null,
            null,
            null,
            '-'
            );

            sqlsrv_commit($this->conn);
            echo "<script>alert('Data berhasil diubah!'); window.location.href = '../Berkas/DetailBerkas.php?NIM=" . urlencode($NIM) . "';</script>";
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

    public function verifikasiBerkas($id) {
        $tgl_verifikasi = date("Y-m-d");
        $verifikator = $_SESSION['Nama'];
        $role = $_SESSION['Role_ID'];

        $pgModels = new Pengumpulan($this->conn);
        $existingBerkas = $pgModels->getPengumpulanById($id);

        if ($existingBerkas) {
            if ($role === 2) {
                $pgModels->setVerifikatorKajur($verifikator, $id);
            } else if (in_array($role, [3, 4, 5])) {
                $pgModels->setVerifikatorKaprodi($verifikator, $id);
            }

            if (!is_null($existingBerkas['VerifikatorKajur']) && !is_null($existingBerkas['VerifikatorKaprodi'])) {
                $pgModels->setStatus_Pengumpulan('Terverifikasi', $id);
                $pgModels->setTanggal_Verifikasi($tgl_verifikasi, $id);
                $pgModels->setKeterangan('-', $id);
            }
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

    public function TolakAdministrasi($id, $verifikator, $keterangan) {
        try {
            $adm = new Administrasi($this->conn, $id);
            $adm->setStatus_Verifikasi($id, 'Ditolak');
            $adm->setVerifikator($verifikator, $id);
            $adm->set_Keterangan($keterangan, $id);
            $adm->setTanggalVerifikasi(null, $id);

            echo "Berhasil terverifikasi";
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function TolakTA($id, $verifikator, $keterangan) {
        try {
            $ta = new TugasAkhir($this->conn, $id);
            $ta->setStatus_Verifikasi($id, 'Ditolak');
            $ta->setVerifikator($verifikator, $id);
            $ta->set_Keterangan($keterangan, $id);
            $ta->setTanggalVerifikasi(null, $id);

            echo "Berhasil terverifikasi";
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function tolakBerkas($id) {
        $Keterangan = $_POST['Keterangan'];
        $verifikator = $_SESSION['Nama'];
        $SubBagian = $_POST['SubBagian'];
        $role = $_SESSION['Role_ID'];

        $pgModels = new Pengumpulan($this->conn);
        $existingBerkas = $pgModels->getPengumpulanById($id);

        if ($existingBerkas) {
            if ($role === 2) {
                $pgModels->setVerifikatorKajur($verifikator, $id);
                $pgModels->setStatus_Pengumpulan('Ditolak', $id);
                $pgModels->setTanggal_Verifikasi(null, $id);
                $pgModels->setKeterangan($Keterangan, $id);
            } else if (in_array($role, [3, 4, 5])) {
                $pgModels->setVerifikatorKaprodi($verifikator, $id);
                $pgModels->setStatus_Pengumpulan('Ditolak', $id);
                $pgModels->setTanggal_Verifikasi(null, $id);
                $pgModels->setKeterangan($Keterangan, $id);
            }
        }

        if ($SubBagian === 'Administrasi') {
            $admModels = new Administrasi($this->conn);
            $existingAdmin = $admModels->getAdministrasiByPengumpulanId($id);

            if ($existingAdmin) {
                $admModels->updateBerkasAdm('Ditolak',null,$Keterangan,$verifikator,$id);
            }
        } else if ($SubBagian === 'TA') {
            $taModels = new TugasAkhir($this->conn);
            $existingTA = $taModels->getTAByPengumpulanId($id);

            if ($existingTA) {
                $taModels->updateBerkasTA('Ditolak',null,$Keterangan,$verifikator,$id);
            }
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
            $uploadDir = '../Uploads/'; // Tentukan direktori unggahan
    
            // Pastikan direktori unggahan ada
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
    
            $berkasControllers->handleUpload($NIM, $_FILES, $uploadDir);
        } else {
            echo "<script>alert('Metode request tidak valid!');</script>";
        }
        break;
    case 'editAdm':
        $berkasControllers->editAdministrasi($_POST['NIM']);
        break;
    case 'editTA':
        $berkasControllers->editTA($_POST['NIM']);
        break;
    case 'verifBerkas':
        $berkasControllers->verifikasiBerkas($_POST['ID_Pengumpulan']);
        break;
    case 'verifTA':
        $berkasControllers->VerifikasiTA($_POST['ID_Aplikasi'], $_SESSION['Nama']);
        break;
    case 'verifAdm':
        $berkasControllers->VerifikasiAdministrasi($_POST['ID_Administrasi'], $_SESSION['Nama']);
        break;
    case 'tolakAdm':
        $berkasControllers->TolakAdministrasi($_POST['ID_Administrasi'], $_SESSION['Nama'],$_POST['Keterangan']);
        break;
    case 'tolakTA':
        $berkasControllers->TolakTA($_POST['ID_Aplikasi'], $_SESSION['Nama'],$_POST['Keterangan']);
        break;
    case 'tolakBerkas':
        $berkasControllers->tolakBerkas($_POST['ID_Pengumpulan']);
        break;
}
?>
