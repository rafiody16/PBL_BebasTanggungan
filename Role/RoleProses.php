<?php 

include "../Koneksi.php";

if (isset($_POST['simpanRole'])) {
    $Nama_Role = $_POST['Nama_Role'] ?? null;
    $Deskripsi = $_POST['Deskripsi'] ?? null;
    $Level_Akses = $_POST['Level_Akses'] ?? null;

    $sql = "INSERT INTO Role (Nama_Role, Deskripsi, Level_Akses) VALUES (?, ?, ?)";
    $params = array($Nama_Role, $Deskripsi, $Level_Akses);


    $input = sqlsrv_query($conn, $sql, $params);

    if ($input === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if ($input) {
        echo "<script>alert('Data successfully saved.'); window.location.href = 'TabelRole.php';</script>";
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
