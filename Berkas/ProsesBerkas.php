<?php
include "../Koneksi.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'verifikasiAdministrasi':
        VerifikasiAdministrasi();
        break;
    case 'tolakAdministrasi':
        TolakAdministrasi();
        break;
    case 'detailAdministrasi':
        GetByIdAdministrasi();
        break;
    default:
        # code...
        break;
}

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

function VerifikasiAdministrasi() {
    global $conn;

    $ID_Administrasi = $_POST['ID_Administrasi'];
    $tgl_verifikasi = date("Y-m-d");
    $verifikator = $_SESSION['Nama'];

    $checkAdministrasiSql = "SELECT ID_Administrasi FROM Administrasi WHERE ID_Administrasi = ?";
    $checkAdministrasiStmt = sqlsrv_query($conn, $checkAdministrasiSql, [$ID_Administrasi]);
    $existingAdministrasi = sqlsrv_fetch_array($checkAdministrasiStmt, SQLSRV_FETCH_ASSOC);

    if ($existingAdministrasi) {
        $updateAdministrasiSql = "UPDATE Administrasi SET Status_Verifikasi = ?, Tanggal_Verifikasi = ?, Keterangan = ?, Verifikator = ?
                                  WHERE ID_Administrasi = ?";
        $paramsAdministrasiUpdate = ['Terverifikasi', $tgl_verifikasi, '', $verifikator,  $ID_Administrasi];
        $stmtAdministrasiUpdate = sqlsrv_query($conn, $updateAdministrasiSql, $paramsAdministrasiUpdate);

        if (!$stmtAdministrasiUpdate) {
            throw new Exception('Gagal memperbarui data Administrasi: ' . print_r(sqlsrv_errors(), true));
        }
    }
}

function TolakAdministrasi() {
    global $conn;

    $ID_Administrasi = $_POST['ID_Administrasi'];
    $Keterangan = $_POST['Keterangan'];
    $verifikator = $_SESSION['Nama'];

    $checkAdministrasiSql = "SELECT ID_Administrasi FROM Administrasi WHERE ID_Administrasi = ?";
    $checkAdministrasiStmt = sqlsrv_query($conn, $checkAdministrasiSql, [$ID_Administrasi]);
    $existingAdministrasi = sqlsrv_fetch_array($checkAdministrasiStmt, SQLSRV_FETCH_ASSOC);

    if ($existingAdministrasi) {
        $updateAdministrasiSql = "UPDATE Administrasi SET Status_Verifikasi = ?, Tanggal_Verifikasi = ?, Keterangan = ?, Verifikator = ?
                                  WHERE ID_Administrasi = ?";
        $paramsAdministrasiUpdate = ['Ditolak', NULL, $Keterangan, $verifikator, $ID_Administrasi];
        $stmtAdministrasiUpdate = sqlsrv_query($conn, $updateAdministrasiSql, $paramsAdministrasiUpdate);

        if (!$stmtAdministrasiUpdate) {
            throw new Exception('Gagal memperbarui data Administrasi: ' . print_r(sqlsrv_errors(), true));
        }
    }
}

function GetByIdAdministrasi() {
    global $conn;
    global $ID_Administrasi, $nim, $nama, $prodi, $laporanSkripsi, $laporanMagang, $bebasKompensasi, $scanToeic, $statusVerifikasi, $tanggalVerifikasi, $tanggalUpload, $keterangan, $verifikator;
    $ID_Administrasi = $_GET['ID_Administrasi'] ?? null;

    $sql = "SELECT a.ID_Administrasi, m.NIM, m.Nama, m.Prodi, a.Laporan_Skripsi, a.Laporan_Magang, a.Bebas_Kompensasi, a.Scan_Toeic, 
            a.Status_Verifikasi, a.Tanggal_Verifikasi, a.Tanggal_Upload, a.Keterangan, a.Verifikator FROM Administrasi AS a 
            INNER JOIN Pengumpulan AS p ON a.ID_Pengumpulan = p.ID_Pengumpulan INNER JOIN Mahasiswa AS m ON p.NIM = m.NIM WHERE a.ID_Administrasi = ?";
    $params = array($ID_Administrasi);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
        exit;
    }

    if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $nim = $row['NIM'];
        $nama = $row['Nama'];
        $prodi = $row['Prodi'];
        $laporanSkripsi = $row['Laporan_Skripsi'];
        $laporanMagang = $row['Laporan_Magang'];
        $bebasKompensasi = $row['Bebas_Kompensasi'];
        $scanToeic = $row['Scan_Toeic'];
        $statusVerifikasi = $row['Status_Verifikasi'];
        $tanggalVerifikasi = $row['Tanggal_Verifikasi'];
        $tanggalUpload = $row['Tanggal_Upload'];
        $keterangan = $row['Keterangan'];
        $verifikator = $row['Verifikator'];
    } else {
        echo "No data found for the given ID.";
    }

}

function GetByIdTA() {
    global $conn;
    global $ID_Aplikasi, $nim, $nama, $prodi, $fileaplikasi, $laporanta, $pertanyaanpublikasi, $scanToeic, $statusVerifikasi, $tanggalVerifikasi, $tanggalUpload, $keterangan, $verifikator;
    $ID_Aplikasi = $_GET['ID_Aplikasi'] ?? null;

    $sql = "SELECT a.ID_Administrasi, m.NIM, m.Nama, m.Prodi, a.Laporan_Skripsi, a.Laporan_Magang, a.Bebas_Kompensasi, a.Scan_Toeic, 
            a.Status_Verifikasi, a.Tanggal_Verifikasi, a.Tanggal_Upload, a.Keterangan, a.Verifikator FROM Administrasi AS a 
            INNER JOIN Pengumpulan AS p ON a.ID_Pengumpulan = p.ID_Pengumpulan INNER JOIN Mahasiswa AS m ON p.NIM = m.NIM WHERE a.ID_Administrasi = ?";
    $params = array($ID_Administrasi);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
        exit;
    }

    if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $nim = $row['NIM'];
        $nama = $row['Nama'];
        $prodi = $row['Prodi'];
        $laporanSkripsi = $row['Laporan_Skripsi'];
        $laporanMagang = $row['Laporan_Magang'];
        $bebasKompensasi = $row['Bebas_Kompensasi'];
        $scanToeic = $row['Scan_Toeic'];
        $statusVerifikasi = $row['Status_Verifikasi'];
        $tanggalVerifikasi = $row['Tanggal_Verifikasi'];
        $tanggalUpload = $row['Tanggal_Upload'];
        $keterangan = $row['Keterangan'];
        $verifikator = $row['Verifikator'];
    } else {
        echo "No data found for the given ID.";
    }

}

$sql = "SELECT a.ID_Administrasi, m.NIM, m.Nama, a.Status_Verifikasi, a.Keterangan FROM Administrasi AS a
        INNER JOIN Pengumpulan AS p ON a.ID_Pengumpulan = p.ID_Pengumpulan INNER JOIN Mahasiswa AS m ON p.NIM = m.NIM";
$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$sql2 = "SELECT a.ID_Aplikasi, m.NIM, m.Nama, a.Status_Verifikasi, a.Keterangan FROM TugasAkhir AS a
        INNER JOIN Pengumpulan AS p ON a.ID_Pengumpulan = p.ID_Pengumpulan INNER JOIN Mahasiswa AS m ON p.NIM = m.NIM";
$stmt2 = sqlsrv_query($conn, $sql2);

if ($stmt2 === false) {
    die(print_r(sqlsrv_errors(), true));
}

?>
