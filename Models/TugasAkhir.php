<?php 
require_once '../Koneksi.php';
require_once 'Pengumpulan.php';

class TugasAkhir extends Pengumpulan {

    private $ID_Pengumpulan;
    private $File_Aplikasi;
    private $Laporan_TA;
    private $Pernyataan_Publikasi;
    private $Status_Verifikasi;
    private $Tanggal_Verifikasi;
    private $Tanggal_Upload;
    private $Keterangan;
    private $Verifikator;
    private $conn;

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

    public function setStatus_Verifikasi($Status_Verifikasi) {
        $this->Status_Verifikasi = $Status_Verifikasi;
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
        $prodi = isset($_GET['prodi']) ? $_GET['prodi'] : '';
        $tahunAngkatan = isset($_GET['tahunAngkatan']) ? $_GET['tahunAngkatan'] : '';

        $sql = "SELECT * FROM fn_GetTugasAkhirDetails(?, ?)";
        $params = array($prodi, $tahunAngkatan);
        $stmt = sqlsrv_query($this->conn, $sql, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        return $stmt;
    }

    public function getTaById($id) {
        $sql = "SELECT a.ID_Aplikasi, m.NIM, m.Nama, m.Prodi, a.File_Aplikasi, a.Laporan_TA, a.Pernyataan_Publikasi, 
            a.Status_Verifikasi, a.Tanggal_Verifikasi, a.Tanggal_Upload, a.Keterangan, a.Verifikator FROM TugasAkhir AS a 
            INNER JOIN Pengumpulan AS p ON a.ID_Pengumpulan = p.ID_Pengumpulan INNER JOIN Mahasiswa AS m ON p.NIM = m.NIM WHERE a.ID_Aplikasi = ?";
        $params = array($id);
        $stmt = sqlsrv_query($this->conn, $sql, $params);

        return $stmt;
    }

    public function saveTA($id, $File_Aplikasi, $Laporan_TA, $Pernyataan_Publikasi) {
        $sqlTA = "INSERT INTO TugasAkhir (ID_Pengumpulan, File_Aplikasi, Laporan_TA, Pernyataan_Publikasi, Status_Verifikasi, Tanggal_Upload, Keterangan) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $paramsTA = [
                    $id, 
                    $File_Aplikasi, 
                    $Laporan_TA, 
                    $Pernyataan_Publikasi, 
                    "Menunggu", 
                    date("Y-m-d"), 
                    "-"
                ];
        $stmtTA = sqlsrv_query($this->conn, $sqlTA, $paramsTA);

        if (!$stmtTA) {
            throw new Exception('Gagal menyimpan data Tugas Akhir: ' . print_r(sqlsrv_errors(), true));
        }

        return $stmtTA;
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

        return $stmtTAUpdate;
    }

}

?>
