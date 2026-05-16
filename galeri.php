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
    <nav>

        <a href="index.php">
            &larr; Kembali Ke Beranda
        </a>

    </nav>

<div class="galeri-grid">

<?php while($g = mysqli_fetch_assoc($query)) : ?>

    <div class="card-galeri">

        <img src="assets/uploads/galeri/<?= htmlspecialchars($g['gambar'], ENT_QUOTES, 'UTF-8'); ?>" width="250">

        <h3><?= htmlspecialchars($g['judul'], ENT_QUOTES, 'UTF-8'); ?></h3>

        <p><?= htmlspecialchars($g['deskripsi'], ENT_QUOTES, 'UTF-8'); ?></p>

    </div>

    

<?php endwhile; ?>

</div>

</body>
</html>