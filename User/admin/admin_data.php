<?php
function getDataStaffByID() {
    global $conn;
    global $nip, $nama, $username, $email, $password, $alamat, $noHp, $roleID, $Nama_Role, $jeniskelamin, $Tempat_Lahir, $Tanggal_Lahir;
    $id = $_SESSION['ID_User'] ?? null; // Mengambil ID dari parameter GET
    $sql = "SELECT Staff.NIP, Staff.Nama, Staff.Alamat, Staff.NoHp, Staff.Tempat_Lahir, Staff.Tanggal_Lahir, Staff.JenisKelamin, [User].Username, [User].Password, [User].Email, [User ].Role_ID, [Role].Nama_Role FROM Staff INNER JOIN [User ] ON Staff.ID_User = [User ].ID_User  INNER JOIN [Role] ON [User ].Role_ID = [Role].Role_ID WHERE Staff.ID_User = ?"; // Pastikan kolom ID sesuai dengan yang ada di database
    $params = array($id);
    $stmt = sqlsrv_query($conn, $sql, $params);
    
    if ($stmt === false) {
        echo "Query failed: ";
        print_r(sqlsrv_errors());
        exit;
    }
    
    if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        // Populate the form fields with existing data
        $nip = $row['NIP'];
        $nama = $row['Nama'];
        $username = $row['Username'];
        $email = $row['Email'];
        $password = $row['Password'];
        $alamat = $row['Alamat'];
        $noHp = $row['NoHp'];
        $Tempat_Lahir = $row['Tempat_Lahir'];
        $Tanggal_Lahir = $row['Tanggal_Lahir'];
        $roleID = $row['Role_ID'];
        $Nama_Role = $row['Nama_Role'];
        $jeniskelamin = $row['JenisKelamin'];
    } else {
        echo "No data found for the given ID.";
    }
}
?>