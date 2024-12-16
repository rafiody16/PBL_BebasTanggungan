<?php
require_once '../Koneksi.php';
require_once 'Mahasiswa.php';

// Inisialisasi koneksi database melalui kelas Database
$db = new Database();
$conn = $db->conn;

// Inisialisasi kelas Mahasiswa
$mahasiswa = new Mahasiswa($conn);

// Ambil data mahasiswa
$stmt = $mahasiswa->getAllMhs();

// Tampilkan data dalam tabel HTML
if ($stmt) {
    echo "<table border='1' cellspacing='0' cellpadding='5'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>NIM</th>";
    echo "<th>Nama</th>";
    echo "<th>Alamat</th>";
    echo "<th>No Hp</th>";
    echo "<th>Jenis Kelamin</th>";
    echo "<th>Prodi</th>";
    echo "<th>Tempat Lahir</th>";
    echo "<th>Tanggal Lahir</th>";
    echo "<th>Tahun Angkatan</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['NIM']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Nama']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Alamat']) . "</td>";
        echo "<td>" . htmlspecialchars($row['NoHp']) . "</td>";
        echo "<td>" . htmlspecialchars($row['JenisKelamin']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Prodi']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Tempat_Lahir']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Tanggal_Lahir']->format('Y-m-d')) . "</td>";
        echo "<td>" . htmlspecialchars($row['Tahun_Angkatan']) . "</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
} else {
    echo "<p>Tidak ada data mahasiswa.</p>";
}

// Tutup koneksi
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>
