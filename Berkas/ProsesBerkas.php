<?php
include "../Koneksi.php";

session_start();

if (isset($_POST['simpanBerkas'])) {
    $NIM = $_SESSION['NIM'] ?? null;
    $Tanggal_Pengumpulan = date("Y-m-d");
    $Laporan_Skripsi = $_POST['Laporan_Skripsi'] ?? '';
    $Laporan_Magang = $_POST['Laporan_Magang'] ?? '';
    $Bebas_Kompensasi = $_POST['Bebas_Kompensasi'] ?? '';
    $Scan_Toeic = $_POST['Scan_Toeic'] ?? '';
    $File_Aplikasi = $_POST['File_Aplikasi'] ?? '';
    $Laporan_TA = $_POST['Laporan_TA'] ?? '';
    $Pernyataan_Publikasi = $_POST['Pernyataan_Publikasi'] ?? '';

    if (!$NIM) {
        echo "Session tidak valid atau NIM kosong.";
        exit;
    }

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

        $sqlAdmin = "INSERT INTO Administrasi (ID_Pengumpulan, Laporan_Skripsi, Laporan_Magang, Bebas_Kompensasi, Scan_Toeic, Status_Verifikasi, Tanggal_Upload, Keterangan) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $paramsAdmin = [$newIDPengumpulan, $Laporan_Skripsi, $Laporan_Magang, $Bebas_Kompensasi, $Scan_Toeic, "Menunggu", $Tanggal_Pengumpulan, ""];
        $stmtAdmin = sqlsrv_query($conn, $sqlAdmin, $paramsAdmin);

        if (!$stmtAdmin) {
            throw new Exception('Gagal menyimpan data Administrasi: ' . print_r(sqlsrv_errors(), true));
        }

        $sqlTA = "INSERT INTO TugasAkhir (ID_Pengumpulan, File_Aplikasi, Laporan_TA, Pernyataan_Publikasi, Status_Verifikasi, Tanggal_Upload, Keterangan) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $paramsTA = [$newIDPengumpulan, $File_Aplikasi, $Laporan_TA, $Pernyataan_Publikasi, "Menunggu", $Tanggal_Pengumpulan, ""];
        $stmtTA = sqlsrv_query($conn, $sqlTA, $paramsTA);

        if (!$stmtTA) {
            throw new Exception('Gagal menyimpan data Tugas Akhir: ' . print_r(sqlsrv_errors(), true));
        }

        sqlsrv_commit($conn);
        echo "<script>alert('Data berhasil disimpan!'); window.location.href = 'FormBerkas.php';</script>";
    } catch (Exception $e) {
        sqlsrv_rollback($conn);
        echo "Data gagal disimpan: " . $e->getMessage();
    }
}

$sql = "SELECT m.NIM, m.Nama, a.Status_Verifikasi, a.Keterangan FROM Administrasi AS a
        INNER JOIN Pengumpulan AS p ON a.ID_Pengumpulan = p.ID_Pengumpulan INNER JOIN Mahasiswa AS m ON p.NIM = m.NIM";
$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

?>
