<?php
require 'koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$profil = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM profil WHERE id = 1")
);

// =========================
// HAPUS BERITA
// =========================
if (isset($_GET['hapus_berita'])) {

    $id = (int) $_GET['hapus_berita'];

    $stmt = mysqli_prepare(
        $conn,
        "SELECT * FROM berita WHERE id = ?"
    );

    mysqli_stmt_bind_param($stmt, "i", $id);

    mysqli_stmt_execute($stmt);

    $data = mysqli_fetch_assoc(
        mysqli_stmt_get_result($stmt)
    );

    if (!empty($data['gambar'])) {

        $path = "assets/uploads/" . $data['gambar'];

        if (file_exists($path)) {
            unlink($path);
        }
    }

    $stmt = mysqli_prepare(
        $conn,
        "DELETE FROM berita WHERE id = ?"
    );

    mysqli_stmt_bind_param($stmt, "i", $id);

    mysqli_stmt_execute($stmt);

    header("Location: dashboard.php");
    exit;
}

// =========================
// HAPUS GALERI
// =========================
if (isset($_GET['hapus_galeri'])) {

    $id = (int) $_GET['hapus_galeri'];

    $stmt = mysqli_prepare(
        $conn,
        "SELECT * FROM galeri WHERE id = ?"
    );

    mysqli_stmt_bind_param($stmt, "i", $id);

    mysqli_stmt_execute($stmt);

    $data = mysqli_fetch_assoc(
        mysqli_stmt_get_result($stmt)
    );

    if (!empty($data['gambar'])) {

        $path = "assets/uploads/galeri/" . $data['gambar'];

        if (file_exists($path)) {
            unlink($path);
        }
    }

    $stmt = mysqli_prepare(
        $conn,
        "DELETE FROM galeri WHERE id = ?"
    );

    mysqli_stmt_bind_param($stmt, "i", $id);

    mysqli_stmt_execute($stmt);

    header("Location: dashboard.php");
    exit;
}

// =========================
// TAMBAH BERITA
// =========================
if (isset($_POST['submit_berita'])) {

    $judul = $_POST['judul'];
    $isi = $_POST['isi'];

    $gambar = $_FILES['gambar_berita']['name'];

    if ($gambar != "") {

        $tmp = $_FILES['gambar_berita']['tmp_name'];

        $mime = mime_content_type($tmp);

        $allowedMime = [
            'image/jpeg',
            'image/png'
        ];

        if (!in_array($mime, $allowedMime)) {
            die("File tidak valid");
        }

        $ext = strtolower(
    pathinfo($gambar, PATHINFO_EXTENSION)
);

$allowed = ['jpg', 'jpeg', 'png'];

if (!in_array($ext, $allowed)) {

    die("Foto harus jpg, jpeg, atau png");

}

        $uploadDir = "assets/uploads/";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $img = time() . "." . $ext;

        if (!move_uploaded_file(
            $tmp,
            $uploadDir . $img
        )) {
            die("Upload gagal");
        }

        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO berita (judul, isi, gambar)
            VALUES (?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "sss",
            $judul,
            $isi,
            $img
        );

    } else {

        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO berita (judul, isi)
            VALUES (?, ?)"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "ss",
            $judul,
            $isi
        );
    }

    mysqli_stmt_execute($stmt);

    header("Location: dashboard.php");
    exit;
}

// =========================
// TAMBAH GALERI
// =========================
if (isset($_POST['submit_galeri'])) {

    $judul = $_POST['judul_galeri'];
    $deskripsi = $_POST['deskripsi'];

    $gambar = $_FILES['gambar_galeri']['name'];

    $tmp = $_FILES['gambar_galeri']['tmp_name'];

    $mime = mime_content_type($tmp);

    $allowedMime = [
        'image/jpeg',
        'image/png'
    ];

    if (!in_array($mime, $allowedMime)) {
        die("File tidak valid");
    }

    $ext = strtolower(
    pathinfo($gambar, PATHINFO_EXTENSION)
);

$allowed = ['jpg', 'jpeg', 'png'];

if (!in_array($ext, $allowed)) {

    die("Foto harus jpg, jpeg, atau png");

}

    $uploadDir = "assets/uploads/galeri/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $namaBaru = time() . "." . $ext;

    if (!move_uploaded_file(
        $tmp,
        $uploadDir . $namaBaru
    )) {
        die("Upload gagal");
    }

    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO galeri
        (judul, gambar, deskripsi, tanggal_upload)
        VALUES (?, ?, ?, NOW())"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "sss",
        $judul,
        $namaBaru,
        $deskripsi
    );

    mysqli_stmt_execute($stmt);

    header("Location: dashboard.php");
    exit;
}

// =========================
// QUERY DATA
// =========================
$queryBerita = mysqli_query(
    $conn,
    "SELECT * FROM berita ORDER BY id DESC"
);

$queryGaleri = mysqli_query(
    $conn,
    "SELECT * FROM galeri ORDER BY id DESC"
);

if (isset($_POST['update'])) {

    $n = $_POST['nama'];
    $a = $_POST['alamat'];
    $v = $_POST['visi'];
    $m = $_POST['misi'];
    $s = $_POST['sejarah'];

    $logo = $_FILES['logo']['name'];

    // =========================
    // JIKA UPLOAD LOGO BARU
    // =========================
    if ($logo != "") {

        $tmp = $_FILES['logo']['tmp_name'];

        $mime = mime_content_type($tmp);

        $allowedMime = [
            'image/jpeg',
            'image/png'
        ];

        if (!in_array($mime, $allowedMime)) {
            die("File tidak valid");
        }

        $ext = strtolower(
            pathinfo($logo, PATHINFO_EXTENSION)
        );

        $allowed = ['jpg', 'jpeg', 'png'];

        if (!in_array($ext, $allowed)) {

            die("Logo harus jpg, jpeg, atau png");

        }

        $uploadDir = "assets/img/";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $n_logo = time() . "." . $ext;

        if (!move_uploaded_file(
            $tmp,
            $uploadDir . $n_logo
        )) {
            die("Upload gagal");
        }

        // hapus logo lama
        if ($profil['logo']) {

            $path = "assets/img/" . $profil['logo'];

            if (file_exists($path)) {
                unlink($path);
            }

        }

        $stmt = mysqli_prepare(
            $conn,
            "UPDATE profil
            SET nama_sekolah=?,
            alamat=?,
            logo=?,
            visi=?,
            misi=?,
            sejarah=?
            WHERE id=1"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "ssssss",
            $n,
            $a,
            $n_logo,
            $v,
            $m,
            $s
        );

    }

    // =========================
    // JIKA TIDAK UPLOAD LOGO
    // =========================
    else {

        $stmt = mysqli_prepare(
            $conn,
            "UPDATE profil
            SET nama_sekolah=?,
            alamat=?,
            visi=?,
            misi=?,
            sejarah=?
            WHERE id=1"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "sssss",
            $n,
            $a,
            $v,
            $m,
            $s
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

    <title>Dashboard Admin</title>

    <link
    rel="stylesheet"
    href="assets/css/style.css">

</head>

<body>

<div class="grid-container">

    <nav>

        <a href="index.php">Home</a>

        <a href="#berita">Berita</a>

        <a href="#galeri">Galeri</a>

        <a href="#profil">Profil</a>

        <a href="logout.php"
        onclick="return confirm('Logout?')">
            Logout
        </a>

    </nav>

    <main class="full-width">

        <h1>Dashboard Admin</h1>

        <!-- ====================== -->
        <!-- TAMBAH BERITA -->
        <!-- ====================== -->

        <section id="berita">

            <h2>Tambah Berita</h2>

            <form
            method="POST"
            enctype="multipart/form-data">

                <div class="form-group">

                    <label>Judul Berita</label>

                    <input
                    type="text"
                    name="judul"
                    required>

                </div>

                <div class="form-group">

                    <label>Isi Berita</label>

                    <textarea
                    name="isi"
                    rows="5"
                    required></textarea>

                </div>

                <div class="form-group">

                    <label>Gambar</label>

                    <input
                    type="file"
                    name="gambar_berita">

                </div>

                <button
                type="submit"
                name="submit_berita">

                    Simpan Berita

                </button>

            </form>

            <hr>

            <h2>Kelola Berita</h2>

            <table border="1" cellpadding="10">

                <tr>

                    <th>No</th>

                    <th>Judul</th>

                    <th>Aksi</th>

                </tr>

                <?php $no = 1; ?>

                <?php while($b = mysqli_fetch_assoc($queryBerita)) : ?>

                <tr>

                    <td><?= $no++; ?></td>

                    <td><?= htmlspecialchars($b['judul']); ?></td>

                    <td>

                        <a
                        href="edit_berita.php?id=<?= $b['id']; ?>">

                            Edit

                        </a>

                        |

                        <a
                        href="dashboard.php?hapus_berita=<?= $b['id']; ?>"
                        onclick="return confirm('Hapus berita ini?')">

                            Hapus

                        </a>

                    </td>

                </tr>

                <?php endwhile; ?>

            </table>

        </section>

        <hr>

        <!-- ====================== -->
        <!-- GALERI -->
        <!-- ====================== -->

        <section id="galeri">

            <h2>Tambah Galeri</h2>

            <form
            method="POST"
            enctype="multipart/form-data">

                <div class="form-group">

                    <label>Judul Foto</label>

                    <input
                    type="text"
                    name="judul_galeri"
                    required>

                </div>

                <div class="form-group">

                    <label>Deskripsi</label>

                    <textarea
                    name="deskripsi"
                    rows="4"></textarea>

                </div>

                <div class="form-group">

                    <label>Upload Foto</label>

                    <input
                    type="file"
                    name="gambar_galeri"
                    required>

                </div>

                <button
                type="submit"
                name="submit_galeri">

                    Upload Galeri

                </button>

            </form>

            <hr>

            <h2>Kelola Galeri</h2>

            <table border="1" cellpadding="10">

                <tr>

                    <th>No</th>

                    <th>Foto</th>

                    <th>Judul</th>

                    <th>Aksi</th>

                </tr>

                <?php $no = 1; ?>

                <?php while($g = mysqli_fetch_assoc($queryGaleri)) : ?>

                <tr>

                    <td><?= $no++; ?></td>

                    <td>

                        <img
                        src="assets/uploads/galeri/<?= htmlspecialchars($g['gambar']); ?>"
                        width="100">

                    </td>

                    <td><?= htmlspecialchars($g['judul']); ?></td>

                    <td>

                        <a
                        href="edit_galeri.php?id=<?= $g['id']; ?>">

                            Edit

                        </a>

                        |

                        <a
                        href="dashboard.php?hapus_galeri=<?= $g['id']; ?>"
                        onclick="return confirm('Hapus foto ini?')">

                            Hapus

                        </a>

                    </td>

                </tr>

                <?php endwhile; ?>

            </table>

        </section>

        <hr>

<section id="profil">

<h2>Edit Profil Sekolah</h2>

<form
method="POST"
enctype="multipart/form-data">

    <div class="form-group">

        <label>Nama Sekolah</label>

        <input
        type="text"
        name="nama"
        value="<?= htmlspecialchars($profil['nama_sekolah']) ?>"
        required>

    </div>

    <div class="form-group">

        <label>Logo Sekolah</label>

        <input
        type="file"
        name="logo">

    </div>

    <div class="form-group">

        <label>Alamat</label>

        <textarea
        name="alamat"
    rows="3"><?= htmlspecialchars($profil['alamat']) ?></textarea>

    </div>

    <div class="form-group">

        <label>Visi</label>

        <textarea
        name="visi"
    rows="3"><?= htmlspecialchars($profil['visi']) ?></textarea>

    </div>

    <div class="form-group">

        <label>Misi</label>

        <textarea
        name="misi"
    rows="5"><?= htmlspecialchars($profil['misi']) ?></textarea>

    </div>

    <div class="form-group">

        <label>Sejarah</label>

        <textarea
        name="sejarah"
    rows="6"><?= htmlspecialchars($profil['sejarah']) ?></textarea>

    </div>

    <button
    type="submit"
    name="update">

        Simpan Profil

    </button>

</form>
</section>

    </main>


</div>

</body>
</html>