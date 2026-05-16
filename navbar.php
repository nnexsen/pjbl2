<?php
// Navbar Component
if (!isset($profil)) {
    require 'koneksi.php';
    if (!isset($_SESSION)) {
        session_start();
    }
    $profil = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM profil WHERE id = 1"));
}
$current_page = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar">
    <div class="nav-container">
        <!-- Brand Logo and Name -->
        <a href="index.php" class="nav-brand">
            <img src="assets/img/<?= htmlspecialchars($profil['logo'], ENT_QUOTES, 'UTF-8'); ?>" alt="Logo Sekolah">
            <div class="nav-brand-text">
                <h1><?= htmlspecialchars($profil['nama_sekolah'], ENT_QUOTES, 'UTF-8'); ?></h1>
            </div>
        </a>

        <!-- Navigation Menu (Center) -->
        <div class="nav-menu">
            <a href="index.php" class="<?= $current_page == 'index.php' ? 'active' : '' ?>"> Home</a>
            <a href="seluruh_berita.php" class="<?= $current_page == 'seluruh_berita.php' ? 'active' : '' ?>"> Berita</a>
            <a href="galeri.php" class="<?= $current_page == 'galeri.php' ? 'active' : '' ?>"> Galeri</a>
        </div>

        <!-- Login/User Section (Right) -->
        <div class="nav-right">
            <?php if (isset($_SESSION['admin'])): ?>
                <div class="user-info">
                    <a href="dashboard.php" class="btn-login" style="padding: 0.5rem 1rem; font-size: 0.9rem;"> Dashboard</a>
                    <a href="logout.php" class="btn-logout"> Logout</a>
                </div>
            <?php else: ?>
                <a href="login.php" class="btn-login"> Log In</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
