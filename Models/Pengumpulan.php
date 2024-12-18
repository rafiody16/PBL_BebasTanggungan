<?php

require_once '../Koneksi.php';

class Pengumpulan {

    protected $ID_Pengumpulan;
    protected $NIM;
    protected $Tanggal_Pengumpulan;
    protected $Status_Pengumpulan;
    protected $Tanggal_Verifikasi;
    protected $Keterangan;
    protected $VerifikatorKajur;
    protected $VerifikatorKaprodi;
    protected $conn;

    public function __construct($conn = null, $NIM = null, $Tanggal_Pengumpulan = null, $Status_Pengumpulan = null, 
                                $Tanggal_Verifikasi = null, $Keterangan = null, 
                                $VerifikatorKajur = null, $VerifikatorKaprodi = null) {
        $this->conn = $conn;
        $this->NIM = $NIM;
        $this->Tanggal_Pengumpulan = $Tanggal_Pengumpulan;
        $this->Status_Pengumpulan = $Status_Pengumpulan;
        $this->Tanggal_Verifikasi = $Tanggal_Verifikasi;
        $this->Keterangan = $Keterangan;
        $this->VerifikatorKajur = $VerifikatorKajur;
        $this->VerifikatorKaprodi = $VerifikatorKaprodi;
    }

    public function getID_Pengumpulan() {
        return $this->ID_Pengumpulan;
    }

    public function setID_Pengumpulan($ID_Pengumpulan) {
        $this->ID_Pengumpulan = $ID_Pengumpulan;
    }

    public function getNIM() {
        return $this->NIM;
    }

    public function setNIM($NIM) {
        $this->NIM = $NIM;
    }

    public function getTanggal_Pengumpulan() {
        return $this->Tanggal_Pengumpulan;
    }

    public function setTanggal_Pengumpulan($Tanggal_Pengumpulan) {
        $this->Tanggal_Pengumpulan = $Tanggal_Pengumpulan;
    }

    public function getStatus_Pengumpulan() {
        return $this->Status_Pengumpulan;
    }

    public function setStatus_Pengumpulan($Status_Pengumpulan) {
        $this->Status_Pengumpulan = $Status_Pengumpulan;
    }


    public function getTanggal_Verifikasi() {
        return $this->Tanggal_Verifikasi;
    }

    public function setTanggal_Verifikasi($Tanggal_Verifikasi) {
        $this->Tanggal_Verifikasi = $Tanggal_Verifikasi;
    }

    public function getKeterangan() {
        return $this->Keterangan;
    }

    public function setKeterangan($Keterangan) {
        $this->Keterangan = $Keterangan;
    }

    public function getVerifikatorKajur() {
        return $this->VerifikatorKajur;
    }

    public function setVerifikatorKajur($VerifikatorKajur) {
        $this->VerifikatorKajur = $VerifikatorKajur;
    }

    public function getVerifikatorKaprodi() {
        return $this->VerifikatorKaprodi;
    }

    public function setVerifikatorKaprodi($VerifikatorKaprodi) {
        $this->VerifikatorKaprodi = $VerifikatorKaprodi;
    }

    public function getConn() {
        return $this->conn;
    }

    public function setConn($conn) {
        $this->conn = $conn;
    }

    public function getAllPengumpulan($role) {
        $sql = "SELECT 
                p.ID_Pengumpulan, 
                p.NIM, 
                m.Nama, 
                m.Prodi, 
                p.Status_Pengumpulan, 
                p.Keterangan 
             FROM 
                Pengumpulan AS p
             INNER JOIN 
                Mahasiswa AS m ON p.NIM = m.NIM
             INNER JOIN 
                Administrasi AS a ON p.ID_Pengumpulan = a.ID_Pengumpulan
             INNER JOIN
                TugasAkhir AS t ON p.ID_Pengumpulan = t.ID_Pengumpulan
             WHERE 
                p.Status_Pengumpulan != 'Terverifikasi' 
                AND a.Status_Verifikasi = 'Terverifikasi'
                AND t.Status_Verifikasi = 'Terverifikasi'";

        if ($role === 3) {
            $sql .= " AND m.Prodi = 'TI'";
        } else if ($role === 4) {
            $sql .= " AND m.Prodi = 'SIB'";
        } else if ($role === 5) {
            $sql .= " AND m.Prodi = 'PPLS'";
        } else if (!($role === 1 || $role === 2)) {
            return false; 
        }

        $stmt = sqlsrv_query($this->conn, $sql);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        return $stmt;
    }

    function savePengumpulan($NIM) {
        $sql = "INSERT INTO Pengumpulan (NIM, Tanggal_Pengumpulan, Status_Pengumpulan, Keterangan)  
                VALUES (?, ?, ?, ?)";
        $params = [
            $NIM,
            date("Y-m-d"),
            "Menunggu",
            "-"
        ];
        $stmt = sqlsrv_query($this->conn, $sql, $params);

        if ($stmt === false) {
            throw new Exception('Gagal menyimpan Mahasiswa: ' . print_r(sqlsrv_errors(), true));
        }
        return $stmt;
        
    }

    function editPengumpulan($NIM) {
        $sql = "UPDATE Pengumpulan SET Tanggal_Pengumpulan = ?, Status_Pengumpulan = ?
                Tanggal_Verifikasi = ?, Keterangan = ?, VerifikatorKajur = ?, VerifikatorKaprodi = ?
                WHERE NIM = ?";
        $params = [
            date("Y-m-d"),
            "Menunggu",
            NULL,
            "-",
            NULL,
            NULL,
            $NIM
        ];
        $stmt = sqlsrv_query($this->conn, $sql, $params);

        if ($stmt === false) {
            throw new Exception('Gagal menyimpan Mahasiswa: ' . print_r(sqlsrv_errors(), true));
        }
    }


}
?>
