<?php
require 'koneksi.php';

$profil = mysqli_fetch_assoc(
    mysqli_query($conn,
    "SELECT * FROM profil WHERE id = 1")
);

$query = mysqli_query(
    $conn,
    "SELECT * FROM berita ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0">

    <title>Semua Berita</title>

    <link
    rel="stylesheet"
    href="assets/css/style.css">

</head>

<body>

<div class="grid-container">

    <header>

        <img
        src="assets/img/<?= $profil['logo']; ?>">

        <div class="identitas">

            <h1>
                <?= $profil['nama_sekolah']; ?>
            </h1>

            <p>
                <?= $profil['alamat']; ?>
            </p>

        </div>

    </header>

    <nav>

        <a href="index.php">
            &larr; Kembali Ke Beranda
        </a>

    </nav>

    <main class="full-width">

        <h2>Seluruh Berita Sekolah</h2>

        <div class="berita-grid">

        <?php while($b = mysqli_fetch_assoc($query)) : ?>

            <div class="card-berita">

                <?php if($b['gambar']) : ?>

                    <img
                    src="assets/uploads/<?= $b['gambar']; ?>"
                    alt="gambar berita">

                <?php endif; ?>

                <h3>
                    <?= $b['judul']; ?>
                </h3>

                <p>

                    <?= substr(
                        strip_tags($b['isi']),
                        0,
                        120
                    ); ?>...

                </p>

                <a
                href="baca.php?id=<?= $b['id']; ?>"
                class="btn">

                    Baca Selengkapnya

                </a>

            </div>

        <?php endwhile; ?>

        </div>

    </main>

    <footer>

        <p>

            &copy; <?= date('Y'); ?>

            <?= $profil['nama_sekolah']; ?>

        </p>

    </footer>

</div>

</body>
</html>