<?php

require_once '../Koneksi.php';

class Staff extends User {
    private $NIP;
    private $Nama;
    private $Alamat;
    private $NoHp;
    private $JenisKelamin;
    private $Tempat_Lahir;
    private $Tanggal_Lahir;
    private $TTD;

    public function __construct($conn,$ID_User, $Username, $Password, $Email, $Role_ID, $NIP, $Nama, $Alamat, $NoHp, $JenisKelamin, $Tempat_Lahir, $Tanggal_Lahir, $TTD) {
        parent::__construct($conn,$ID_User, $Username, $Password, $Email, $Role_ID);
        $this->NIP = $NIP;
        $this->Nama = $Nama;
        $this->Alamat = $Alamat;
        $this->NoHp = $NoHp;
        $this->JenisKelamin = $JenisKelamin;
        $this->Tempat_Lahir = $Tempat_Lahir;
        $this->Tanggal_Lahir = $Tanggal_Lahir;
        $this->TTD = $TTD;
    }

    public function getNIP() {
        return $this->NIP;
    }

    public function getNama() {
        return $this->Nama;
    }

    public function getAlamat() {
        return $this->Alamat;
    }

    public function getNoHp() {
        return $this->NoHp;
    }

    public function getJenisKelamin() {
        return $this->JenisKelamin;
    }

    public function getTempatLahir() {
        return $this->Tempat_Lahir;
    }

    public function getTanggalLahir() {
        return $this->Tanggal_Lahir;
    }

    public function getTTD() {
        return $this->TTD;
    }

    public function findByNIP($NIP) {
        $sql = "SELECT * FROM Staff WHERE NIP = ?";
        $stmt = sqlsrv_query($this->conn, $sql, [$NIP]);
        if ($stmt === false) {
            return null;
        }
        return sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    }

    public function saveStaff($NIP, $Nama, $Alamat, $NoHp, $JenisKelamin, $Tempat_Lahir, $Tanggal_Lahir, $TTD, $ID_User) {
        $sql = "INSERT INTO Staff (NIP, Nama, Alamat, NoHp, JenisKelamin, Tempat_Lahir, Tanggal_Lahir, TTD, ID_User)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $params = [$NIP, $Nama, $Alamat, $NoHp, $JenisKelamin, $Tempat_Lahir, $Tanggal_Lahir, $TTD, $ID_User];
        $stmt = sqlsrv_query($this->conn, $sql, $params);

        if ($stmt === false) {
            throw new Exception('Gagal menyimpan Staff: ' . print_r(sqlsrv_errors(), true));
        }
    }

    public function updateStaff($Nama, $Alamat, $NoHp, $JenisKelamin, $Tempat_Lahir, $Tanggal_Lahir, $TTD, $NIP) {
        $sql = "UPDATE Staff
                SET Nama = ?, Alamat = ?, NoHp = ?, JenisKelamin = ?, Tempat_Lahir = ?, Tanggal_Lahir = ?, TTD = ?
                WHERE NIP = ?";
        $params = [$Nama, $Alamat, $NoHp, $JenisKelamin, $Tempat_Lahir, $Tanggal_Lahir, $TTD, $NIP];
        $stmt = sqlsrv_query($this->conn, $sql, $params);

        if ($stmt === false) {
            throw new Exception('Gagal memperbarui Staff: ' . print_r(sqlsrv_errors(), true));
        }
    }

}

?>