<?php 

include "../Koneksi.php";

if (isset($_POST['simpanUser'])) {
    $ID_User = $_POST['ID_User'] ?? null;
    $Username = $_POST['Username'] ?? null;
    $Email = $_POST['Email'] ?? null;
    $Password = $_POST['Password'] ?? null;
    $Role_ID = $_POST['Role_ID'] ?? null;

    // Validate that none of the required fields are empty
    if (!$ID_User || !$Username || !$Email || !$Password || !$Role_ID) {
        echo "<script>alert('Please fill in all required fields.'); window.location.href = 'FormLogin.php';</script>";
        exit();
    }

    // Insert query using parameterized SQL to prevent SQL injection
    $sql = "INSERT INTO [User] (ID_User, Username, Email, [Password], Role_ID) VALUES (?, ?, ?, ?, ?)";
    $params = array($ID_User, $Username, $Email, $Password, $Role_ID);

    // Execute the query
    $input = sqlsrv_query($conn, $sql, $params);

    if ($input === false) {
        // Display SQL Server errors if the query fails
        die(print_r(sqlsrv_errors(), true));
    }

    if ($input) {
        echo "<script>alert('Data successfully saved.'); window.location.href = 'TabelUser.php';</script>";
    } else {
        echo "<script>alert('Data saving failed.'); window.location.href = 'FormLogin.php';</script>";
    }

    sqlsrv_free_stmt($input);
}

$sql = "SELECT u.ID_User, u.Username, u.Password, u.Email, r.Nama_Role FROM [User] as u INNER JOIN [Role] as r
        ON u.Role_ID = r.Role_ID";
$stmt = sqlsrv_query($conn, $sql);

// Check if query was successful
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

?>
