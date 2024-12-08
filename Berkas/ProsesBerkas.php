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
    case 'detailTA':
        GetByIdAdministrasi();
        break;
    case 'verifikasiTA':
        VerifikasiTA();
        break;
    case 'tolakTA':
        TolakTA();
        break;
    case 'tolakBerkas':
        TolakBerkas();
        break;
    case 'editTA':
        echo "Edit TA function is triggered<br>";
        EditTA();
        break;
    case 'editAdministrasi':
        EditAdministrasi();
        break;
    case 'tampilBerkas':
        GetAllBerkas();
        break;
    case 'verifikasiBerkas':
        VerifikasiBerkas();
        break;
    default:
        # code...
        break;
}

if (isset($_POST['simpanBerkas'])) {
    $NIM = $_SESSION['NIM'] ?? null;
    $Tanggal_Pengumpulan = date("Y-m-d");

    if (!$NIM) {
        echo "Session tidak valid atau NIM kosong.";
        exit;
    }

    $sqlCheck = "SELECT COUNT(*) FROM Pengumpulan WHERE NIM = ?";
    $paramsCheck = [$NIM];
    $stmtCheck = sqlsrv_query($conn, $sqlCheck, $paramsCheck);

    $uploadDir = "../Uploads/";

    $rowCheck = sqlsrv_fetch_array($stmtCheck, SQLSRV_FETCH_ASSOC);
    if ($rowCheck['COUNT(*)'] > 0) {
        echo "<script>window.location.href = 'DetailBerkas.php?NIM=".urlencode($NIM)."';</script>";
    }

    function uploadFile($file, $uploadDir) {
        $fileName = basename($file['name']);
        $targetFilePath = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
            return $fileName; 
        } else {
            return false; 
        }
    }

    $Laporan_Skripsi = uploadFile($_FILES['Laporan_Skripsi'], $uploadDir);
    $Laporan_Magang = uploadFile($_FILES['Laporan_Magang'], $uploadDir);
    $Bebas_Kompensasi = uploadFile($_FILES['Bebas_Kompensasi'], $uploadDir);
    $Scan_Toeic = uploadFile($_FILES['Scan_Toeic'], $uploadDir);
    $File_Aplikasi = uploadFile($_FILES['File_Aplikasi'], $uploadDir);
    $Laporan_TA = uploadFile($_FILES['Laporan_TA'], $uploadDir);
    $Pernyataan_Publikasi = uploadFile($_FILES['Pernyataan_Publikasi'], $uploadDir);

    if (
        !$Laporan_Skripsi || !$Laporan_Magang || !$Bebas_Kompensasi ||
        !$Scan_Toeic || !$File_Aplikasi || !$Laporan_TA || !$Pernyataan_Publikasi
    ) {
        echo "Gagal mengunggah salah satu file. Pastikan ukuran file tidak melebihi batas.";
        exit;
    }

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
        echo "<script>alert('Data berhasil disimpan!'); window.location.href = 'DetailBerkas.php?NIM=".urlencode($NIM)."';</script>";
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
        $paramsAdministrasiUpdate = ['Terverifikasi', $tgl_verifikasi, '-', $verifikator,  $ID_Administrasi];
        $stmtAdministrasiUpdate = sqlsrv_query($conn, $updateAdministrasiSql, $paramsAdministrasiUpdate);

        if (!$stmtAdministrasiUpdate) {
            throw new Exception('Gagal memperbarui data Administrasi: ' . print_r(sqlsrv_errors(), true));
        }
    }
}

function VerifikasiTA() {
    global $conn;

    $ID_Aplikasi = $_POST['ID_Aplikasi'];
    $tgl_verifikasi = date("Y-m-d");
    $verifikator = $_SESSION['Nama'];

    $checkTASql = "SELECT ID_Aplikasi FROM TugasAkhir WHERE ID_Aplikasi = ?";
    $checkTAStmt = sqlsrv_query($conn, $checkTASql, [$ID_Aplikasi]);
    $existingTA = sqlsrv_fetch_array($checkTAStmt, SQLSRV_FETCH_ASSOC);

    if ($existingTA) {
        $updateTASql = "UPDATE TugasAkhir SET Status_Verifikasi = ?, Tanggal_Verifikasi = ?, Keterangan = ?, Verifikator = ?
                                  WHERE ID_Aplikasi = ?";
        $paramsTAUpdate = ['Terverifikasi', $tgl_verifikasi, '-', $verifikator,  $ID_Aplikasi];
        $stmtTAUpdate = sqlsrv_query($conn, $updateTASql, $paramsTAUpdate);

        if (!$stmtTAUpdate) {
            throw new Exception('Gagal memperbarui data TA: ' . print_r(sqlsrv_errors(), true));
        }
    }
}

function TolakTA() {
    global $conn;

    $ID_Aplikasi = $_POST['ID_Aplikasi'];
    $Keterangan = $_POST['Keterangan'];
    $verifikator = $_SESSION['Nama'];

    $checkTASql = "SELECT ID_Aplikasi FROM TugasAkhir WHERE ID_Aplikasi = ?";
    $checkTAStmt = sqlsrv_query($conn, $checkTASql, [$ID_Aplikasi]);
    $existingTA = sqlsrv_fetch_array($checkTAStmt, SQLSRV_FETCH_ASSOC);

    if ($existingTA) {
        $updateTASql = "UPDATE TugasAkhir SET Status_Verifikasi = ?, Tanggal_Verifikasi = ?, Keterangan = ?, Verifikator = ?
                        WHERE ID_Aplikasi = ?";
        $paramsTAUpdate = ['Ditolak', NULL, $Keterangan, $verifikator, $ID_Aplikasi];
        $stmtTAUpdate = sqlsrv_query($conn, $updateTASql, $paramsTAUpdate);

        if (!$stmtTAUpdate) {
            throw new Exception('Gagal memperbarui data TA: ' . print_r(sqlsrv_errors(), true));
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

function VerifikasiBerkas() {
    global $conn;

    $ID_Pengumpulan = $_POST['ID_Pengumpulan'];
    $tgl_verifikasi = date("Y-m-d");
    $verifikator = $_SESSION['Nama'];
    $role = $_SESSION['Role_ID'];

    $checkBerkasSql = "SELECT ID_Pengumpulan, VerifikatorKajur, VerifikatorKaprodi FROM Pengumpulan WHERE ID_Pengumpulan = ?";
    $checkBerkasStmt = sqlsrv_query($conn, $checkBerkasSql, [$ID_Pengumpulan]);
    $existingBerkas = sqlsrv_fetch_array($checkBerkasStmt, SQLSRV_FETCH_ASSOC);

    if ($existingBerkas) {
        if ($role === 2) {
            $updateKajurSql = "UPDATE Pengumpulan SET VerifikatorKajur = ?, Keterangan = ? WHERE ID_Pengumpulan = ?";
            $paramsKajurUpdate = [$verifikator, '-',  $ID_Pengumpulan];
            $stmtKajurUpdate = sqlsrv_query($conn, $updateKajurSql,  $paramsKajurUpdate);

            if (!$stmtKajurUpdate) {
                throw new Exception('Gagal' . print_r(sqlsrv_errors(), true));
            }
        } else if ($role === 3 || $role === 4 || $role === 5) {
            $updateKaprodiSql = "UPDATE Pengumpulan SET VerifikatorKaprodi = ?, Keterangan = ? WHERE ID_Pengumpulan = ?";
            $paramsKaprodiUpdate = [$verifikator, '-',  $ID_Pengumpulan];
            $stmtKaprodiUpdate = sqlsrv_query($conn, $updateKaprodiSql, $paramsKaprodiUpdate);

            if (!$stmtKaprodiUpdate) {
                throw new Exception('Gagal' . print_r(sqlsrv_errors(), true));
            }
        }

        if (!is_null($existingBerkas['VerifikatorKajur']) && !is_null($existingBerkas['VerifikatorKaprodi'])) {
            $updateVrfSql = "UPDATE Pengumpulan SET Status_Pengumpulan = ?, Tanggal_Verifikasi = ? WHERE ID_Pengumpulan = ?";
            $paramsVrfUpdate = ['Terverifikasi', $tgl_verifikasi,  $ID_Pengumpulan];
            $stmtVrfUpdate = sqlsrv_query($conn, $updateVrfSql, $paramsVrfUpdate);

            if (!$stmtVrfUpdate) {
                throw new Exception('Gagal' . print_r(sqlsrv_errors(), true));
            }
        }
    }
}

function TolakBerkas() {
    global $conn;

    $ID_Pengumpulan = $_POST['ID_Pengumpulan'];
    $Keterangan = $_POST['Keterangan'];
    $verifikator = $_SESSION['Nama'];
    $SubBagian = $_POST['SubBagian'];
    $Role_ID = $_SESSION['Role_ID'];

    $checkBerkasSql = "SELECT ID_Pengumpulan FROM Pengumpulan WHERE ID_Pengumpulan = ?";
    $checkBerkasStmt = sqlsrv_query($conn, $checkBerkasSql, [$ID_Pengumpulan]);
    $existingBerkas = sqlsrv_fetch_array($checkBerkasStmt, SQLSRV_FETCH_ASSOC);

    if ($existingBerkas) {
        if ($Role_ID === 2) {
            $updateBerkasSql = "UPDATE Pengumpulan SET Status_Pengumpulan = ?, Tanggal_Verifikasi = ?, Keterangan = ?, VerifikatorKajur = ?
                                WHERE ID_Pengumpulan = ?";
            $paramsBerkasUpdate = ['Ditolak', NULL, $Keterangan, $verifikator, $ID_Pengumpulan];
            $stmtBerkasUpdate = sqlsrv_query($conn, $updateBerkasSql, $paramsBerkasUpdate);

            if (!$stmtBerkasUpdate) {
                throw new Exception('Gagal memperbarui data Administrasi: ' . print_r(sqlsrv_errors(), true));
            }
        } else if ($Role_ID === 3 || $Role_ID === 4 || $Role_ID === 5) {
            $updateBerkasSql = "UPDATE Pengumpulan SET Status_Pengumpulan = ?, Tanggal_Verifikasi = ?, Keterangan = ?, VerifikatorKaprodi = ?
                                WHERE ID_Pengumpulan = ?";
            $paramsBerkasUpdate = ['Ditolak', NULL, $Keterangan, $verifikator, $ID_Pengumpulan];
            $stmtBerkasUpdate = sqlsrv_query($conn, $updateBerkasSql, $paramsBerkasUpdate);

            if (!$stmtBerkasUpdate) {
                throw new Exception('Gagal memperbarui data Administrasi: ' . print_r(sqlsrv_errors(), true));
            }
        }
    }

    if ($SubBagian === 'Administrasi') {
        $checkAdministrasiSql = "SELECT ID_Administrasi FROM Administrasi WHERE ID_Pengumpulan = ?";
        $checkAdministrasiStmt = sqlsrv_query($conn, $checkAdministrasiSql, [$ID_Pengumpulan]);
        $existingAdministrasi = sqlsrv_fetch_array($checkAdministrasiStmt, SQLSRV_FETCH_ASSOC);

        if ($existingAdministrasi) {
            $updateAdministrasiSql = "UPDATE Administrasi SET Status_Verifikasi = ?, Tanggal_Verifikasi = ?, Keterangan = ?, Verifikator = ?
                                  WHERE ID_Pengumpulan = ?";
            $paramsAdministrasiUpdate = ['Ditolak', NULL, $Keterangan, $verifikator, $ID_Pengumpulan];
            $stmtAdministrasiUpdate = sqlsrv_query($conn, $updateAdministrasiSql, $paramsAdministrasiUpdate);

            if (!$stmtAdministrasiUpdate) {
                throw new Exception('Gagal memperbarui data Administrasi: ' . print_r(sqlsrv_errors(), true));
            }
        }
    } else if ($SubBagian === 'TA') {
        $checkTASql = "SELECT ID_Aplikasi FROM TugasAkhir WHERE ID_Pengumpulan = ?";
        $checkTAStmt = sqlsrv_query($conn, $checkTASql, [$ID_Pengumpulan]);
        $existingTA = sqlsrv_fetch_array($checkTAStmt, SQLSRV_FETCH_ASSOC);

        if ($existingTA) {
            $updateTASql = "UPDATE TugasAkhir SET Status_Verifikasi = ?, Tanggal_Verifikasi = ?, Keterangan = ?, Verifikator = ?
                            WHERE ID_Pengumpulan = ?";
            $paramsTAUpdate = ['Ditolak', NULL, $Keterangan, $verifikator, $ID_Pengumpulan];
            $stmtTAUpdate = sqlsrv_query($conn, $updateTASql, $paramsTAUpdate);

            if (!$stmtTAUpdate) {
                throw new Exception('Gagal memperbarui data TA: ' . print_r(sqlsrv_errors(), true));
            }
        }
    }
}



function GetByIdAdministrasi() {
    global $conn;
    global $ID_Administrasi, $nim, $nama, $prodi, $laporanSkripsi, $laporanMagang, $bebasKompensasi, $scanToeic, 
           $statusVerifikasi, $tanggalVerifikasi, $tanggalUpload, $keterangan, $verifikator, $laporanSkripsiurl,
           $laporanMagangurl, $bebasKompensasiurl, $scanToeicurl;
    $ID_Administrasi = $_GET['ID_Administrasi'] ?? null;

    $sql = "SELECT a.ID_Administrasi, m.NIM, m.Nama, m.Prodi, a.Laporan_Skripsi, a.Laporan_Magang, a.Bebas_Kompensasi, a.Scan_Toeic, 
            a.Status_Verifikasi, a.Tanggal_Verifikasi, a.Tanggal_Upload, a.Keterangan, a.Verifikator FROM Administrasi AS a 
            INNER JOIN Pengumpulan AS p ON a.ID_Pengumpulan = p.ID_Pengumpulan INNER JOIN Mahasiswa AS m ON p.NIM = m.NIM WHERE a.ID_Administrasi = ?";
    $params = array($ID_Administrasi);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $nim = $row['NIM'];
        $nama = $row['Nama'];
        $prodi = $row['Prodi'];
        $laporanSkripsi = $row['Laporan_Skripsi'];
        $laporanSkripsiurl = '../Uploads/' . basename($laporanSkripsi);
        $laporanMagang = $row['Laporan_Magang'];
        $laporanMagangurl = '../Uploads/' . basename($laporanMagang);
        $bebasKompensasi = $row['Bebas_Kompensasi'];
        $bebasKompensasiurl = '../Uploads/' . basename($bebasKompensasi);
        $scanToeic = $row['Scan_Toeic'];
        $scanToeicurl = '../Uploads' . basename($scanToeic);
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
    global $ID_Aplikasi, $nim, $nama, $prodi, $fileaplikasi, $laporanta, $pernyataanpublikasi, $statusVerifikasi, 
           $tanggalVerifikasi, $tanggalUpload, $keterangan, $verifikator, $fileaplikasiurl, $laporantaurl, $pernyataanpublikasiurl;
    $ID_Aplikasi = $_GET['ID_Aplikasi'] ?? null;

    $sql = "SELECT a.ID_Aplikasi, m.NIM, m.Nama, m.Prodi, a.File_Aplikasi, a.Laporan_TA, a.Pernyataan_Publikasi, 
            a.Status_Verifikasi, a.Tanggal_Verifikasi, a.Tanggal_Upload, a.Keterangan, a.Verifikator FROM TugasAkhir AS a 
            INNER JOIN Pengumpulan AS p ON a.ID_Pengumpulan = p.ID_Pengumpulan INNER JOIN Mahasiswa AS m ON p.NIM = m.NIM WHERE a.ID_Aplikasi = ?";
    $params = array($ID_Aplikasi);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $nim = $row['NIM'];
        $nama = $row['Nama'];
        $prodi = $row['Prodi'];
        $fileaplikasi = $row['File_Aplikasi'];
        $fileaplikasiurl = '../Uploads/' . basename($fileaplikasi);
        $laporanta = $row['Laporan_TA'];
        $laporantaurl = '../Uploads/' . basename($laporanta);
        $pernyataanpublikasi = $row['Pernyataan_Publikasi'];
        $pernyataanpublikasiurl = '../Uploads/' . basename($pernyataanpublikasi);
        $statusVerifikasi = $row['Status_Verifikasi'];
        $tanggalVerifikasi = $row['Tanggal_Verifikasi'];
        $tanggalUpload = $row['Tanggal_Upload'];
        $keterangan = $row['Keterangan'];
        $verifikator = $row['Verifikator'];
    } else {
        echo "No data found for the given ID.";
    }

}

function GetAllBerkas() {
    global $conn;
    global $Laporan_Skripsi, $Laporan_Magang, $Bebas_Kompensasi, $Scan_Toeic, $File_Aplikasi, $Laporan_TA, $Pernyataan_Publikasi, 
           $Tanggal_Upload, $Status_Verifikasi, $Keterangan, $Tanggal_Verifikasi, $Tanggal_UploadAdm, $Status_VerifikasiAdm, $KeteranganAdm, 
           $Tanggal_VerifikasiAdm, $Tanggal_UploadTA, $Status_VerifikasiTA, $KeteranganTA, $Tanggal_VerifikasiTA;

    $NIM = $_GET['NIM'];

    $sql = "SELECT a.Laporan_Skripsi, a.Laporan_Magang, a.Bebas_Kompensasi, a.Scan_Toeic,
            t.File_Aplikasi, t.Laporan_TA, t.Pernyataan_Publikasi, p.Tanggal_Pengumpulan, 
            p.Status_Pengumpulan, p.Keterangan, p.Tanggal_Verifikasi FROM Administrasi AS a INNER JOIN Pengumpulan AS p ON a.ID_Pengumpulan = p.ID_Pengumpulan INNER JOIN 
            TugasAKhir AS t ON t.ID_Pengumpulan = p.ID_Pengumpulan INNER JOIN Mahasiswa AS m ON p.NIM = m.NIM WHERE m.NIM = ?";
    $params = array($NIM);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $Laporan_Skripsi = $row['Laporan_Skripsi'];
        $Laporan_Magang = $row['Laporan_Magang'];
        $Bebas_Kompensasi = $row['Bebas_Kompensasi'];
        $Scan_Toeic = $row['Scan_Toeic'];
        $File_Aplikasi = $row['File_Aplikasi'];
        $Laporan_TA = $row['Laporan_TA'];
        $Pernyataan_Publikasi = $row['Pernyataan_Publikasi'];
        $Tanggal_Upload = $row['Tanggal_Pengumpulan'];
        $Status_Verifikasi = $row['Status_Pengumpulan'];
        $Keterangan = $row['Keterangan'];
        $Tanggal_Verifikasi = $row['Tanggal_Verifikasi'];
    } else {
        echo "No data found for the given ID.";
    }    

    $sqlTA = "SELECT t.Tanggal_Upload, t.Status_Verifikasi, t.Keterangan, t.Tanggal_Verifikasi FROM TugasAkhir AS t
             INNER JOIN Pengumpulan AS p ON t.ID_Pengumpulan = p.ID_Pengumpulan INNER JOIN Mahasiswa AS m ON p.NIM = m.NIM";
    $paramsTA = array($NIM);
    $stmtTA = sqlsrv_query($conn, $sqlTA, $paramsTA);

    if ($stmtTA === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if ($rowTA = sqlsrv_fetch_array($stmtTA, SQLSRV_FETCH_ASSOC)) {
        $Tanggal_UploadTA = $rowTA['Tanggal_Upload'];
        $Status_VerifikasiTA = $rowTA['Status_Verifikasi'];
        $Tanggal_VerifikasiTA = $rowTA['Tanggal_Verifikasi'];
        $KeteranganTA = $rowTA['Keterangan'];
    }

    $sqlAdm = "SELECT a.Tanggal_Upload, a.Status_Verifikasi, a.Keterangan, a.Tanggal_Verifikasi FROM Administrasi AS a
             INNER JOIN Pengumpulan AS p ON a.ID_Pengumpulan = p.ID_Pengumpulan INNER JOIN Mahasiswa AS m ON p.NIM = m.NIM";
    $paramsAdm = array($NIM);
    $stmtAdm = sqlsrv_query($conn, $sqlAdm, $paramsAdm);

    if ($stmtAdm === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if ($rowAdm = sqlsrv_fetch_array($stmtAdm, SQLSRV_FETCH_ASSOC)) {
        $Tanggal_UploadAdm = $rowAdm['Tanggal_Upload'];
        $Status_VerifikasiAdm = $rowAdm['Status_Verifikasi'];
        $Tanggal_VerifikasiAdm = $rowAdm['Tanggal_Verifikasi'];
        $KeteranganAdm = $rowAdm['Keterangan'];
    }
}

function EditTA() {
    global $conn;
    global $nim;
    $nim = $_POST['NIM'] ?? null;

    if (!$nim) {
        throw new Exception("NIM is required.");
    }

    $sql = "SELECT a.ID_Pengumpulan, p.ID_Pengumpulan, m.NIM 
            FROM TugasAkhir AS a 
            INNER JOIN Pengumpulan AS p ON a.ID_Pengumpulan = p.ID_Pengumpulan 
            INNER JOIN Mahasiswa AS m ON p.NIM = m.NIM";
    $params = array($nim);
    $stmt = sqlsrv_query($conn, $sql, $params);
    $existingTA = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    if ($existingTA) {
        $uploadDir = '../Uploads/';

        function uploadFile($file, $uploadDir) {
            $fileName = basename($file['name']);
            $targetFilePath = $uploadDir . $fileName;
    
            if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
                return $fileName; 
            } else {
                return false; 
            }
        }
        
        $File_Aplikasi = uploadFile($_FILES['File_Aplikasi'], $uploadDir);
        $Laporan_TA = uploadFile($_FILES['Laporan_TA'], $uploadDir);
        $Pernyataan_Publikasi = uploadFile($_FILES['Pernyataan_Publikasi'], $uploadDir);
        $Tanggal_Pengumpulan = date("Y-m-d");

        if ($File_Aplikasi && $Laporan_TA && $Pernyataan_Publikasi) {
            $sqlUpdate = "UPDATE TugasAkhir SET File_Aplikasi = ?, Laporan_TA = ?, Pernyataan_Publikasi = ?, Status_Verifikasi = ?, Tanggal_Upload = ?, Verifikator = ?
                          FROM TugasAkhir a INNER JOIN Pengumpulan p ON a.ID_Pengumpulan = p.ID_Pengumpulan INNER JOIN Mahasiswa m ON p.NIM = m.NIM
                          WHERE m.NIM = ?";
            $paramsTAUpdate = [$File_Aplikasi, $Laporan_TA, $Pernyataan_Publikasi, 'Menunggu', $Tanggal_Pengumpulan, NULL, $nim];
            $stmtTAUpdate = sqlsrv_query($conn, $sqlUpdate, $paramsTAUpdate);

            if (!$stmtTAUpdate) {
                throw new Exception('Gagal memperbarui data TA: ' . print_r(sqlsrv_errors(), true));
            } else {
                $sqlPUpdate = "UPDATE Pengumpulan SET Tanggal_Pengumpulan = ?, Status_Pengumpulan = 'Menunggu', Keterangan = '-', VerifikatorKajur = NULL, VerifikatorKaprodi = NULL
                              FROM Pengumpulan p INNER JOIN Mahasiswa m ON p.NIM = m.NIM WHERE m.NIM = ?";
                $paramsPUpdate = [$Tanggal_Pengumpulan, $nim];
                $stmtPUpdate = sqlsrv_query($conn, $sqlPUpdate, $paramsPUpdate);

                if (!$stmtPUpdate) {
                    throw new Exception('Gagal memperbarui data TA: ' . print_r(sqlsrv_errors(), true));
                }

                echo "<script>window.location.href = 'DetailBerkas.php?NIM=".urlencode($nim)."';</script>";
            }
        } else {
            throw new Exception('Gagal mengupload file. Periksa ukuran atau jenis file.');
        }
    }
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}

function EditAdministrasi() {
    global $conn;
    global $nim;
    $nim = $_POST['NIM'] ?? null;

    if (!$nim) {
        throw new Exception("NIM is required.");
    }

    $sql = "SELECT a.ID_Pengumpulan, p.ID_Pengumpulan, m.NIM 
            FROM Administrasi AS a 
            INNER JOIN Pengumpulan AS p ON a.ID_Pengumpulan = p.ID_Pengumpulan 
            INNER JOIN Mahasiswa AS m ON p.NIM = m.NIM";
    $params = array($nim);
    $stmt = sqlsrv_query($conn, $sql, $params);
    $existingAdm = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    if ($existingAdm) {
        $uploadDir = '../Uploads/';

        function uploadFile($file, $uploadDir) {
            $fileName = basename($file['name']);
            $targetFilePath = $uploadDir . $fileName;
    
            if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
                return $fileName; 
            } else {
                return false; 
            }
        }
        
        $Laporan_Skripsi = uploadFile($_FILES['Laporan_Skripsi'], $uploadDir);
        $Laporan_Magang = uploadFile($_FILES['Laporan_Magang'], $uploadDir);
        $Bebas_Kompensasi = uploadFile($_FILES['Bebas_Kompensasi'], $uploadDir);
        $Scan_Toeic = uploadFile($_FILES['Scan_Toeic'], $uploadDir);
        $Tanggal_Pengumpulan = date("Y-m-d");

        if ($Laporan_Skripsi && $Laporan_Magang && $Bebas_Kompensasi && $Scan_Toeic) {
            $sqlUpdate = "UPDATE Administrasi SET Laporan_Skripsi = ?, Laporan_Magang = ?, Bebas_Kompensasi = ?, Scan_Toeic = ?, Status_Verifikasi = ?, Tanggal_Upload = ?, Keterangan = ?, Verifikator = NULL
                          FROM Administrasi a INNER JOIN Pengumpulan p ON a.ID_Pengumpulan = p.ID_Pengumpulan INNER JOIN Mahasiswa m ON p.NIM = m.NIM
                          WHERE m.NIM = ?";
            $paramsAdmUpdate = [$Laporan_Skripsi, $Laporan_Magang, $Bebas_Kompensasi, $Scan_Toeic, 'Menunggu', $Tanggal_Pengumpulan, '-', $nim];
            $stmtAdmUpdate = sqlsrv_query($conn, $sqlUpdate, $paramsAdmUpdate);

            if (!$stmtAdmUpdate) {
                throw new Exception('Gagal memperbarui data TA: ' . print_r(sqlsrv_errors(), true));
            } else {
                $sqlPUpdate = "UPDATE Pengumpulan SET Tanggal_Pengumpulan = ?, Status_Pengumpulan = 'Menunggu', Keterangan = '-', VerifikatorKajur = NULL, VerifikatorKaprodi = NULL
                              FROM Pengumpulan p INNER JOIN Mahasiswa m ON p.NIM = m.NIM WHERE m.NIM = ?";
                $paramsPUpdate = [$Tanggal_Pengumpulan, $nim];
                $stmtPUpdate = sqlsrv_query($conn, $sqlPUpdate, $paramsPUpdate);

                if (!$stmtPUpdate) {
                    throw new Exception('Gagal memperbarui data TA: ' . print_r(sqlsrv_errors(), true));
                }

                echo "<script>window.location.href = 'DetailBerkas.php?NIM=".urlencode($nim)."';</script>";
            }
        } else {
            throw new Exception('Gagal mengupload file. Periksa ukuran atau jenis file.');
        }
    }
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}

function Berkas() {
    global $conn;

    global $namaMHS, $Prodi, $tglVrfAdm, $vrfAdm, $tglVrfTA, $vrfTA, $tglStrAdm, $tglStrTA, $tglStrBrks,
           $vrfKajur, $vrfKaprodi;

    $NIM = $_GET['NIM'];

    $sql = "SELECT m.NIM, m.Nama, m.Prodi FROM Administrasi AS a INNER JOIN Pengumpulan AS p ON a.ID_Pengumpulan = p.ID_Pengumpulan INNER JOIN 
            Mahasiswa AS m ON p.NIM = m.NIM WHERE m.NIM = ?";
    $params = array($NIM);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $namaMHS = $row['Nama'];
        $Prodi = $row['Prodi'];
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

$sql3 = "SELECT p.ID_Pengumpulan, m.NIM, m.Nama, p.Status_Pengumpulan, p.Keterangan FROM Pengumpulan AS p 
         INNER JOIN Mahasiswa AS m ON p.NIM = m.NIM";
$stmt3 = sqlsrv_query($conn, $sql3);

if ($stmt3 === false) {
    die(print_r(sqlsrv_errors(), true));
}

?>
