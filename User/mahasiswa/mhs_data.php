<?php
function getDataMahasiswaByID() {
    global $conn;
    global $nim, $nama, $username, $email, $password, $alamat, $noHp, $roleID, $Prodi, $TahunAngkatan, $jeniskelamin, $Tempat_Lahir, $Tanggal_Lahir;
    $id = $_SESSION['ID_User'] ?? null; // Mengambil ID dari session
    $sql = "SELECT Mahasiswa.NIM, Mahasiswa.Nama, Mahasiswa.Alamat, Mahasiswa.NoHp, Mahasiswa.Prodi, Mahasiswa.Tahun_Angkatan, 
            Mahasiswa.JenisKelamin, Mahasiswa.Tempat_Lahir, Mahasiswa.Tanggal_Lahir, [User ].Username, [User ].Password, [User ].Email, [User ].Role_ID FROM Mahasiswa INNER JOIN [User ] ON Mahasiswa.ID_User = [User ].ID_User WHERE Mahasiswa.ID_User = ?"; // Pastikan kolom ID sesuai dengan yang ada di database
    $params = array($id);
    $stmt = sqlsrv_query($conn, $sql, $params);
    
    if ($stmt === false) {
        echo "Query failed: ";
        print_r(sqlsrv_errors());
        exit;
    }
    
    if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        // Populate the form fields with existing data
        $nim = $row['NIM'];
        $nama = $row['Nama'];
        $username = $row['Username'];
        $email = $row['Email'];
        $password = $row['Password']; // Enkripsi password
        $alamat = $row['Alamat'];
        $noHp = $row['NoHp'];
        $Prodi = $row['Prodi'];
        $Tempat_Lahir = $row['Tempat_Lahir'];
        $Tanggal_Lahir = $row['Tanggal_Lahir'];
        $TahunAngkatan = $row['Tahun_Angkatan'];
        $jeniskelamin = $row['JenisKelamin'];
        $roleID = $row['Role_ID']; // Assuming you still want to keep roleID
    } else {
        echo "No data found for the given ID.";
    }
}
?>