<?php 

require_once '../Koneksi.php';
require_once 'Pengumpulan.php';

class Administrasi extends Pengumpulan {
    
    private $ID_Pengumpulan;
    private $Laporan_Skripsi;
    private $Laporan_Magang;
    private $Bebas_Kompensasi;
    private $Scan_Toeic;
    private $Status_Verifikasi;
    private $Tanggal_Verifikasi;
    private $Tanggal_Upload;
    private $Keterangan;
    private $Verifikator;
    private $conn;

    public function __construct($conn = null, $ID_Pengumpulan = null, $Laporan_Skripsi = null, $Laporan_Magang = null, $Bebas_Kompensasi = null, 
                            $Scan_Toeic = null, $Status_Verifikasi = null, $Tanggal_Verifikasi = null, $Tanggal_Upload = null, $Keterangan = null, $Verifikator = null) {
        parent::__construct($conn, $ID_Pengumpulan, $Status_Verifikasi, $Tanggal_Verifikasi, $Tanggal_Upload, $Keterangan);
        $this->conn = $conn;
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
}

?>
