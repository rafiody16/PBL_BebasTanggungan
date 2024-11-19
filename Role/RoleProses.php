<?php 

include "../Koneksi.php";

if (isset($_POST['simpanRole'])) {
    $Role_ID = $_POST['Role_ID'] ?? null;
    $Nama_Role = $_POST['Nama_Role'] ?? null;
    $Deskripsi = $_POST['Deskripsi'] ?? null;
    $Level_Akses = $_POST['Level_Akses'] ?? null;

    if ($Role_ID || !$Nama_Role || !$Deskripsi || !$Level_Akses) {
        echo "<script>alert('Masukkan inputan data role.'); window.location.href = 'FormRole.php';</script>";
        exit();
    }

    $sql = "INSERT INTO [Role] (Nama_Role, Deskripsi, Level_Akses) VALUES (?, ?, ?)";
    $params = array($Nama_Role, $Deskripsi, $Level_Akses);


    $input = sqlsrv_query($conn, $sql, $params);

    if ($input === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if ($input) {
        echo "<script>alert('Data successfully saved.'); window.location.href = 'FormRole.php';</script>";
    } else {
        echo "<script>alert('Data saving failed.'); window.location.href = 'FormRole.php';</script>";
    }

    sqlsrv_free_stmt($input);
    sqlsrv_close($conn);
}

$sql = "SELECT * FROM [Role]";
$stmt = sqlsrv_query($conn, $sql);

// Check if query was successful
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

?>
