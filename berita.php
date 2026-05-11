<?php require 'koneksi.php';
if (!isset($_SESSION['admin'])) header("Location: login.php");
$profil = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM profil WHERE id = 1"));
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $d = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM berita WHERE id = $id"));
    if ($d['gambar']) unlink("assets/uploads/".$d['gambar']);
    mysqli_query($conn, "DELETE FROM berita WHERE id = $id");
    header("Location: berita.php");
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Berita - <?= $profil['nama_sekolah'] ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <div class="grid-container">
        <header>
            <img src="assets/img/<?= $profil['logo']; ?>">
            <div class="identitas">
                <h1>Admin Panel</h1>
            </div>
        </header>

        <nav>
            <a href="index.php">Data Berita</a>
            <a href="edit_profil.php">Edit Profil</a>
            <a href="logout.php" onclick="return confirm('Yakin ingin logout?')">Logout</a>
        </nav>

        <main class="full-width">
            <h2>Data Berita Sekolah</h2>
            <a href="tambah_berita.php" class="btn btn-save">+ Tambah Berita</a>
            <table>
                <tr>
                    <th>Judul</th>
                    <th>Aksi</th>
                </tr>
                <?php $q = mysqli_query($conn, "SELECT * FROM berita ORDER BY id DESC");
                while ($r = mysqli_fetch_assoc($q)): ?>
                <tr>
                    <td><?= $r['judul']; ?></td>
                    <td>
                        <a href="edit_berita.php?id=<?= $r['id'] ?>" class="btn btn-edit">Edit</a>
                        <a href="berita.php?hapus=<?= $r['id'] ?>" class="btn btn-delete" onclick="return confirm('Yakin ingin menghapus berita ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </main>
    </div>
</body>
</html>