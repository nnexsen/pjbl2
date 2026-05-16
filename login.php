<?php
session_start();
require 'koneksi.php';


$profil = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM profil WHERE id = 1"));

$login_error = '';
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = mysqli_prepare($conn, "SELECT * FROM admin WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $query = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($query);

    if($data){
        if(password_verify($password, $data['password'])){
            $_SESSION['admin'] = $username;
            header("Location: dashboard.php");
            exit;
        } else {
            $login_error = "Password salah";
        }
    } else {
        $login_error = "Username tidak ada";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - <?= htmlspecialchars($profil['nama_sekolah'], ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .login-wrapper {
            width: 100%;
            max-width: 450px;
            padding: 2rem;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
            color: white;
        }

        .login-header img {
            height: 80px;
            margin-bottom: 1rem;
            filter: brightness(0) invert(1);
        }

        .login-header h1 {
            font-size: 1.5rem;
            margin: 0;
            font-weight: 700;
        }

        .login-header p {
            margin: 0.5rem 0 0 0;
            opacity: 0.9;
        }

        .login-container {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .login-form {
            padding: 2rem;
        }

        .login-form h2 {
            color: var(--primary-color);
            font-size: 1.5rem;
            margin: 0 0 1.5rem 0;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--text-dark);
            font-weight: 600;
            font-size: 0.95rem;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid var(--border-light);
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }

        .login-form button {
            width: 100%;
            padding: 0.9rem;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .login-form button:hover {
            box-shadow: 0 10px 25px rgba(30, 64, 175, 0.3);
            transform: translateY(-2px);
        }

        .login-error {
            background-color: rgba(239, 68, 68, 0.1);
            color: #7f1d1d;
            border: 2px solid var(--danger);
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        .back-to-home {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-light);
        }

        .back-to-home a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .back-to-home a:hover {
            color: var(--primary-dark);
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-header">
            <img src="assets/img/<?= htmlspecialchars($profil['logo'], ENT_QUOTES, 'UTF-8'); ?>" alt="Logo">
            <h1><?= htmlspecialchars($profil['nama_sekolah'], ENT_QUOTES, 'UTF-8'); ?></h1>
            <p>Portal Admin Sekolah</p>
        </div>

        <div class="login-container">
            <div class="login-form">
                <h2> Login Admin</h2>

                <?php if (!empty($login_error)): ?>
                <div class="login-error">
                    ⚠️ <?= htmlspecialchars($login_error, ENT_QUOTES, 'UTF-8'); ?>
                </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="form-group">
                        <label for="username"> Username</label>
                        <input type="text" id="username" name="username" placeholder="Masukkan username" required>
                    </div>

                    <div class="form-group">
                        <label for="password"> Password</label>
                        <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                    </div>

                    <button type="submit" name="login"> Login Sekarang</button>
                </form>

                <div class="back-to-home">
                    <a href="index.php">← Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
