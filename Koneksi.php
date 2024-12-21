<?php

class Database {
    private $serverName;
    private $connectionInfo;
    public $conn;

    // Constructor: Initialize and connect to the database
    public function __construct($serverName = "DESKTOP-L75SO4G", $connectionInfo = []) {
        $defaultConnectionInfo = [
            "Database" => "PBLBebasTanggungan",
            "CharacterSet" => "UTF-8"
        ];
        $this->serverName = $serverName;
        $this->connectionInfo = array_merge($defaultConnectionInfo, $connectionInfo);

        $this->conn = sqlsrv_connect($this->serverName, $this->connectionInfo);

        if ($this->conn === false) {
            throw new Exception("Database connection failed: " . print_r(sqlsrv_errors(), true));
        }
    }

    // Return the database connection
    public function getConnection() {
        return $this->conn;
    }

    // Check if connected
    public function isConnected() {
        return $this->conn !== false;
    }

    // Destructor: Close the connection
    public function __destruct() {
        if ($this->conn) {
            sqlsrv_close($this->conn);
        }
    }
}

?>
