CREATE DATABASE PBLBebasTanggungan;

USE PBLBebasTanggungan;
GO;

CREATE TABLE Role (
    Role_ID INT PRIMARY KEY,
    Nama_Role VARCHAR(100) NOT NULL,
    Deskripsi TEXT,
    Level_Akses INT
);

CREATE TABLE [User] (
    ID_User INT PRIMARY KEY,
    Username VARCHAR(100) NOT NULL,
    [Password] VARCHAR(255) NOT NULL,
    Email VARCHAR(100) NOT NULL,
    Role_ID INT,
    FOREIGN KEY (Role_ID) REFERENCES Role(Role_ID)
);

CREATE TABLE Mahasiswa (
    NIM INT PRIMARY KEY,
    Nama VARCHAR(100) NOT NULL,
    Email VARCHAR(100),
    Alamat TEXT,
    NoHp VARCHAR(15),
    JenisKelamin CHAR(1),
    ID_User INT,
    FOREIGN KEY (ID_User) REFERENCES [User](ID_User)
);

CREATE TABLE Staff (
    NIP INT PRIMARY KEY,
    Nama VARCHAR(100) NOT NULL,
    Jabatan VARCHAR(100),
    Alamat TEXT,
    NoHp VARCHAR(15),
    ID_User INT,
    FOREIGN KEY (ID_User) REFERENCES [User](ID_User)
);

CREATE TABLE Pengumpulan (
    ID_Pengumpulan INT PRIMARY KEY,
    NIM INT,
    Tanggal_Pengumpulan DATE,
    Status_Pengumpulan VARCHAR(50),  -- Belum Upload, Menunggu verifikasi, Terverifikasi, Ditolak
    Keterangan TEXT,
    FOREIGN KEY (NIM) REFERENCES Mahasiswa(NIM)
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
    FOREIGN KEY (ID_Pengumpulan) REFERENCES Pengumpulan(ID_Pengumpulan)
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
    FOREIGN KEY (ID_Pengumpulan) REFERENCES Pengumpulan(ID_Pengumpulan)
);

go;


SELECT * FROM Staff;
SELECT * FROM [User];
SELECT * FROM Role;
SELECT * FROM Administrasi;
go;



INSERT INTO Role
VALUES (1, 'admin', 'dapat mengakses semua', '1');

INSERT INTO Role
VALUES (2, 'kajur', 'dapat mengakses data TI, SIB, RPL', '2');

INSERT INTO Role
VALUES (3, 'kaprodiTI', 'hanya dapat mengakses data TI', '3');

INSERT INTO Role
VALUES (4, 'kaprodiSIB', 'hanya dapat mengakses data SIB', '4');

INSERT INTO Role
VALUES (5, 'kaprodiTI', 'hanya dapat mengakses data RPL', '5');

INSERT INTO Role
VALUES (6, 'kaprodiTI', 'hanya dapat mengakses data TI', '6');

INSERT INTO Role
VALUES (7, 'adminTA', 'hanya dapat mengakses data TA', '7');

INSERT INTO Role
VALUES (8, 'adminProdi', 'hanya dapat mengakses data administrasi prodi', '8');

INSERT INTO Role
VALUES (9, 'mahasiswa', 'hanya dapat upload data', '9');

SELECT * FROM Role;

ALTER TABLE Staff
DROP COLUMN Jabatan;

ALTER TABLE Mahasiswa
ADD Prodi VARCHAR(50);

SELECT * FROM Administrasi;

ALTER TABLE Administrasi
ADD Verifikator VARCHAR(50);


ALTER TABLE Mahasiswa
DROP COLUMN Email;

SELECT * FROM Mahasiswa;

SELECT * FROM Staff;