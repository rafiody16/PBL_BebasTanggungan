<?php
session_start();
require('../assets/library/fpdf.php');
include('ProsesBerkas.php');

Berkas();
$NIM = $_SESSION['NIM'];

// Buat instance FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Tambahkan header
$pdf->Image('../assets/img/logopoltek.png', 10, 6, 20);
$pdf->Image('../assets/img/logojti.png', 180, 9, 15);
$pdf->Cell(80); // Geser ke tengah
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(30, 10, 'KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI', 0, 1, 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(190, 5, 'JURUSAN TEKNOLOGI INFORMASI - POLITEKNIK NEGERI MALANG', 0, 1, 'C');
$pdf->Ln(10);

// Tambahkan data utama
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'BEBAS TANGGUNGAN JURUSAN', 0, 1, 'C');
$pdf->Ln(5);

// Tambahkan informasi pribadi
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(40, 7, 'Nama', 1);
$pdf->Cell(0, 7, ' '.$namaMHS, 1, 1);
$pdf->Cell(40, 7, 'NIM', 1);
$pdf->Cell(0, 7, ' '.$NIM, 1, 1);
$pdf->Cell(40, 7, 'Program Studi', 1);
$pdf->Cell(0, 7, ' '.$Prodi, 1, 1);
$pdf->Cell(40, 7, 'Tahun Angkatan', 1);
$pdf->Cell(0, 7, ' '.$thnAngkatan, 1, 1);
$pdf->Ln(5);

// Tambahkan tabel Tugas Akhir
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 10, 'Tugas Akhir', 0, 1);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(80, 7, 'Laporan TA', 1);
$pdf->Cell(20, 7, '     V', 1); // Checklist
$pdf->Ln();
$pdf->Cell(80, 7, 'File Aplikasi', 1);
$pdf->Cell(20, 7, '     V', 1); // Checklist
$pdf->Ln();
$pdf->Cell(80, 7, 'Pernyataan Publikasi', 1);
$pdf->Cell(20, 7, '     V', 1); // Checklist
$pdf->Ln(10);

// Tambahkan verifikasi Tugas Akhir
$pdf->Cell(40, 7, 'Tanggal Verifikasi:', 0);
$pdf->Cell(50, 7, ' '.$tglStrTA, 0, 1);
$pdf->Cell(40, 7, 'Verifikator:', 0);
$pdf->Cell(50, 7, ' '.$vrfTA, 0, 1);
$pdf->Ln(10);

// Tambahkan tabel Administrasi
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 10, 'Administrasi', 0, 1);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(80, 7, 'Laporan Skripsi', 1);
$pdf->Cell(20, 7, '     V', 1); // Checklist
$pdf->Ln();
$pdf->Cell(80, 7, 'Bebas Kompensasi', 1);
$pdf->Cell(20, 7, '     V', 1); // Checklist
$pdf->Ln();
$pdf->Cell(80, 7, 'Laporan Magang', 1);
$pdf->Cell(20, 7, '     V', 1); // Checklist
$pdf->Ln();
$pdf->Cell(80, 7, 'Scan Toeic', 1);
$pdf->Cell(20, 7, '     V', 1); // Checklist
$pdf->Ln(10);

// Tambahkan verifikasi Administrasi
$pdf->Cell(40, 7, 'Tanggal Verifikasi:', 0);
$pdf->Cell(50, 7, ' '.$tglStrAdm, 0, 1);
$pdf->Cell(40, 7, 'Verifikator:', 0);
$pdf->Cell(50, 7, ' '.$vrfAdm, 0, 1);

// Tambahkan footer

$pdf->Ln(10);
$pdf->SetFont('Arial', '', 10);

// Bagian Kiri
$pdf->Cell(95, 10, 'Malang, '.$tglStrBrks, 0, 0, 'L');
$pdf->Cell(95, 10, 'Malang, '.$tglStrBrks, 0, 0, 'R'); // Tanggal di kiri
$pdf->Cell(95, 10, '', 0, 1); // Kosong untuk mengimbangi kanan
$pdf->Cell(95, 10, 'Ketua Jurusan Teknologi Informasi', 0, 0, 'L'); // Posisi kiri
$pdf->Cell(95, 10, 'Koordinator Program Studi', 0, 1, 'R'); // Posisi kanan

$pdf->Ln(20); // Jarak untuk tanda tangan

$pdf->SetY($pdf->GetY() - 10);

$pdf->Image('../Uploads/'.$ttdKajur, 15, $pdf->GetY() + -10, 25);
$pdf->Image('../Uploads/'.$ttdKaprodi, 170, $pdf->GetY() + -10, 25);

// Nama dan Gelar
$pdf->Cell(95, 10, $vrfKajur, 0, 0, 'L'); // Nama kiri
$pdf->Cell(95, 10, $vrfKaprodi, 0, 1, 'R'); // Nama kanan

// Output PDF
$pdf->Output('I', 'bebas_tanggungan_jurusan.pdf');
?>
