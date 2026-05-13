<?php
require 'koneksi.php';

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = mysqli_prepare($conn,
        "SELECT * FROM admin WHERE username = ?"
    );

    mysqli_stmt_bind_param($stmt, "s", $username);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $data = mysqli_fetch_assoc($result);

    if ($data) {

        if (password_verify($password, $data['password'])) {

            $_SESSION['admin'] = $username;

            header("Location: dashboard.php");
            exit();

        } else {

            echo "<script>alert('Periksa Username atau Password!');</script>";

        }

    } else {

        echo "<script>alert('Periksa Username atau Password!');</script>";

    }
}
?>

<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Admin</title>
        <link rel="stylesheet" href="assets/css/style.css">
    </head>

    <body>
        <div class="login-container">
            <h2>Login Admin</h2>
            <form method="POST" action="">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">Login</button>
            </form>
        </div>
    </body>