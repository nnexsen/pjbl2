<?php
require 'koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$profil = mysqli_fetch_assoc(
    mysqli_query($conn,
    "SELECT * FROM profil WHERE id = 1")
);

// =========================
// CEK ID
// =========================
if (
    !isset($_GET['id']) ||
    !is_numeric($_GET['id'])
) {

    header("Location: dashboard.php");
    exit;
}

$id = (int) $_GET['id'];

// =========================
// AMBIL DATA GALERI
// =========================
$stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM galeri WHERE id = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$data = mysqli_fetch_assoc($result);

// =========================
// KALAU DATA TIDAK ADA
// =========================
if (!$data) {

    header("Location: dashboard.php");
    exit;
}

// =========================
// UPDATE GALERI
// =========================
if (isset($_POST['update'])) {

    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];

    $file = $_FILES['gambar']['name'];

    // =====================
    // JIKA UPLOAD FOTO BARU
    // =====================
    if ($file != "") {

        $gambarBaru = time() . "_" . $file;

        move_uploaded_file(
            $_FILES['gambar']['tmp_name'],
            "assets/uploads/galeri/" . $gambarBaru
        );

        // hapus gambar lama
        if ($data['gambar']) {

            unlink(
                "assets/uploads/galeri/" .
                $data['gambar']
            );
        }

        $stmt = mysqli_prepare(
            $conn,
            "UPDATE galeri
            SET judul = ?,
                deskripsi = ?,
                gambar = ?
            WHERE id = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "sssi",
            $judul,
            $deskripsi,
            $gambarBaru,
            $id
        );

    } else {

        // =====================
        // TANPA GANTI FOTO
        // =====================
        $stmt = mysqli_prepare(
            $conn,
            "UPDATE galeri
            SET judul = ?,
                deskripsi = ?
            WHERE id = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "ssi",
            $judul,
            $deskripsi,
            $id
        );
    }

    mysqli_stmt_execute($stmt);

    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0">

    <title>Edit Galeri</title>

    <link
    rel="stylesheet"
    href="assets/css/style.css">

</head>

<body>

<div class="grid-container">

    <nav>

        <a href="dashboard.php">

            &larr; Kembali

        </a>

    </nav>

    <main class="full-width">

        <h2>Edit Galeri</h2>

        <form
        method="POST"
        enctype="multipart/form-data">

            <div class="form-group">

                <label>Judul Foto</label>

                <input
                type="text"
                name="judul"
                value="<?= $data['judul']; ?>"
                required>

            </div>

            <div class="form-group">

                <label>Deskripsi</label>

                <textarea
                name="deskripsi"
                rows="5"><?= $data['deskripsi']; ?></textarea>

            </div>

            <div class="form-group">

                <label>Foto Saat Ini</label>

                <br>

                <img
                src="assets/uploads/galeri/<?= $data['gambar']; ?>"
                width="200">

            </div>

            <div class="form-group">

                <label>Ganti Foto</label>

                <input
                type="file"
                name="gambar">

            </div>

            <button
            type="submit"
            name="update">

                Update Galeri

            </button>

        </form>

    </main>

</div>

</body>
</html>