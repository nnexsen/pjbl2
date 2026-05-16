<?php require 'koneksi.php';
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
$profil = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM profil WHERE id=1")); 
if (isset($_POST['submit'])) {
    $j = $_POST['judul'];
    $i = $_POST['isi'];
    $file = $_FILES['gambar']['name'];
    if ($file != "") {
        $img = time() . "_" . $file;
        move_uploaded_file($_FILES['gambar']['tmp_name'], "assets/uploads/" . $img);
        $stmt = mysqli_prepare($conn, "INSERT INTO berita (judul, isi, gambar) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $j, $i, $img);
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO berita (judul, isi) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, "ss", $j, $i);
    }
    mysqli_stmt_execute($stmt);
    header("Location: berita.php");
} ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Berita - <?= $profil['nama_sekolah'] ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="grid-container">
        <nav><a href="berita.php">&larr;Kembali</a></nav>
        <main class="full-width">
            <h2>Tambah Berita</h2>
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="judul">Judul:</label>
                    <input type="text" name="judul" id="judul" required>
                </div>
                <div class="form-group">
                    <label for="isi">Isi:</label>
                    <textarea name="isi" id="isi" rows="5" required></textarea>
                </div>
                <div class="form-group">
                    <label for="gambar">Gambar:</label>
                    <input type="file" name="gambar" id="gambar">
                </div>
                <button type="submit" name="submit">Simpan</button>
            </form>
        </main>
    </div>