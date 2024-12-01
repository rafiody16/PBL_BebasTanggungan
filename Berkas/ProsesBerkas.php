<?php 

include "../Koneksi.php";
include "../Login/Login.php";

session_start();

if (isset($_POST['simpanBerkas'])) {
    $NIM = $_SESSION['NIM'];
    $Tanggal_Pengumpulan = date("Y-m-d");
    $Laporan_Skripsi = $_POST['Laporan_Skripsi'];
    $Laporan_Magang = $_POST['Laporan_Magang'];
    $Bebas_Kompensasi = $_POST['Bebas_Kompensasi'];
    $Scan_Toeic = $_POST['Scan_Toeic'];
    $File_Aplikasi = $_POST['File_Aplikasi'];
    $Laporan_TA = $_POST['Laporan_TA'];
    $Pernyataan_Publikasi = $_POST['Pernyataan_Publikasi'];

    sqlsrv_begin_transaction($conn);

    try {
            $sqlPengumpulan = "INSERT INTO Pengumpulan (NIM, Tanggal_Pengumpulan, Status_Pengumpulan, Keterangan) 
                        OUTPUT INSERTED.ID_Pengumpulan 
                        VALUES (?, ?, ?, ?)";
            $paramsPengumpulan = [$NIM, $Tanggal_Pengumpulan, "Menunggu", ""];
            $stmtPengumpulan = sqlsrv_query($conn, $sqlPengumpulan, $paramsPengumpulan);

            if (!$stmtPengumpulan) {
                throw new Exception('Gagal menyimpan data Pengumpulan: ' . print_r(sqlsrv_errors(), true));
            }

            $rowIDPengumpulan = sqlsrv_fetch_array($stmtPengumpulan, SQLSRV_FETCH_ASSOC);
            $newIDPengumpulan = $rowIDPengumpulan['ID_Pengumpulan'];

            $sqlAdmin = "INSERT INTO Administrasi (ID_Pengumpulan, Laporan_Skripsi, Laporan_Magang, Scan_Toeic, Status_Verifikasi, Tanggal_Upload, Keterangan) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $paramsAdmin = [$newIDPengumpulan, $Laporan_Skripsi, $Laporan_Magang, $Scan_Toeic, "Menunggu", $Tanggal_Pengumpulan, ""];
            $stmtAdmin = sqlsrv_query($conn, $sqlAdmin, $paramsAdmin);

            if (!$stmtAdmin) {
                throw new Exception('Gagal menyimpan data Staff: ' . print_r(sqlsrv_errors(), true));
            }
            sqlsrv_commit($conn);
            echo "<script>alert('Data berhasil disimpan!'); window.location.href = 'TabelStaff.php';</script>";
    } catch (Exception $e) {
        sqlsrv_rollback($conn);
        echo "<script>alert('Data gagal disimpan! ".$e->getMessage() .  "'); window.location.href = 'TabelStaff.php';</script>";
    }
}

?>