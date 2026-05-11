<?php require 'koneksi.php';
if (!isset($_SESSION['admin'])) header("Location: login.php");
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM profil WHERE id=1"));
if (isset($_POST['update'])) {
    $n = $_POST['nama'];
    $a = $_POST['alamat'];
    $l = $_POST['logo'];
    $v = $_POST['visi'];
    $m = $_POST['misi'];
    $s = $_POST['sejarah'];
    $logo = $_FILES['logo']['name'];
    if ($logo != "") {
        $n_logo = time() . "_" . $logo;
        move_uploaded_file($_FILES['logo']['tmp_name'], "assets/img/" . $n_logo);
        if ($data['logo']) unlink("assets/img/".$data['logo']);
        mysqli_query($conn, "UPDATE profil SET nama_sekolah='$n', alamat='$a', logo='$n_logo', visi='$v', misi='$m', sejarah='$s' WHERE id=1"); 
    } else {
        mysqli_query($conn, "UPDATE profil SET nama_sekolah='$n', alamat='$a', visi='$v', misi='$m', sejarah='$s' WHERE id=1");
    }
    header("Location: edit_profil.php");
} ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - <?= $data['nama_sekolah'] ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="grid-container">
        <nav><a href="berita.php">Ke Panel Admin</a></nav>
        <main class="full-width">
            <h2>Edit Prodil Sekolah</h2>
            <form method="POST" enctype="multipart/form-data">
                <input type="text" name="nama" value="<?= $data['nama_sekolah'] ?>">
                <input type="file" name="logo">
                <textarea name="alamat" id=""><?= $data['alamat'] ?></textarea>
                <textarea name="visi" id=""><?= $data['visi'] ?></textarea>
                <textarea name="misi" id=""><?= $data['misi'] ?></textarea>
                <textarea name="sejarah" rows="10" id=""><?= $data['sejarah'] ?></textarea>
                <button type="submit" name="update" class="btn btn-save">Simpan Perubahan</button>
            </form>
        </main>
    </div>
</body>
</html>    