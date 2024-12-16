<?php 

require_once '../Koneksi.php';

class User {
    protected $ID_User;
    protected $Username;
    protected $Password;
    protected $Email;
    protected $Role_ID;
    protected $conn;

    public function __construct($conn = null, $Username = null, $Password = null, $Email = null, $Role_ID = null) {
        $this->conn = $conn;
        // $this->ID_User = $ID_User;
        $this->Username = $Username;
        $this->Password = $Password;
        $this->Email = $Email;
        $this->Role_ID = $Role_ID;
    }

    public function getIDUser() {
        return $this->ID_User;
    }

    public function getUsername() {
        return $this->Username;
    }

    public function getEmail() {
        return $this->Email;
    }

    public function getRoleID() {
        return $this->Role_ID;
    }

    public function getConn() {
        return $this->conn;
    }

    public function setUsername($Username) {
        $this->Username = $Username;
    }

    public function setPassword($Password) {
        $this->Password = $Password;
    }

    public function setEmail($Email) {
        $this->Email = $Email;
    }

    public function setRoleID($Role_ID) {
        $this->Role_ID = $Role_ID;
    }

    public function findByNIP($NIP) {
        $sql = "SELECT u.ID_User, u.Username, u.Email, u.Role_ID, s.TTD 
                FROM [User] u
                JOIN Staff s ON u.ID_User = s.ID_User
                WHERE s.NIP = ?";
        $stmt = sqlsrv_query($this->conn, $sql, [$NIP]);
        if ($stmt === false) {
            return null;
        }
        return sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    }

    public function findByNIM($NIM) {
        $sql = "SELECT u.ID_User, u.Username, u.Email, u.Role_ID 
                FROM [User] u
                JOIN Mahasiswa m ON u.ID_User = s.ID_User
                WHERE m.NIM = ?";
        $stmt = sqlsrv_query($this->conn, $sql, [$NIM]);
        if ($stmt === false) {
            return null;
        }
        return sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    }

    public function saveUser($username, $password, $email, $roleId) {
        $sql = "INSERT INTO [User] (Username, [Password], Email, Role_ID)
                OUTPUT INSERTED.ID_User
                VALUES (?, ?, ?, ?)";
        $params = [$username, $password, $email, $roleId];
        $stmt = sqlsrv_query($this->conn, $sql, $params);

        if ($stmt === false) {
            throw new Exception('Gagal menyimpan User: ' . print_r(sqlsrv_errors(), true));
        }

        return sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)['ID_User'];
    }

    public function saveUserMhs($username, $password, $email, $roleId) {
        $sql = "INSERT INTO [User] (Username, [Password], Email, Role_ID)
                OUTPUT INSERTED.ID_User
                VALUES (?, ?, ?, 8)";
        $params = [$username, $password, $email, $roleId];
        $stmt = sqlsrv_query($this->conn, $sql, $params);

        if ($stmt === false) {
            throw new Exception('Gagal menyimpan User: ' . print_r(sqlsrv_errors(), true));
        }

        return sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)['ID_User'];
    }

    public function updateUser($username, $email, $roleId, $NIP) {
        $sql = "UPDATE [User]
                SET Username = ?, Email = ?, Role_ID = ?
                WHERE ID_User = (SELECT ID_User FROM Staff WHERE NIP = ?)";
        $params = [$username, $email, $roleId, $NIP];
        $stmt = sqlsrv_query($this->conn, $sql, $params);

        if ($stmt === false) {
            throw new Exception('Gagal memperbarui User: ' . print_r(sqlsrv_errors(), true));
        }
    }

    public function updateUserMhs($username, $email, $NIM) {
        $sql = "UPDATE [User]
                SET Username = ?, Email = ?
                WHERE ID_User = (SELECT ID_User FROM Mahasiswa WHERE NIM = ?)";
        $params = [$username, $email, $NIM];
        $stmt = sqlsrv_query($this->conn, $sql, $params);
    
        if ($stmt === false) {
            throw new Exception('Gagal memperbarui User Mahasiswa: ' . print_r(sqlsrv_errors(), true));
        }
    }

}

?>