<?php require 'koneksi.php';
$profil = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM profil WHERE id = 1"));
$id = $_GET['id'];
$stmt = mysqli_prepare($conn, "SELECT * FROM berita WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$berita = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt)); ?>


<!DOCTYPE html>
<html lang="en">

    <head>
        <title><?= $berita['judul'] ?></title>
        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    
    <body>
        <div class="grid-container">
            <header>
                <img src="assets/img/<?= $profil['logo']; ?>">
                <div class="identitas">
                    <h1><?= $profil['nama_sekolah'] ?></h1>
                </div>
            </header>
            <nav><a href="index.php">&larr; Kembali Ke Beranda</a></nav>
            <div class="banner">
                <h2>Detail Berita</h2>
            </div>
            <main class="full-width">
                <article>
                    <h1><?= htmlspecialchars($berita['judul'], ENT_QUOTES, 'UTF-8') ?></h1>
                    <?php if ($berita['gambar']): ?><img src="assets/uploads/<?= htmlspecialchars($berita['gambar'], ENT_QUOTES, 'UTF-8'); ?>"class='img-detail'><?php endif; ?>
                    <p><?= nl2br(htmlspecialchars($berita['isi'], ENT_QUOTES, 'UTF-8')) ?></p>
                </article>
            </main>
            <footer>
                <p>&copy; <?= date('Y') ?> <?= $profil['nama_sekolah'] ?>. All rights reserved.</p>
            </footer>
        </div>

</html>