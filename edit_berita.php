<?php require 'koneksi.php';
$profil = mysqli_fetch_assoc(
    mysqli_query($conn,
    "SELECT * FROM profil WHERE id = 1")
);

if (!isset($_SESSION['admin'])) header("Location: login.php");

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$id = (int)$_GET['id'];

$stmt = mysqli_prepare($conn, "SELECT * FROM berita WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    header("Location: dashboard.php");
    exit;
}

if (isset($_POST['update'])) {
    $j = $_POST['judul'];
    $i = $_POST['isi'];
    $file = $_FILES['gambar']['name'];
    if ($file != "") {
        $img = time() . "_" . $file;
        move_uploaded_file($_FILES['gambar']['tmp_name'], "assets/uploads/" . $img);
        if ($data['gambar']) unlink("assets/uploads/".$data['gambar']);
        $stmt = mysqli_prepare($conn, "UPDATE berita SET judul = ?, isi = ?, gambar = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "sssi", $j, $i, $img, $id);
    } else {
        $stmt = mysqli_prepare($conn, "UPDATE berita SET judul = ?, isi = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "ssi", $j, $i, $id);
    }
    mysqli_stmt_execute($stmt);
    header("Location: dashboard.php");
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Berita - <?= $profil['nama_sekolah'] ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="grid-container">
        <nav><a href="dashboard.php">&larr;Kembali</a></nav>
        <main class="full-width">
            <h2>Edit Berita</h2>
            <form method="POST" enctype="multipart/form-data">
                <input type="text" name="judul" value="<?=$data['judul'] ?>">
                <textarea name="isi" rows="10"><?=$data['isi'] ?></textarea>
                <input type="file" name="gambar">
                <button type="submit" name="update">Update</button>
            </form>
        </main>
    </div>
</body>
</html>