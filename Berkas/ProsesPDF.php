<?php
include "../Koneksi.php";

$db = new Database();
$conn = $db->getConnection();

function Berkas($conn) {

    global $namaMHS, $Prodi, $tglVrfAdm, $vrfAdm, $tglVrfTA, $vrfTA, $tglStrAdm, $tglStrTA, $tglStrBrks,
           $vrfKajur, $vrfKaprodi, $thnAngkatan, $ttdKajur, $ttdKaprodi;

    $NIM = $_GET['NIM'];

    $sql = "SELECT m.NIM, m.Nama, m.Prodi, m.Tahun_Angkatan FROM Administrasi AS a INNER JOIN Pengumpulan AS p ON a.ID_Pengumpulan = p.ID_Pengumpulan INNER JOIN 
            Mahasiswa AS m ON p.NIM = m.NIM WHERE m.NIM = ?";
    $params = array($NIM);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $namaMHS = $row['Nama'];
        $Prodi = $row['Prodi'];
        $thnAngkatan = $row['Tahun_Angkatan'];
    } 

    $sql2 = "SELECT a.Tanggal_Verifikasi, a.Verifikator FROM Administrasi AS a INNER JOIN Pengumpulan AS p ON a.ID_Pengumpulan = p.ID_Pengumpulan INNER JOIN 
            Mahasiswa AS m ON p.NIM = m.NIM WHERE m.NIM = ?";
    $params2 = array($NIM);
    $stmt2 = sqlsrv_query($conn, $sql2, $params2);

    if ($row2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)) {
        $tglVrfAdm = $row2['Tanggal_Verifikasi'];
        $tglStrAdm = $tglVrfAdm->format('d-m-Y');
        $vrfAdm = $row2['Verifikator'];
    }

    $sql3 = "SELECT a.Tanggal_Verifikasi, a.Verifikator FROM TugasAkhir AS a INNER JOIN Pengumpulan AS p ON a.ID_Pengumpulan = p.ID_Pengumpulan INNER JOIN 
            Mahasiswa AS m ON p.NIM = m.NIM WHERE m.NIM = ?";
    $params3 = array($NIM);
    $stmt3 = sqlsrv_query($conn, $sql3, $params3);

    if ($row3 = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC)) {
        $tglVrfTA = $row3['Tanggal_Verifikasi'];
        $tglStrTA = $tglVrfTA->format('d-m-Y');
        $vrfTA = $row3['Verifikator'];
    }

    $sql4 = "SELECT p.Tanggal_Verifikasi, p.VerifikatorKajur, p.VerifikatorKaprodi FROM Pengumpulan AS p INNER JOIN 
            Mahasiswa AS m ON p.NIM = m.NIM WHERE m.NIM = ?";
    $params4 = array($NIM);
    $stmt4 = sqlsrv_query($conn, $sql4, $params4);

    if ($row4 = sqlsrv_fetch_array($stmt4, SQLSRV_FETCH_ASSOC)) {
        $tglVrfBrks = $row4['Tanggal_Verifikasi'];
        $tglStrBrks = $tglVrfBrks->format('d-m-Y');
        $vrfKajur = $row4['VerifikatorKajur'];
        $vrfKaprodi = $row4['VerifikatorKaprodi'];
    }

    $sql6 = "SELECT s.Nama, s.TTD FROM Staff AS s WHERE s.Nama = ?";
    $params6 = array($vrfKaprodi);
    $stmt6 = sqlsrv_query($conn, $sql6, $params6);
    
    if ($stmt6 === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    
    if ($row6 = sqlsrv_fetch_array($stmt6, SQLSRV_FETCH_ASSOC)) {
        $ttdKaprodi = $row6['TTD'];
    } else {
        echo "Data TTD untuk Kaprodi tidak ditemukan!";
    }

    $sql7 = "SELECT s.Nama, s.TTD FROM Staff AS s WHERE s.Nama = ?";
    $parms7 = array($vrfKajur);
    $stmt7 = sqlsrv_query($conn, $sql7, $parms7);
    
    if ($stmt7 === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    
    if ($row7 = sqlsrv_fetch_array($stmt7, SQLSRV_FETCH_ASSOC)) {
        $ttdKajur = $row7['TTD'];
    } else {
        echo "Data TTD untuk Kaprodi tidak ditemukan!";
    }


}

?>
