<?php
session_start();
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Berita - <?= htmlspecialchars($profil['nama_sekolah'], ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php require 'navbar.php'; ?>

    <!-- Banner -->
    <div class="banner">
        <h2>Semua Berita Sekolah</h2>
    </div>

    <main>
        <section class="berita-section">
            <p style="color: var(--text-light); margin-bottom: 2rem;">Baca semua artikel dan informasi terbaru dari sekolah kami</p>
            
            <div class="berita-grid" style="grid-template-columns: repeat(3, 1fr);">
                <?php 
                $count = 0;
                while($b = mysqli_fetch_assoc($query)): 
                    $count++;
                ?>
                <div class="card-berita">
                    <?php if($b['gambar']) : ?>
                        <img src="assets/uploads/<?= htmlspecialchars($b['gambar'], ENT_QUOTES, 'UTF-8'); ?>" alt="Gambar Berita">
                    <?php else: ?>
                        <div style="width: 100%; height: 200px; background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 2.5rem;">📰</div>
                    <?php endif; ?>
                    <div class="card-berita-content">
                        <h4><?= htmlspecialchars($b['judul'], ENT_QUOTES, 'UTF-8'); ?></h4>
                        <p><?= htmlspecialchars(substr(strip_tags($b['isi']), 0, 120), ENT_QUOTES, 'UTF-8'); ?>...</p>
                        <a href="baca.php?id=<?= $b['id']; ?>" class="btn">Baca Selengkapnya →</a>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>

            <?php if ($count == 0): ?>
            <div class="alert alert-info" style="text-align: center; margin-top: 2rem;">
                <p>Belum ada berita yang dipublikasikan.</p>
            </div>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>&copy; <?= date('Y') ?> <?= htmlspecialchars($profil['nama_sekolah'], ENT_QUOTES, 'UTF-8'); ?>. @Nnext</p>
    </footer>

</body>
</html>
