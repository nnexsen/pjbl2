<?php
require 'koneksi.php';

if(isset($_POST['submit'])){

    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];

    $gambar = $_FILES['gambar']['name'];
$tmp = $_FILES['gambar']['tmp_name'];

$ext = strtolower(
    pathinfo($gambar, PATHINFO_EXTENSION)
);

$allowed = ['jpg', 'jpeg', 'png'];

if(!in_array($ext, $allowed)){

    die("File harus jpg, jpeg, atau png");

}

$gambarBaru = time() . "_" . $gambar;

move_uploaded_file(
    $tmp,
    "assets/uploads/galeri/" . $gambarBaru
);

    $stmt = mysqli_prepare(
    $conn,
    "INSERT INTO galeri
    (judul, gambar, deskripsi, tanggal_upload)
    VALUES (?, ?, ?, NOW())"
);

mysqli_stmt_bind_param(
    $stmt,
    "sss",
    $judul,
    $gambarBaru,
    $deskripsi
);

mysqli_stmt_execute($stmt);

    header("Location: galeri.php");
    exit;
}
?>

<form method="POST" enctype="multipart/form-data">

    <input type="text" name="judul" placeholder="Judul">

    <textarea name="deskripsi"></textarea>

    <input type="file" name="gambar">

    <button type="submit" name="submit">
        Upload
    </button>

</form>