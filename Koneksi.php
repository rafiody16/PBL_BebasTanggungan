<?php 
class Database {
    private $serverName = "LAPTOP-6DB90827";
    private $connectionInfo = ["Database" => "PBLBebasTanggungan"];
    public $conn;

    public function __construct() {
        $this->conn = sqlsrv_connect($this->serverName, $this->connectionInfo);
        if ($this->conn === false) {
            die(print_r(sqlsrv_errors(), true));  // Menangani koneksi gagal
        }
    }
}

?>