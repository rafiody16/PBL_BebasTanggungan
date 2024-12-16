<?php 

require_once '../Koneksi.php';
require_once 'User.php';

class Mahasiswa extends User {
    private $NIM;
    private $Nama;
    private $Alamat;
    private $NoHp;
    private $JenisKelamin;
    private $Prodi;
    private $Tempat_Lahir;
    private $Tanggal_Lahir;
    private $Tahun_Angkatan;

    public function __construct($conn = null, $ID_User = null, $Username = null, $Password = null, $Email = null, $NIM = null, $Nama = null, $Alamat = null, $NoHp = null, $JenisKelamin = null, $Prodi = null, $Tempat_Lahir = null, $Tanggal_Lahir = null, $Tahun_Angkatan = null) {
        parent::__construct($conn, $ID_User, $Username, $Password, $Email);
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

    public function getNIM() {
        return $this->NIM;
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

    public function getProdi() {
        return $this->Prodi;
    }

    public function getTempatLahir() {
        return $this->Tempat_Lahir;
    }

    public function getTanggalLahir() {
        return $this->Tanggal_Lahir;
    }

    public function getTahunAngkatan() {
        return $this->Tahun_Angkatan;
    }

    public function findByNIM($NIM) {
        $sql = "SELECT u.ID_User, u.Username, u.Email, m.NIM, m.Nama, m.NoHp,
                m.Alamat, m.JenisKelamin, m.Tempat_Lahir, m.Tanggal_Lahir, m.Prodi, m.Tahun_Angkatan
                FROM [User] u
                JOIN Mahasiswa m ON u.ID_User = m.ID_User
                WHERE m.NIM = ?";
        $stmt = sqlsrv_query($this->conn, $sql, [$NIM]);
        if ($stmt === false) {
            return null;
        }
        return sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    }

    public function getAllMhs() {
        $prodi = isset($_GET['prodi']) ? $_GET['prodi'] : '';
        $tahunAngkatan = isset($_GET['tahunAngkatan']) ? $_GET['tahunAngkatan'] : '';

        $sql = "{CALL FilterMahasiswa(?, ?)}";
        $params = array($prodi, $tahunAngkatan);
        $stmt = sqlsrv_query($this->conn, $sql, $params);

        if ($stmt === false) {
            return null;
        }
        return $stmt;
    }

    public function saveMahasiswa($NIM, $Nama, $Alamat, $NoHp, $JenisKelamin, $Tempat_Lahir, $Tanggal_Lahir, $Prodi, $tahunAngkatan, $ID_User) {
        $sql = "INSERT INTO Mahasiswa (NIM, Nama, Alamat, NoHp, JenisKelamin, Tempat_Lahir, Tanggal_Lahir, Prodi, Tahun_Angkatan, ID_User)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $params = [
            $NIM,
            $Nama,
            $Alamat,
            $NoHp,
            $JenisKelamin,
            $Tempat_Lahir,
            $Tanggal_Lahir, // Ensure this is in 'YYYY-MM-DD' format
            $Prodi,
            $tahunAngkatan, // Ensure this is an integer
            $ID_User // Ensure this is an integer
        ];
        $stmt = sqlsrv_query($this->conn, $sql, $params);
    
        if ($stmt === false) {
            throw new Exception('Gagal menyimpan Mahasiswa: ' . print_r(sqlsrv_errors(), true));
        }
    }
    

    public function updateMahasiswa($Nama, $Alamat, $NoHp, $JenisKelamin, $Prodi, $tahunAngkatan, $Tempat_Lahir, $Tanggal_Lahir, $NIM) {
        $sql = "UPDATE Mahasiswa
                SET Nama = ?, Alamat = ?, NoHp = ?, JenisKelamin = ?, Prodi = ?, Tahun_Angkatan = ?, Tempat_Lahir = ?, Tanggal_Lahir = ?, NIM = ?
                WHERE NIM = ?";
        $params = [$Nama, $Alamat, $NoHp, $JenisKelamin, $Prodi, $tahunAngkatan, $Tempat_Lahir, $Tanggal_Lahir, $NIM];
        $stmt = sqlsrv_query($this->conn, $sql, $params);

        if ($stmt === false) {
            throw new Exception('Gagal memperbarui Mahasiswa: ' . print_r(sqlsrv_errors(), true));
        }
    }

}

?>