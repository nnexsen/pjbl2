<?php
require 'koneksi.php';

$query = mysqli_query($conn,
    "SELECT * FROM galeri ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Galeri Sekolah</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<h1>Galeri Sekolah</h1>

<div class="galeri-grid">

<?php while($g = mysqli_fetch_assoc($query)) : ?>

    <div class="card-galeri">

        <img src="assets/uploads/galeri/<?= $g['gambar']; ?>" width="250">

        <h3><?= $g['judul']; ?></h3>

        <p><?= $g['deskripsi']; ?></p>

    </div>

    <nav>

        <a href="index.php">
            &larr; Kembali Ke Beranda
        </a>

    </nav>

<?php endwhile; ?>

</div>

</body>
</html>