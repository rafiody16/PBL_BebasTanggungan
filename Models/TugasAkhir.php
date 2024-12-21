<?php 
require_once '../Koneksi.php';
require_once 'Pengumpulan.php';

class TugasAkhir extends Pengumpulan {

    protected $ID_Pengumpulan;
    protected $File_Aplikasi;
    protected $Laporan_TA;
    protected $Pernyataan_Publikasi;
    protected $Status_Verifikasi;
    protected $Tanggal_Verifikasi;
    protected $Tanggal_Upload;
    protected $Keterangan;
    protected $Verifikator;
    protected $conn;

    public function __construct($conn = null, $ID_Pengumpulan = null, $File_Aplikasi = null, $Laporan_TA = null, $Pernyataan_Publikasi = null, 
                            $Status_Verifikasi = null, $Tanggal_Verifikasi = null, $Tanggal_Upload = null, $Keterangan = null, $Verifikator = null) {
        parent::__construct($conn, $ID_Pengumpulan, $Status_Verifikasi, $Tanggal_Verifikasi, $Tanggal_Upload, $Keterangan);
        $this->conn = $conn;
        $this->ID_Pengumpulan = $ID_Pengumpulan;
        $this->File_Aplikasi = $File_Aplikasi;
        $this->Laporan_TA = $Laporan_TA;
        $this->Pernyataan_Publikasi = $Pernyataan_Publikasi;
        $this->Status_Verifikasi = $Status_Verifikasi;
        $this->Tanggal_Verifikasi = $Tanggal_Verifikasi;
        $this->Tanggal_Upload = $Tanggal_Upload;
        $this->Keterangan = $Keterangan;
        $this->Verifikator = $Verifikator;
    }

    // Getters and Setters
    public function getID_Pengumpulan() {
        return $this->ID_Pengumpulan;
    }

    public function setID_Pengumpulan($ID_Pengumpulan) {
        $this->ID_Pengumpulan = $ID_Pengumpulan;
    }

    public function getFile_Aplikasi() {
        return $this->File_Aplikasi;
    }

    public function setFile_Aplikasi($File_Aplikasi) {
        $this->File_Aplikasi = $File_Aplikasi;
    }

    public function getLaporan_TA() {
        return $this->Laporan_TA;
    }

    public function setLaporan_TA($Laporan_TA) {
        $this->Laporan_TA = $Laporan_TA;
    }

    public function getPernyataan_Publikasi() {
        return $this->Pernyataan_Publikasi;
    }

    public function setPernyataan_Publikasi($Pernyataan_Publikasi) {
        $this->Pernyataan_Publikasi = $Pernyataan_Publikasi;
    }

    public function getStatus_Verifikasi() {
        return $this->Status_Verifikasi;
    }

    public function setStatus_Verifikasi($id, $Status_Verifikasi) {
        $this->Status_Verifikasi = $Status_Verifikasi;
        $sql = "UPDATE TugasAkhir SET Status_Verifikasi = ?
                WHERE ID_Aplikasi = ?";
        $params = [$Status_Verifikasi, $id];
        $stmt = sqlsrv_query($this->conn, $sql, $params);

        return $stmt;
    }

    public function getTanggal_Verifikasi() {
        return $this->Tanggal_Verifikasi;
    }

    public function setTanggal_Verifikasi($Tanggal_Verifikasi) {
        $this->Tanggal_Verifikasi = $Tanggal_Verifikasi;
    }

    public function getTanggal_Upload() {
        return $this->Tanggal_Upload;
    }

    public function setTanggal_Upload($Tanggal_Upload) {
        $this->Tanggal_Upload = $Tanggal_Upload;
    }

    public function getKeterangan() {
        return $this->Keterangan;
    }

    public function setKeterangan($Keterangan) {
        $this->Keterangan = $Keterangan;
    }

    public function getVerifikator() {
        return $this->Verifikator;
    }

    public function setVerifikator($Verifikator) {
        $this->Verifikator = $Verifikator;
    }

    public function getConn() {
        return $this->conn;
    }

    public function setConn($conn) {
        $this->conn = $conn;
    }

    public function getAllTA() {
        $prodi = $_GET['prodi'] ?? ''; // Avoid undefined array key warning
        $tahunAngkatan = $_GET['tahunAngkatan'] ?? ''; // Avoid undefined array key warning
    
        $sql = "SELECT * FROM fn_GetTugasAkhirDetails(?, ?)";
        $params = array($prodi, $tahunAngkatan);
    
        $stmt = sqlsrv_query($this->conn, $sql, $params);
    
        if ($stmt === false) {
            error_log(print_r(sqlsrv_errors(), true)); // Log detailed error for debugging
            echo "An error occurred while fetching data. Please try again later.";
            return false;
        }
    
        return $stmt;
    }

    public function getTaById($id) {
        $sql = "SELECT a.ID_Aplikasi, m.NIM, m.Nama, m.Prodi, m.Tahun_Angkatan, a.File_Aplikasi, a.Laporan_TA, a.Pernyataan_Publikasi, 
            a.Status_Verifikasi, a.Tanggal_Verifikasi, a.Tanggal_Upload, a.Keterangan, a.Verifikator FROM TugasAkhir AS a 
            INNER JOIN Pengumpulan AS p ON a.ID_Pengumpulan = p.ID_Pengumpulan INNER JOIN Mahasiswa AS m ON p.NIM = m.NIM WHERE a.ID_Aplikasi = ?";
        $params = array($id);
        $stmt = sqlsrv_query($this->conn, $sql, $params);

        return sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    }

    public function createTA($ID_Pengumpulan, $File_Aplikasi, $Laporan_TA, $Pernyataan_Publikasi, $Status_Verifikasi = "Menunggu", $Tanggal_Upload, $Keterangan = "") {
        $sql = "INSERT INTO TugasAkhir (ID_Pengumpulan, File_Aplikasi, Laporan_TA, Pernyataan_Publikasi, Status_Verifikasi, Tanggal_Upload, Keterangan) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $params = [$ID_Pengumpulan, $File_Aplikasi, $Laporan_TA, $Pernyataan_Publikasi, $Status_Verifikasi, $Tanggal_Upload, $Keterangan];
        $stmt = sqlsrv_query($this->conn, $sql, $params);

        var_dump($params);

        if (!$stmt) {
            throw new Exception("Gagal menyimpan data Tugas Akhir: " . print_r(sqlsrv_errors(), true));
        }

        return true;
    }

    public function editTA($File_Aplikasi, $Laporan_TA, $Pernyataan_Publikasi, $nim) {
        $sqlUpdate = "UPDATE TugasAkhir 
                      SET File_Aplikasi = ?, Laporan_TA = ?, Pernyataan_Publikasi = ?, Status_Verifikasi = ?, Tanggal_Upload = ?, Verifikator = ? 
                      FROM TugasAkhir a 
                      INNER JOIN Pengumpulan p ON a.ID_Pengumpulan = p.ID_Pengumpulan 
                      INNER JOIN Mahasiswa m ON p.NIM = m.NIM 
                      WHERE m.NIM = ?";
        $paramsTAUpdate = [
                          $File_Aplikasi, 
                          $Laporan_TA, 
                          $Pernyataan_Publikasi, 
                          'Menunggu', 
                          date("Y-m-d"), 
                          NULL, 
                          $nim
                        ];
        $stmtTAUpdate = sqlsrv_query($this->conn, $sqlUpdate, $paramsTAUpdate);

        if ($stmtTAUpdate === false) {
            throw new Exception('Gagal menyimpan Mahasiswa: ' . print_r(sqlsrv_errors(), true));
        }
    }

    function getByNimTA($NIM) {
        $sqlTA = "SELECT t.Tanggal_Upload, t.Status_Verifikasi, t.Keterangan, t.Tanggal_Verifikasi FROM TugasAkhir AS t
             INNER JOIN Pengumpulan AS p ON t.ID_Pengumpulan = p.ID_Pengumpulan INNER JOIN Mahasiswa AS m ON p.NIM = m.NIM
             WHERE m.NIM = ?";
        $paramsTA = array($NIM);
        $stmtTA = sqlsrv_query($this->conn, $sqlTA, $paramsTA);

        return sqlsrv_fetch_array($stmtTA, SQLSRV_FETCH_ASSOC);

    }

}

?>
