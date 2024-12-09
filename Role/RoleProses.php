<?php 

include "../Koneksi.php";

if (isset($_POST['simpanRole'])) {
    $Role_ID = $_POST['Role_ID'];
    $Nama_Role = $_POST['Nama_Role'] ?? null;
    $Deskripsi = $_POST['Deskripsi'] ?? null;

    $sql = "INSERT INTO Role (Role_ID, Nama_Role, Deskripsi) VALUES (?,?, ?)";
    $params = array($Role_ID, $Nama_Role, $Deskripsi);


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

function getRoleById() {
    global $conn;
    global $Role_ID, $nama, $keterangan;
    $Role_ID = $_GET['Role_ID'] ?? null;
    $sql = "SELECT * FROM [Role] WHERE Role_ID = ?";
    $params = array($Role_ID);
    $stmt = sqlsrv_query($conn, $sql, $params);
    
    if ($stmt === false) {
        echo "Query failed: ";
        print_r(sqlsrv_errors());
        exit;
    }
    
    if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $Role_ID = $row['Role_ID'];
        $nama = $row['Nama'];
        $keterangan = $row['Keterangan'];
    } else {
        echo "No data found for the given NIP.";
    }
}


$sql = "SELECT * FROM [Role]";
$stmt = sqlsrv_query($conn, $sql);

// Check if query was successful
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

?>
