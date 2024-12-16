<?php 

require_once '../Koneksi.php';
require_once '../Models/Pengumpulan.php';

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
        $this->conn = $conn;
        $this->NIM = $NIM;
        $this->Nama = $Nama;
        $this->Alamat = $Alamat;
        $this->NoHp = $NoHp;
        $this->JenisKelamin = $JenisKelamin;
        $this->Prodi = $Prodi;
        $this->Tempat_Lahir = $Tempat_Lahir;
        $this->Tanggal_Lahir = $Tanggal_Lahir;
        $this->Tahun_Angkatan = $Tahun_Angkatan;
    }



}

?>