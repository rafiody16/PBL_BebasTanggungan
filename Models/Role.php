<?php

class Role {
    private $conn;
    private $roleId;
    private $namaRole;
    private $deskripsi;

    public function __construct($conn, $roleId = null, $namaRole = null, $deskripsi = null) {
        $this->conn = $conn;
        $this->roleId = $roleId;
        $this->namaRole = $namaRole;
        $this->deskripsi = $deskripsi;
    }

    public function saveRole($roleId, $namaRole, $deskripsi) {
        $sql = "INSERT INTO [Role] (Role_ID, Nama_Role, Deskripsi) VALUES (?, ?, ?)";
        $params = array($roleId, $namaRole, $deskripsi);
        $stmt = sqlsrv_query($this->conn, $sql, $params);
        
        if ($stmt === false) {
            throw new Exception('Failed to save role: ' . print_r(sqlsrv_errors(), true));
        }
        
        return $stmt;
    }

    public function updateRole($roleId, $namaRole, $deskripsi) {
        $sql = "UPDATE [Role] SET Nama_Role = ?, Deskripsi = ? WHERE Role_ID = ?";
        $params = array($namaRole, $deskripsi, $roleId);
        $stmt = sqlsrv_query($this->conn, $sql, $params);
        
        if ($stmt === false) {
            throw new Exception('Failed to update role: ' . print_r(sqlsrv_errors(), true));
        }
        return $stmt;
    }

    public function deleteRole($roleId) {
        $sql = "DELETE FROM [Role] WHERE Role_ID = ?";
        $params = array($roleId);
        $stmt = sqlsrv_query($this->conn, $sql, $params);
        
        if ($stmt === false) {
            throw new Exception('Failed to delete role: ' . print_r(sqlsrv_errors(), true));
        }
        
        return $stmt;
    }

    public function findById($roleId) {
        $sql = "SELECT * FROM [Role] WHERE Role_ID = ?";
        $params = array($roleId);
        $stmt = sqlsrv_query($this->conn, $sql, $params);
        
        if ($stmt === false) {
            throw new Exception('Query failed: ' . print_r(sqlsrv_errors(), true));
        }
        
        return sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    }
}