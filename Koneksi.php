<?php

class Database {
    private $serverName = "DESKTOP-L75SO4G";
    private $connectionInfo = [
        "Database" => "PBLBebasTanggungan",
        "CharacterSet" => "UTF-8"
    ];
    public $conn;

    // Menghubungkan ke database saat membuat objek Database
    public function __construct() {
        $this->conn = sqlsrv_connect($this->serverName, $this->connectionInfo);

        if ($this->conn === false) {
            die("Koneksi ke database gagal: " . print_r(sqlsrv_errors(), true));
        }
    }

    // Mengembalikan koneksi database
    public function getConnection() {
        return $this->conn;
    }
}

?>
