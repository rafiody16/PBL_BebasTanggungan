<?php 
class Database 
{
    private $serverName = "DESKTOP-L75SO4G";
    private $connectionInfo = ["Database" => "PBLBebasTanggungan"];
    public $conn;

    public function __construct() {
        // Inisialisasi koneksi di dalam konstruktor
        $this->conn = sqlsrv_connect($this->serverName, $this->connectionInfo);
        $this->ifNotConnect(); // Panggil fungsi cek koneksi setelah inisialisasi
    }

    function ifNotConnect() {
        if ($this->conn === false) {
            die(print_r(sqlsrv_errors(), true)); 
        }
    }
}
?>