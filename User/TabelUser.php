<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/formuser.css">
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" rel="stylesheet"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
</head>
<body>
    <div class="container-fluid">
        <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">ID User</th>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
              </tr>
            </thead>
            <tbody>
            <?php 
                include '../Koneksi.php';
                $no = 1;
                $sql = "SELECT us.ID_User, us.Username, us.Email, r.Nama_Role FROM [User] AS us INNER JOIN [ROLE] as r ON us.ID_User = r.Role_ID;";
                $params = array();
                $stmt = sqlsrv_query($conn, $sql, $params);

                while ($rec = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    if ($rec !== null) {
                        ?>
                        <tr>
                            <th scope="row"><?= $no ?></th>
                            <td><?= $rec['ID_User'] ?></td>
                            <td><?= $rec['Username'] ?></td>
                            <td><?= $rec['Email'] ?></td>
                            <td><?= $rec['Nama_Role'] ?></td>
                        </tr>
                        <?php
                        $no++;
                    }
                }
            ?>
            </tbody>
        </table>
    </div>
</body>
</html>