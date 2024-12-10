CREATE DATABASE PBLBebasTanggungan;

USE PBLBebasTanggungan;
GO;

CREATE TABLE [Role] (
    Role_ID INT PRIMARY KEY,
    Nama_Role VARCHAR(100) NOT NULL,
    Deskripsi TEXT,
);

CREATE TABLE [User] (
    ID_User INT PRIMARY KEY,
    Username VARCHAR(100) NOT NULL,
    [Password] VARCHAR(255),
    Email VARCHAR(100) NOT NULL,
    Role_ID INT,
    FOREIGN KEY (Role_ID) REFERENCES Role(Role_ID) ON DELETE CASCADE
);

CREATE TABLE Mahasiswa (
    NIM INT PRIMARY KEY,
    Nama VARCHAR(100) NOT NULL,
    Alamat TEXT,
    NoHp VARCHAR(15),
    JenisKelamin VARCHAR(10),
	Tahun_Angkatan INT,
	Tempat_Lahir VARCHAR(25),
	Tanggal_Lahir DATE,
    ID_User INT,
    FOREIGN KEY (ID_User) REFERENCES [User](ID_User) ON DELETE CASCADE
);

CREATE TABLE Staff (
    NIP INT PRIMARY KEY,
    Nama VARCHAR(100) NOT NULL,
    Alamat TEXT,
    NoHp VARCHAR(15),
	JenisKelamin VARCHAR(10),
	Tempat_Lahir VARCHAR(25),
	Tanggal_Lahir DATE,
    ID_User INT,
    FOREIGN KEY (ID_User) REFERENCES [User](ID_User) ON DELETE CASCADE
);

CREATE TABLE Pengumpulan (
    ID_Pengumpulan INT PRIMARY KEY,
    NIM INT,
    Tanggal_Pengumpulan DATE,
    Status_Pengumpulan VARCHAR(50),  -- Belum Upload, Menunggu verifikasi, Terverifikasi, Ditolak
	Tanggal_Verifikasi DATE,
    Keterangan TEXT,
	VerifikatorKajur VARCHAR(50),
	VerifikatorKaprodi VARCHAR(50),
    FOREIGN KEY (NIM) REFERENCES Mahasiswa(NIM) ON DELETE CASCADE
);

CREATE TABLE TugasAkhir (
    ID_Aplikasi INT PRIMARY KEY,
    ID_Pengumpulan INT,
    File_Aplikasi VARCHAR(255),
    Laporan_TA VARCHAR(255),
    Pernyataan_Publikasi VARCHAR(255),
    Status_Verifikasi VARCHAR(50), -- Belum Upload, Menunggu verifikasi, Terverifikasi, Ditolak.
    Tanggal_Verifikasi DATE,
    Tanggal_Upload DATE,
    Keterangan TEXT,
	Verifikator VARCHAR(50),
    FOREIGN KEY (ID_Pengumpulan) REFERENCES Pengumpulan(ID_Pengumpulan) ON DELETE CASCADE
);

CREATE TABLE Administrasi (
    ID_Administrasi INT PRIMARY KEY,
    ID_Pengumpulan INT,
    Laporan_Skripsi VARCHAR(255),
    Laporan_Magang VARCHAR(255),
    Bebas_Kompensasi VARCHAR(255),
    Scan_Toeic VARCHAR(255),
    Status_Verifikasi VARCHAR(50),  -- Belum Upload, Menunggu verifikasi, Terverifikasi, Ditolak
    Tanggal_Verifikasi DATE,
    Tanggal_Upload DATE,
    Keterangan TEXT,
	Verifikator VARCHAR(50),
    FOREIGN KEY (ID_Pengumpulan) REFERENCES Pengumpulan(ID_Pengumpulan) ON DELETE CASCADE
);

go;


SELECT * FROM Staff;
SELECT * FROM [User];
SELECT * FROM Role;
SELECT * FROM Administrasi;
go;



INSERT INTO Role
VALUES (1, 'Admin', 'dapat mengakses semua');

INSERT INTO Role
VALUES (2, 'Kepala Jurusan', 'dapat mengakses data TI, SIB, RPL');

INSERT INTO Role
VALUES (3, 'Kaprodi TI', 'hanya dapat mengakses data TI');

INSERT INTO Role
VALUES (4, 'Kaprodi SIB', 'hanya dapat mengakses data SIB');

INSERT INTO Role
VALUES (5, 'Kaprodi PPLS', 'hanya dapat mengakses data RPL');

INSERT INTO Role
VALUES (6, 'Admin TA', 'hanya dapat mengakses data TA');

INSERT INTO Role
VALUES (7, 'Admin Jurusan', 'hanya dapat mengakses data administrasi prodi');

INSERT INTO Role
VALUES (8, 'Mahasiswa', 'hanya dapat upload data');

SELECT * FROM Role;

ALTER TABLE Staff
DROP COLUMN Jabatan;

ALTER TABLE Mahasiswa
ADD Prodi VARCHAR(50);

SELECT * FROM Administrasi;

ALTER TABLE Administrasi
ADD Verifikator VARCHAR(50);

ALTER TABLE TugasAkhir
ADD Verifikator VARCHAR(50);

ALTER TABLE TugasAkhir
ADD Verifikator VARCHAR(50);

ALTER TABLE Pengumpulan
ADD Tanggal_Verifikasi DATE;


ALTER TABLE Mahasiswa
DROP COLUMN Email;

ALTER TABLE Mahasiswa
ADD Tahun_Angkatan INT;

ALTER TABLE Staff
ADD TTD VARCHAR(50);

SELECT * FROM Mahasiswa;

SELECT * FROM Staff;
SELECT * FROM [User];
GO

CREATE VIEW statusTerverifikasi AS
SELECT p.ID_Pengumpulan, mhs.NIM, mhs.Nama, mhs.Prodi, p.Status_Pengumpulan
FROM 
Pengumpulan AS p
INNER JOIN Mahasiswa AS mhs ON mhs.NIM = p.NIM
WHERE p.Status_Pengumpulan = 'Terverifikasi';
GO;

CREATE VIEW statusMenunggu AS
SELECT p.ID_Pengumpulan, mhs.NIM, mhs.Nama, mhs.Prodi, p.Status_Pengumpulan
FROM 
Pengumpulan AS p
INNER JOIN Mahasiswa AS mhs ON mhs.NIM = p.NIM
WHERE p.Status_Pengumpulan = 'Menunggu';
GO;

CREATE VIEW statusTolak AS
SELECT p.ID_Pengumpulan, mhs.NIM, mhs.Nama, mhs.Prodi, p.Status_Pengumpulan
FROM 
Pengumpulan AS p
INNER JOIN Mahasiswa AS mhs ON mhs.NIM = p.NIM
WHERE p.Status_Pengumpulan = 'Ditolak';
GO;

CREATE FUNCTION fn_GetAdministrasiDetails (@prodi NVARCHAR(50), @tahun_angkatan NVARCHAR(10)) RETURNS TABLE AS RETURN ( SELECT a.ID_Administrasi, m.NIM, m.Nama, m.Prodi, a.Status_Verifikasi, a.Keterangan FROM Administrasi AS a INNER JOIN Pengumpulan AS p ON a.ID_Pengumpulan = p.ID_Pengumpulan INNER JOIN Mahasiswa AS m ON p.NIM = m.NIM WHERE (m.Prodi LIKE '%' + @prodi + '%' OR @prodi = '') AND (m.Tahun_Angkatan LIKE '%' + @tahun_angkatan + '%' OR @tahun_angkatan = '') );

GO
CREATE FUNCTION fn_GetTugasAkhirDetails (@prodi NVARCHAR(50), @tahun_angkatan NVARCHAR(10))
RETURNS TABLE
AS
RETURN
(
    SELECT a.ID_Aplikasi, m.NIM, m.Nama, a.Status_Verifikasi, a.Keterangan 
    FROM TugasAkhir AS a
    INNER JOIN Pengumpulan AS p ON a.ID_Pengumpulan = p.ID_Pengumpulan 
    INNER JOIN Mahasiswa AS m ON p.NIM = m.NIM
    WHERE (m.Prodi LIKE '%' + @prodi + '%' OR @prodi = '') 
    AND (m.Tahun_Angkatan LIKE '%' + @tahun_angkatan + '%' OR @tahun_angkatan = '') 
);