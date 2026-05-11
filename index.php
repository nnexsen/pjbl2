<?php require 'koneksi.php';
$profil = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM profil WHERE id = 1")); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $profil['nama_sekolah'] ?></title>
    <link rel="stylesheet" href="assets/css/style.css">

</head>
<body>
    <div class="grid-container">
        <header>
            <img src="assets/img/<?= $profil['logo']; ?>">
            <div class="identitas">
                <h1><?= $profil['nama_sekolah'] ?></h1>
                <p><?= $profil['alamat'] ?></p>
            </div>
        </header>
        <nav>
            <a href="index.php">Home</a>
            <a href="#profil">Profil Sekolah</a>
            <a href="#berita">Berita</a>
            <a href="#sejarah">Sejarah</a>
            <a href="#visimisi">Visi & Misi</a>
            <button onclick="location.href='login.php'">Log In</button>
        </nav>
        <div class="banner">
            <h2>Selamat Datang di Portal Informasi</h2>
        </div>
        <main id="profil">
            <section>
                <h3 id="visimisi">Visi & Misi</h3>
                <p><strong>Visi:</strong> <?= $profil['visi'] ?></p>
                <p><strong>Misi:</strong> <?= $profil['misi'] ?></p>
                <hr>
                <h3 id="sejarah">Sejarah</h3>
                <p>Sekolah ini didirikan pada tahun 1990 dengan tujuan untuk memberikan pendidikan berkualitas kepada siswa-siswa di daerah ini. Sejak berdirinya, sekolah telah berkembang pesat dan menjadi salah satu institusi pendidikan terkemuka di wilayahnya.</p>
            </section>
            <aside style="text-align:center;">
                <img src="assets/img/kepala.png" width="100%">
                <p><strong>Drs. Nama Kepala</strong><br>Kepala Sekolah</p>
            </aside>
        </main>
        <section class="berita-section" id="berita">
            <h2>Berita Terbaru</h2>
            <div class="berita-grid">
                <?php $q = mysqli_query($conn, "SELECT * FROM berita ORDER BY id DESC LIMIT 3");
                while ($r = mysqli_fetch_assoc($q)): ?>
                <div class="card-berita">
                    <?php if ($r['gambar']): ?><img src="assets/uploads/<?= $r['gambar'];
                    ?>"><?php endif; ?>
                    <h4><?= $r['judul'] ?></h4>
                    <a href="baca.php?id=<?=    $r['id'];   ?>"     class="btn">Baca Selengkapnya</a>
                </div>
                <?php endwhile; ?>
            </div>
        </section>
            <footer>
                <p>&copy; <?= date('Y') ?> <?= $profil['nama_sekolah'] ?>. All rights reserved.</p>
            </footer>
    </div>
</body>
</html>