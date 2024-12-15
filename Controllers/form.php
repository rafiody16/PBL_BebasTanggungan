<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Buat Mahasiswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .form-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="text"], input[type="password"], input[type="email"], input[type="date"], select {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #007BFF;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Form Buat Mahasiswa</h2>

        <form action="UserControllers.php?action=createMahasiswa" method="POST" enctype="multipart/form-data">
            
            <label for="NIM">NIM</label>
            <input type="text" id="NIM" name="NIM" required>

            <label for="Nama">Nama</label>
            <input type="text" id="Nama" name="Nama" required>

            <label for="Alamat">Alamat</label>
            <input type="text" id="Alamat" name="Alamat" required>

            <label for="NoHp">Nomor HP</label>
            <input type="text" id="NoHp" name="NoHp" required>

            <label for="JenisKelamin">Jenis Kelamin</label>
            <select id="JenisKelamin" name="JenisKelamin">
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>

            <label for="Prodi">Program Studi</label>
            <input type="text" id="Prodi" name="Prodi" required>

            <label for="Tahun_Angkatan">Tahun Angkatan</label>
            <input type="number" id="Tahun_Angkatan" name="Tahun_Angkatan" min="2000" max="2030" required>
            <br>    

            <label for="Tempat_Lahir">Tempat Lahir</label>
            <input type="text" id="Tempat_Lahir" name="Tempat_Lahir" required>

            <label for="Tanggal_Lahir">Tanggal Lahir</label>
            <input type="date" id="Tanggal_Lahir" name="Tanggal_Lahir" required>

            <label for="Username">Username</label>
            <input type="text" id="Username" name="Username" required>

            <label for="Passowrd">Password</label>
            <input type="password" id="Password" name="Password" required>

            <label for="Email">Email</label>
            <input type="email" id="Email" name="Email" required>

            <input type="submit" value="Buat Mahasiswa">
        </form>
    </div>

</body>
</html>
