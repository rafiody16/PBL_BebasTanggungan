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

    public function setStatus_Pengumpulan($Status_Pengumpulan, $id) {
        $this->Status_Pengumpulan = $Status_Pengumpulan;
        $sql = "UPDATE Pengumpulan SET Status_Pengumpulan = ?
                WHERE ID_Pengumpulan = ?";
        $params = [$Status_Pengumpulan, $id];
        $stmt = sqlsrv_query($this->conn, $sql, $params);

        return $stmt;
    }


    public function getTanggal_Verifikasi() {
        return $this->Tanggal_Verifikasi;
    }

    public function setTanggal_Verifikasi($Tanggal_Verifikasi, $id) {
        $this->Tanggal_Verifikasi = $Tanggal_Verifikasi;
        $sql = "UPDATE Pengumpulan SET Tanggal_Verifikasi = ? WHERE ID_Pengumpulan = ?";
        $params = [$Tanggal_Verifikasi, $id];
        $stmt = sqlsrv_query($this->conn, $sql, $params);

        return $stmt;
    }

    public function getKeterangan() {
        return $this->Keterangan;
    }

    public function setKeterangan($Keterangan, $id) {
        $this->Keterangan = $Keterangan;
        $sql = "UPDATE Pengumpulan SET Keterangan = ? WHERE ID_Pengumpulan = ?";
        $params = [$Keterangan, $id];
        $stmt = sqlsrv_query($this->conn, $sql, $params);

        return $stmt;
    }

    public function getVerifikatorKajur() {
        return $this->VerifikatorKajur;
    }

    public function setVerifikatorKajur($VerifikatorKajur, $id) {
        $this->VerifikatorKajur = $VerifikatorKajur;
        $sql = "UPDATE Pengumpulan SET VerifikatorKajur = ? WHERE ID_Pengumpulan = ?";
        $params = [$VerifikatorKajur, $id];
        $stmt = sqlsrv_query($this->conn, $sql, $params);

        return $stmt;
    }

    public function getVerifikatorKaprodi() {
        return $this->VerifikatorKaprodi;
    }

    public function setVerifikatorKaprodi($VerifikatorKaprodi, $id) {
        $this->VerifikatorKaprodi = $VerifikatorKaprodi;
        $sql = "UPDATE Pengumpulan SET VerifikatorKaprodi = ? WHERE ID_Pengumpulan = ?";
        $params = [$VerifikatorKaprodi, $id];
        $stmt = sqlsrv_query($this->conn, $sql, $params);

        return $stmt;
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
                a.ID_Administrasi,
                t.ID_Aplikasi,
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

    public function create($NIM, $Tanggal_Pengumpulan, $Status_Pengumpulan = "Menunggu", $Keterangan = "-") {
        $sql = "INSERT INTO Pengumpulan (NIM, Tanggal_Pengumpulan, Status_Pengumpulan, Keterangan) 
                OUTPUT INSERTED.ID_Pengumpulan 
                VALUES (?, ?, ?, ?)";
        $params = [$NIM, $Tanggal_Pengumpulan, $Status_Pengumpulan, $Keterangan];
        $stmt = sqlsrv_query($this->conn, $sql, $params);

        if (!$stmt) {
            throw new Exception("Gagal menyimpan data Pengumpulan: " . print_r(sqlsrv_errors(), true));
        }

        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        return $row['ID_Pengumpulan'] ?? null;
    }

    function editPengumpulan($NIM, $Tanggal_Pengumpulan, $Status_Pengumpulan, $Tanggal_Verifikasi, $VerifikatorKajur, $VerifikatorKaprodi, $Keterangan) {
        $sql = "UPDATE Pengumpulan SET Tanggal_Pengumpulan = ?, Status_Pengumpulan = ?,
                Tanggal_Verifikasi = ?, Keterangan = ?, VerifikatorKajur = ?, VerifikatorKaprodi = ?
                WHERE NIM = ?";
        $params = [
            $Tanggal_Pengumpulan,
            $Status_Pengumpulan,
            $Tanggal_Verifikasi,
            $Keterangan,
            $VerifikatorKajur,
            $VerifikatorKaprodi,
            $NIM
        ];

        var_dump($params);
        $stmt = sqlsrv_query($this->conn, $sql, $params);

        if ($stmt === false) {
            throw new Exception('Gagal menyimpan Mahasiswa: ' . print_r(sqlsrv_errors(), true));
        }
    }

    function getByNim ($NIM) {
        $sql = "SELECT a.Laporan_Skripsi, a.Laporan_Magang, a.Bebas_Kompensasi, a.Scan_Toeic,
            t.File_Aplikasi, t.Laporan_TA, t.Pernyataan_Publikasi, p.Tanggal_Pengumpulan, 
            p.Status_Pengumpulan, p.Keterangan, p.Tanggal_Verifikasi FROM Administrasi AS a INNER JOIN Pengumpulan AS p ON a.ID_Pengumpulan = p.ID_Pengumpulan INNER JOIN 
            TugasAKhir AS t ON t.ID_Pengumpulan = p.ID_Pengumpulan INNER JOIN Mahasiswa AS m ON p.NIM = m.NIM WHERE m.NIM = ?";
        $params = array($NIM);
        $stmt = sqlsrv_query($this->conn, $sql, $params);

        return sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    }

    public function getPengumpulanById($ID_Pengumpulan) {
        $sql = "SELECT ID_Pengumpulan, VerifikatorKajur, VerifikatorKaprodi FROM Pengumpulan WHERE ID_Pengumpulan = ?";
        $stmt = sqlsrv_query($this->conn, $sql, [$ID_Pengumpulan]);
        return sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    }


}
?>
