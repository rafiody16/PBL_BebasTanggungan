<?php 

require_once '../Koneksi.php';
require_once 'Pengumpulan.php';

class Administrasi extends Pengumpulan {

    private $Laporan_Skripsi;
    private $Laporan_Magang;
    private $Bebas_Kompensasi;
    private $Scan_Toeic;
    private $Status_Verifikasi;
    protected $Tanggal_Verifikasi;
    private $Tanggal_Upload;
    protected $Keterangan;
    private $Verifikator;

    public function __construct($conn = null, $ID_Pengumpulan = null, $Laporan_Skripsi = null, $Laporan_Magang = null, $Bebas_Kompensasi = null, 
                                $Scan_Toeic = null, $Status_Verifikasi = null, $Tanggal_Verifikasi = null, $Tanggal_Upload = null, $Keterangan = null, $Verifikator = null) {
        if (!$conn) {
            throw new Exception('Database connection is null in Administrasi constructor.');
        }
        parent::__construct($conn, $ID_Pengumpulan, $Status_Verifikasi, $Tanggal_Verifikasi, $Tanggal_Upload, $Keterangan);
        $this->conn = $conn; // Explicitly assign
        $this->ID_Pengumpulan = $ID_Pengumpulan;
        $this->Laporan_Skripsi = $Laporan_Skripsi;
        $this->Laporan_Magang = $Laporan_Magang;
        $this->Bebas_Kompensasi = $Bebas_Kompensasi;
        $this->Scan_Toeic = $Scan_Toeic;
        $this->Status_Verifikasi = $Status_Verifikasi;
        $this->Tanggal_Verifikasi = $Tanggal_Verifikasi;
        $this->Tanggal_Upload = $Tanggal_Upload;
        $this->Keterangan = $Keterangan;
        $this->Verifikator = $Verifikator;
    }


    // Getter dan Setter untuk ID_Pengumpulan
    public function getID_Pengumpulan() {
        return $this->ID_Pengumpulan;
    }
    
    public function setID_Pengumpulan($ID_Pengumpulan) {
        $this->ID_Pengumpulan = $ID_Pengumpulan;
    }

    // Getter dan Setter untuk Laporan_Skripsi
    public function getLaporan_Skripsi() {
        return $this->Laporan_Skripsi;
    }

    public function setLaporan_Skripsi($Laporan_Skripsi) {
        $this->Laporan_Skripsi = $Laporan_Skripsi;
    }

    // Getter dan Setter untuk Laporan_Magang
    public function getLaporan_Magang() {
        return $this->Laporan_Magang;
    }

    public function setLaporan_Magang($Laporan_Magang) {
        $this->Laporan_Magang = $Laporan_Magang;
    }

    // Getter dan Setter untuk Bebas_Kompensasi
    public function getBebas_Kompensasi() {
        return $this->Bebas_Kompensasi;
    }

    public function setBebas_Kompensasi($Bebas_Kompensasi) {
        $this->Bebas_Kompensasi = $Bebas_Kompensasi;
    }

    // Getter dan Setter untuk Scan_Toeic
    public function getScan_Toeic() {
        return $this->Scan_Toeic;
    }

    public function setScan_Toeic($Scan_Toeic) {
        $this->Scan_Toeic = $Scan_Toeic;
    }

    // Getter dan Setter untuk Status_Verifikasi
    public function getStatus_Verifikasi() {
        return $this->Status_Verifikasi;
    }

    public function setStatus_Verifikasi($Status_Verifikasi) {
        $this->Status_Verifikasi = $Status_Verifikasi;
    }

    // Getter dan Setter untuk Tanggal_Verifikasi
    public function getTanggal_Verifikasi() {
        return $this->Tanggal_Verifikasi;
    }

    public function setTanggal_Verifikasi($Tanggal_Verifikasi) {
        $this->Tanggal_Verifikasi = $Tanggal_Verifikasi;
    }

    // Getter dan Setter untuk Tanggal_Upload
    public function getTanggal_Upload() {
        return $this->Tanggal_Upload;
    }

    public function setTanggal_Upload($Tanggal_Upload) {
        $this->Tanggal_Upload = $Tanggal_Upload;
    }

    // Getter dan Setter untuk Keterangan
    public function getKeterangan() {
        return $this->Keterangan;
    }

    public function setKeterangan($Keterangan) {
        $this->Keterangan = $Keterangan;
    }

    // Getter dan Setter untuk Verifikator
    public function getVerifikator() {
        return $this->Verifikator;
    }

    public function setVerifikator($Verifikator) {
        $this->Verifikator = $Verifikator;
    }

    // Getter dan Setter untuk koneksi database
    public function getConn() {
        return $this->conn;
    }

    public function setConn($conn) {
        $this->conn = $conn;
    }

    public function getAllAdm() {
        $prodi = isset($_GET['prodi']) ? $_GET['prodi'] : '';
        $tahunAngkatan = isset($_GET['tahunAngkatan']) ? $_GET['tahunAngkatan'] : '';

        $sql = "SELECT * FROM fn_GetAdministrasiDetails (?, ?)";
        $params = array($prodi, $tahunAngkatan);
        $stmt = sqlsrv_query($this->conn, $sql, $params);

        return $stmt;
    }

    public function getAdmById($id) {
        $sql = "SELECT a.ID_Administrasi, m.NIM, m.Nama, m.Prodi, a.Laporan_Skripsi, a.Laporan_Magang, a.Bebas_Kompensasi, a.Scan_Toeic, 
            a.Status_Verifikasi, a.Tanggal_Verifikasi, a.Tanggal_Upload, a.Keterangan, a.Verifikator FROM Administrasi AS a 
            INNER JOIN Pengumpulan AS p ON a.ID_Pengumpulan = p.ID_Pengumpulan INNER JOIN Mahasiswa AS m ON p.NIM = m.NIM WHERE a.ID_Administrasi = ?";
        $params = array($id);
        $stmt = sqlsrv_query($this->conn, $sql, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        return $stmt;
    }

    public function saveAdm($Laporan_Skripsi, $Laporan_Magang, $Bebas_Kompensasi, $Scan_Toeic, $ID_Pengumpulan, $status, $tgl, $ket) {
        $sqlInsert = "INSERT INTO Administrasi (ID_Pengumpulan, Laporan_Skripsi, Laporan_Magang, Bebas_Kompensasi, Scan_Toeic, Status_Verifikasi, Tanggal_Upload, Keterangan)
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $paramsInsert = [
            $ID_Pengumpulan,
            $Laporan_Skripsi,
            $Laporan_Magang,
            $Bebas_Kompensasi,
            $Scan_Toeic,
            $status,
            $tgl,
            $ket
        ];
    
        $stmtInsert = sqlsrv_query($this->conn, $sqlInsert, $paramsInsert);
        
        if ($stmtInsert === false) {
            $errors = sqlsrv_errors();
            error_log('Database Insert Error: ' . print_r($errors, true));
            throw new Exception('Failed to save Administration data: ' . ($errors ? $errors[0]['message'] : 'Unknown error'));
        }
    }
    

    public function editAdm($NIM, $Laporan_Skripsi, $Laporan_Magang, $Bebas_Kompensasi, $Scan_Toeic) {
        $sqlUpdate = "UPDATE Administrasi 
                      SET Laporan_Skripsi = ?, Laporan_Magang = ?, Bebas_Kompensasi = ?, Scan_Toeic = ?, Status_Verifikasi = ?, Tanggal_Upload = ?, Verifikator = ? 
                      FROM Administrasi a 
                      INNER JOIN Pengumpulan p ON a.ID_Pengumpulan = p.ID_Pengumpulan 
                      INNER JOIN Mahasiswa m ON p.NIM = m.NIM 
                      WHERE m.NIM = ?";
        $paramsUpdate = [
                        $Laporan_Skripsi,
                        $Laporan_Magang, 
                        $Bebas_Kompensasi, 
                        $Scan_Toeic, 
                        'Menunggu', 
                        date("Y-m-d"), 
                        NULL, 
                        $NIM
                    ];
        $stmtUpdate = sqlsrv_query($this->conn, $sqlUpdate, $paramsUpdate);

        if ($stmtUpdate === false) {
            throw new Exception('Gagal menyimpan Mahasiswa: ' . print_r(sqlsrv_errors(), true));
        }
    }
}

?>
