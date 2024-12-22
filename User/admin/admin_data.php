<?php

require_once '../../Koneksi.php';

class Staff {
    private $NIP;
    private $Nama;
    private $Alamat;
    private $NoHp;
    private $JenisKelamin;
    private $Tempat_Lahir;
    private $Tanggal_Lahir;
    private $TTD;
    protected $conn;

    public function __construct($conn = null, $ID_User = null, $Username = null, $Password = null, $Email = null, $Role_ID = null, $NIP = null, $Nama = null, 
                                $Alamat = null, $NoHp = null, $JenisKelamin = null, $Tempat_Lahir = null, $Tanggal_Lahir = null, $TTD = null) {
        $this->NIP = $NIP;
        $this->conn = $conn;
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
        $sql = "SELECT Staff.Nama, Staff.Alamat, Staff.NoHp, Staff.Tempat_Lahir, Staff.Tanggal_Lahir, Staff.JenisKelamin, 
                Staff.TTD, [User].Username, [User].Password, [User].Email, [User].Role_ID, [Role].Nama_Role 
                FROM Staff INNER JOIN [User] ON Staff.ID_User = [User].ID_User  
                INNER JOIN [Role] ON [User].Role_ID = [Role].Role_ID WHERE Staff.NIP = ?";
        $stmt = sqlsrv_query($this->conn, $sql, [$NIP]);
        if ($stmt === false) {
            return null;
        }
        return sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    }

}

?>