<?php
$host = "LAPTOP-6DB90827";
$connInfo = array("Database" => "TSQL2012", "UID" => "", "PWD" => "");
$conn = sqlsrv_connect($host, $connInfo);

if ($conn) {
    echo "Kondeksi berhasil.<br/>";
} else {
    echo "Koneksi Gagal";
    die(print_r(sqlsrv_errors(), true));
}

?>